<?php
class Log{
	private $db;

    public function __construct() {
    	global $wpdb;
    	$this->db = $wpdb;
    }

    public function save($cid,$action,$url,$note){
    	$this->db->query('INSERT INTO log(cid,action,note,url,create_time,ip) VALUE(:cid,:action,:note,:url,:create_time,:ip)');
		$this->db->bind(':cid',$cid);
		$this->db->bind(':action',$action);
		$this->db->bind(':note',$note);
		$this->db->bind(':url',$url);
		$this->db->bind(':ip',$this->db->GetIpAddress());
		$this->db->bind(':create_time' ,date('Y-m-d H:i:s'));
		$this->db->execute();
		return $this->db->lastInsertId();
    }
}
?>
