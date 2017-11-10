<?php
class Money{

	public $id;
	public $article_id;
	public $message;
	public $image_file;
	public $image_alt;
	public $create_time;
	public $type;

	public $name;
	public $month;
	public $dccode;
	public $pgcode;
	public $bank_account;
	public $salary_money;
	public $salary_id;

	private $db;

    public function __construct() {
    	global $wpdb;
    	$this->db = $wpdb;
    }

    public function listAll($cid){
    	$this->db->query('SELECT CODE,NAME,SURNAME,NETTOTAL,MONTH,YEAR FROM tsalary WHERE ID_CARD = :cid GROUP BY MONTH,YEAR ORDER BY YEAR DESC,MONTH DESC');
		$this->db->bind(':cid',$cid);
		$this->db->execute();
		$dataset = $this->db->resultset();

		foreach ($dataset as $k => $var){
			$dataset[$k]['MONTH_NAME'] 	= $this->db->toMonth($var['MONTH']);
			$dataset[$k]['YEAR'] 		= $this->db->toThaiYear($var['YEAR']);
		}
		return $dataset;
    }

    public function get($cid,$month,$yaer){
    	$this->db->query('SELECT * FROM tsalary WHERE ID_CARD = :cid AND MONTH = :month AND YEAR = :year');
		$this->db->bind(':cid',$cid);
		$this->db->bind(':month',$month);
		$this->db->bind(':year',$yaer);
		$this->db->execute();
		$dataset = $this->db->single();

		$this->name 		= $dataset['NAME'].' '.$dataset['SURNAME'];
		$this->month 		= $this->db->toMonth($dataset['MONTH']).' '.$this->db->toThaiYear($dataset['YEAR']);
		$this->dccode 		= $dataset['DCODE'];
		$this->pgcode 		= $dataset['PGCODE'];
		$this->bank_account = substr($dataset["ACCOUNT_NO"],0,3)."-".substr($dataset["ACCOUNT_NO"],3,1)."-".substr($dataset["ACCOUNT_NO"],4,5)."-".substr($dataset["ACCOUNT_NO"],9,1);
		$this->salary_money = number_format($dataset['PERMONTH'],2);
		$this->salary_id 	= $dataset['CODE'];

		return $dataset;
    }

  //   public function get($contet_id){
  //   	$this->db->query('SELECT id,article_id,message,image_file,create_time,type FROM content WHERE id = :contet_id');
		// $this->db->bind(':contet_id',$contet_id);
		// $this->db->execute();
		// $dataset = $this->db->single();

		// $this->id = $dataset['id'];
		// $this->article_id = $dataset['article_id'];
		// $this->message = $dataset['message'];
		// $this->image_file = $dataset['image_file'];
		// $this->type = $dataset['type'];
  //   }

  //   public function create($article_id,$type){

  //   	$position = $this->getLastPosition($article_id);

  //   	$this->db->query('INSERT INTO content(article_id,position,create_time,type) VALUE(:article_id,:position,:create_time,:type)');
		// $this->db->bind(':article_id',$article_id);
		// $this->db->bind(':position',++$position);
		// $this->db->bind(':create_time',date('Y-m-d H:i:s'));
		// $this->db->bind(':type',$type);
		// $this->db->execute();
		// return $this->db->lastInsertId();
  //   }
}
?>
