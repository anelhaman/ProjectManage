<?php
class User{
    public $id;
	public $tel;
    private $password;
	public $name;
    public $lastname;

	private $db;

    public function __construct() {
    	global $wpdb;
    	$this->db = $wpdb;




    }

    public function get($cid){
    	$this->db->query('SELECT * FROM user WHERE id = :cid');
		$this->db->bind(':cid',$cid);
		$this->db->execute();
		$dataset = $this->db->single();

		$this->id 		= $dataset['id'];
		$this->username = $dataset['Username'];
		$this->name 	= $dataset['Name'];
		$this->cid 		= $dataset['ID_CARD'];
		$this->password = $dataset['pass'];
       //  $this->prename  = $this->getPrename($this->cid);

        //print_r($dataset);
    }


    public function changePassword($cid,$oldpassword,$newpassword){
    	$this->db->query('UPDATE member SET Password = :newpassword WHERE ID_CARD = :cid AND password = :oldpassword');
		$this->db->bind(':cid',$cid);
		$this->db->bind(':newpassword',$newpassword);
        $this->db->bind(':oldpassword',$oldpassword);
		$this->db->execute();
    }

    public function sec_session_start() {
        $session_name   = 'sec_session_id';   // Set a custom session name
        $secure         = false;
        // session.cookie_secure specifies whether cookies should only be sent over secure connections. (https)

        // This stops JavaScript being able to access the session id.
        $httponly = true;

        // Forces sessions to only use cookies.
        if(ini_set('session.use_only_cookies', 1) === FALSE) {
            header("Location: ../error.php?err=Could_not_initiate_a_safe_session");
            exit();
        }

        // Gets current cookies params.
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params(600,$cookieParams["path"],$cookieParams["domain"],$secure,$httponly);
        // session_set_cookie_params('600'); // 10 minutes.

        // Sets the session name to the one set above.
        session_name($session_name);
        session_start();             // Start the PHP session
        // session_regenerate_id(true); // regenerated the session, delete the old one.
    }

