<?php
/**
 *
 */
class Activity
{
  public $id;
  public $name;
  public $owner;

    private $db;


  function __construct()
  {
    global $wpdb;
    $this->db = $wpdb;

    # code...
  }

  public function getall(){
		$this->db->query('SELECT * FROM activity ');
		// $this->db->bind(':id',$id);
		$this->db->execute();

		$dataset = $this->db->resultset();

		return $dataset;

		// $this->id = $dataset['id'];
		// $this->name = $dataset['name'];


	}
  public function countActivitiesFromProjectID($id){
    $this->db->query('SELECT count(*) as n FROM activity where projectid =:id');
		$this->db->bind(':id',$id);
		$this->db->execute();

		$dataset = $this->db->single();

		return $dataset;


    return "f";
  }

  public function getActFromProjectID($project_id){

    $this->db->query('SELECT * FROM activity where projectid = :project_id');
		$this->db->bind(':project_id',$project_id);
		$this->db->execute();

		$dataset = $this->db->resultset();

    return $dataset;
  }

  public function addactivity($activity_name,$id)
	{

		$id = trim($id);
		if($activity_name != null){

			try {
				$this->db->query('INSERT INTO (id, name, projectid, status) VALUES (NULL,:name, :id, "1");');
				$this->db->bind(':name',$activity_name);
				$this->db->bind(':id',$id);
				$this->db->execute();

				return 1;

			} catch (Exception $e) {


				echo "<a class='btn btnback  btn-warning' href='./'>กลับสู่หน้าหลัก</a><br>";
				echo "<pre id='prewarncontent'> ไม่สามารถ เพิ่มกิจกรรมได้</pre>";

			}


		}else{
		echo "error activity name is null";

		}
	}


}

 ?>
