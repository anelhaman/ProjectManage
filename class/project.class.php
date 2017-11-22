<?php
class Project{
public $id;
public $name;

	private $db;

    public function __construct() {
    	global $wpdb;
    	$this->db = $wpdb;
    }


	public function getall(){
		$this->db->query('SELECT * FROM project ');
		// $this->db->bind(':id',$id);
		$this->db->execute();

		$dataset = $this->db->resultset();

		return $dataset;

		// $this->id = $dataset['id'];
		// $this->name = $dataset['name'];


	}
	public function addproject($project_name)
	{
		if($project_name != null){

			try {
				$this->db->query('INSERT INTO project (id, name, a, b) VALUES (NULL, :name, "", "")');
				$this->db->bind(':name',$project_name);
				$this->db->execute();

				return 1;
				
			} catch (Exception $e) {
				
				
				echo "<a class='btn btn-warning' href='./'>กลับสู่หน้าหลัก</a><br>";
				echo "<pre> ไม่สามารถ เพิ่มโครงการได้</pre>";
				
			}
			


		}else{
		echo "error project name is null";
		
		}
	}
	

}

	

?>