    public function loginChecking(){
        // READ COOKIES
        // if(!empty($_COOKIE['user_id']) && empty($_SESSION['user_id']))
        // 	$_SESSION['user_id'] = $_COOKIE['user_id'];
        // if(!empty($_COOKIE['login_string']) && empty($_SESSION['login_string']))
        // 	$_SESSION['login_string'] = $_COOKIE['login_string'];

        // Check if all session variables are set
        if(isset($_SESSION['user_id'],$_SESSION['login_string'])){

            $user_id        = $_SESSION['user_id'];
            $login_string   = $_SESSION['login_string'];

            // Get the user-agent string of the user.
           // $user_browser   = $_SERVER['HTTP_USER_AGENT'];

            $userid = $this->Decrypt($user_id);

            $this->get($userid);

            if(!empty($this->id)){
                $login_check = hash('sha512',$this->password);


                if($login_check == $login_string){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function login($tel,$password){
            // $email          = filter_var(strip_tags(trim($email)),FILTER_SANITIZE_EMAIL);

        $tel            = trim($tel);
        $password       = trim($password);
        $password       = hash('sha512',$password);
        $cookie_time    = time() + 3600 * 24 * 12; // Cookie Time (1 year)

        // GET USER DATA BY EMAIL
        $this->db->query('SELECT id,tel,pass FROM user WHERE tel = :tel');
        $this->db->bind(':tel',$tel);
        $this->db->execute();
        $user_data = $this->db->single();



        if(true){
            if($password == $user_data['pass']){
                // PASSWORD IS CORRECT!
               // $user_browser = $_SERVER['HTTP_USER_AGENT'];

                // XSS protection as we might print this value
                $user_id = preg_replace("/[^0-9]+/",'',$user_data['id']);
                // Encrypt UserID before send to cookie.
                $user_id = $this->Encrypt($user_id);

                // SET SESSION AND COOKIE
                $_SESSION['user_id'] = $user_id;
                setcookie('user_id',$user_id,$cookie_time);
                $_SESSION['login_string'] = hash('sha512',$user_data['pass']);
                setcookie('login_string',hash('sha512',$user_data['pass']),$cookie_time);

                // Save log to attempt : [successful]
                // parent::recordAttempt($user_data['id'],'successful');

                return 1; // LOGIN SUCCESS
            }else{
                // Save log to attempt : [fail]
                // if(!empty($user_data['id'])){
                //  $this->recordAttempt($user_data['id']); // Login failure!
                // }

                return 0; // LOGIN FAIL!
            }
        }else{
            return -1; // ACCOUNT LOCKED!
        }    }

    // private function Encrypt($data){
    //     $password = $this->cookie_salt;
    //     $salt = substr(md5(mt_rand(), true), 8);
    //     $key = md5($password . $salt, true);
    //     $iv  = md5($key . $password . $salt, true);
    //     $ct = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, $iv);
    //     return base64_encode('Salted__' . $salt . $ct);
    // }

    // private function Decrypt($data){
    //     $password = $this->cookie_salt;
    //     $data = base64_decode($data);
    //     $salt = substr($data, 8, 8);
    //     $ct   = substr($data, 16);
    //     $key = md5($password . $salt, true);
    //     $iv  = md5($key . $password . $salt, true);
    //     $pt = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ct, MCRYPT_MODE_CBC, $iv);
    //     return $pt;
    // }

    private function Encrypt($data){
        $key = $this->key;
        $password = $this->cookie_salt;
        $encryption_key = base64_decode($key.$password);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }
    private function Decrypt($data){
        $key = $this->key;
        $password = $this->cookie_salt;
        $encryption_key = base64_decode($key.$password);
        list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
    }

    public function register($tel,$password,$name,$lastname){

        
      

        $password   = hash('sha512',$password);

        if($this->userAlready($tel)){
           $this->db->query('
                INSERT INTO `mydb`.`user` (`tel`, `pass`, `name`, `last`, `time`) 
                VALUES ( :tel, :password, :name, :lastname, :register_time);');
            $this->db->bind(':tel'         ,$tel);
            $this->db->bind(':password'    ,$password);
            $this->db->bind(':name'        ,$name);
            $this->db->bind(':lastname'    ,$lastname);
            $this->db->bind(':register_time' ,date('Y-m-d H:i:s'));
            $this->db->execute();

            $user_id = $this->db->lastInsertId();

            $userTel = $this->getTelfromId($user_id);

        }else{
            return 0;
        }

        return $userTel;
    }
    private function userAlready($tel){

        $this->db->query('SELECT * FROM `user` WHERE tel = :tel');   
        $this->db->bind(':tel',$tel); 
        $this->db->execute();
        $dataset = $this->db->single();
        
        if(empty($dataset['tel'])) return true;
        else return false;
    }
     public function getTelfromId($id){

        $this->db->query('SELECT tel FROM `user` WHERE id = :id');   
        $this->db->bind(':id',$id); 
        $this->db->execute();
        $dataset = $this->db->single();
        
        return ($dataset['tel']); 
    }
     public function getIdfromTel($tel){

        $this->db->query('SELECT id FROM `user` WHERE tel = :tel');   
        $this->db->bind(':tel',$tel); 
        $this->db->execute();
        $dataset = $this->db->single();
        
        return ($dataset['id']); 
    }
    public function getId(){
            return $this->id;
    }
    public function getPassfromId($id){

        $this->db->query('SELECT * FROM `user` WHERE tel = :id');   
        $this->db->bind(':id',$id); 
        $this->db->execute();
        $dataset = $this->db->single();
        return $dataset['pass'];
    }

  //   public function listContent($article_id){
  //   	$this->db->query('SELECT * FROM content WHERE article_id = :article_id AND status = "active" ORDER BY position ASC');
		// $this->db->bind(':article_id',$article_id);
		// $this->db->execute();
		// $dataset = $this->db->resultset();

		// return $dataset;
  //   }

  //   public function create($title){
  //   	$this->db->query('INSERT INTO article(title,create_time) VALUE(:title,:create_time)');
		// $this->db->bind(':title',$title);
		// $this->db->bind(':create_time',date('Y-m-d H:i:s'));
		// $this->db->execute();
		// $this->db->lastInsertId();
  //   }
}
?>
