<?php
class User{
	public $id;
	public $username;
	public $name;
    public $prename;
	public $cid;
	private $password;
    private $key = 'bRuD5WYw5wd0rdHR9yLlM6wt2vteuiniQBqE70nAuhU=';

	private $db;

    public function __construct() {
    	global $wpdb;
    	$this->db = $wpdb;
    }

    public function get($cid){
    	$this->db->query('SELECT UserID,Username,Password,Name,ID_CARD FROM member WHERE ID_CARD = :cid');
		$this->db->bind(':cid',$cid);
		$this->db->execute();
		$dataset = $this->db->single();

		$this->id 		= $dataset['UserID'];
		$this->username = $dataset['Username'];
		$this->name 	= $dataset['Name'];
		$this->cid 		= $dataset['ID_CARD'];
		$this->password = $dataset['Password'];
        $this->prename  = $this->getPrename($this->cid);
    }

    public function getPrename($cid){
        $this->db->query('SELECT TITLE FROM tsalary WHERE ID_CARD = :cid LIMIT 1');
        $this->db->bind(':cid',$cid);
        $this->db->execute();
        $dataset = $this->db->single();
        return $dataset['TITLE'];
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
            $user_browser   = $_SERVER['HTTP_USER_AGENT'];

            $this->get($this->Decrypt($user_id));

            if(!empty($this->cid)){
                $login_check = hash('sha512',$this->password.$user_browser);

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

    public function login($username,$password){
        // $email          = filter_var(strip_tags(trim($email)),FILTER_SANITIZE_EMAIL);
        $username 		= trim($username);
        $password       = trim($password);
        $cookie_time    = time() + 3600 * 24 * 12; // Cookie Time (1 year)

        // GET USER DATA BY EMAIL
        $this->db->query('SELECT ID_CARD cid,password FROM member WHERE username = :username');
		$this->db->bind(':username',$username);
		$this->db->execute();
		$user_data = $this->db->single();

		if(true){
			if($password == $user_data['password']){
				// PASSWORD IS CORRECT!
				$user_browser = $_SERVER['HTTP_USER_AGENT'];

				// XSS protection as we might print this value
				$user_id = preg_replace("/[^0-9]+/",'',$user_data['cid']);
				// Encrypt UserID before send to cookie.
				$user_id = $this->Encrypt($user_id);

				// SET SESSION AND COOKIE
				$_SESSION['user_id'] = $user_id;
				setcookie('user_id',$user_id,$cookie_time);
				$_SESSION['login_string'] = hash('sha512',$user_data['password'].$user_browser);
				setcookie('login_string',hash('sha512',$user_data['password'].$user_browser),$cookie_time);

				// Save log to attempt : [successful]
				// parent::recordAttempt($user_data['id'],'successful');

				return 1; // LOGIN SUCCESS
			}else{
				// Save log to attempt : [fail]
				// if(!empty($user_data['id'])){
				// 	$this->recordAttempt($user_data['id']); // Login failure!
				// }

				return 0; // LOGIN FAIL!
			}
		}else{
			return -1; // ACCOUNT LOCKED!
		}
        // Note: crypt — One-way string hashing (http://php.net/manual/en/function.crypt.php)
    }

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

    public function register($email,$fullname,$password){

        $email      = filter_var(strip_tags(trim($email)),FILTER_SANITIZE_EMAIL);
        // Random password if password is empty value
        $password   = (empty($password)?hash('sha512',uniqid(mt_rand(1,mt_getrandmax()),true)):$password);
        $salt       = hash('sha512',uniqid(mt_rand(1,mt_getrandmax()),true));
        // Create salted password
        $password   = hash('sha512',$password.$salt);

        $name = explode(' ',strip_tags(trim($fullname)));
        $fname = trim($name[0]);
        $lname = trim($name[1]);

        if($this->userAlready($email)){
            parent::query('INSERT INTO user(email,fname,lname,password,salt,type,ip,register_time,visit_time) VALUE(:email,:fname,:lname,:password,:salt,:type,:ip,:register_time,:visit_time)');
            parent::bind(':email'       ,$email);
            parent::bind(':fname'       ,$fname);
            parent::bind(':lname'       ,$lname);
            parent::bind(':password'    ,$password);
            parent::bind(':salt'        ,$salt);
            parent::bind(':type'        ,1); // 1 = Normal
            parent::bind(':ip'          ,parent::GetIpAddress());
            parent::bind(':register_time' ,date('Y-m-d H:i:s'));
            parent::bind(':visit_time'  ,date('Y-m-d H:i:s'));
            parent::execute();

            $user_id = parent::lastInsertId();

        }else{
            return 0;
        }

        return $user_id;
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
