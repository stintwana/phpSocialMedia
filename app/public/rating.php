<?php
class rating{
	private $host  = 'konneck_mysql_1';
    private $user  = 'root';
    private $password   = "Stintw@n@66002919";
    private $database  = "distaxs";    
	private $members_table = 'members';
	private $itemTable = 'item';	
    private $user_rating_table = 'user_rating';
	private $dbConnect = false;
    public function __construct(){
        if(!$this->dbConnect){ 
            $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            }else{
                $this->dbConnect = $conn;
            }
        }
    }
	private function get_data($sql_query)  {
		$result = mysqli_query($this->dbConnect, $sql_query);
		if(!$result){
			die('Error in query: '. mysqli_error($this->dbConnect));
		}
		$data= array();
		while ($row = $result->fetch_assoc()) {
			$data[]=$row;            
		}
		return $data;
	}
	private function get_num_rows($sql_query) {
		$result = mysqli_query($this->dbConnect, $sql_query);
		if(!$result){
			echo "error";
		}
		$num_rows = mysqli_num_rows($result);
		return $num_rows;
	}	
	public function user_login($user_token, $password){
		$sql_query = "
			SELECT * 
			FROM ".$this->members_table." 
			WHERE user_token='".$user_token."' AND pass='".$password."'";
        return  $this->get_data($sql_query);
	}		
	public function get_user_list(){
		$sql_query = "
			SELECT * FROM ".$this->members_table;
		return  $this->get_data($sql_query);	
	}
	public function get_user($user_token){
		$sql_query = "
			SELECT * FROM ".$this->members_table."
			WHERE user_token='".$user_token."'";
		return  $this->get_data($sql_query);	
	}
	public function get_user_rating($user_token){
		$sql_query = "
			SELECT r.user_rating_id, r.user_token, u.user, r.user_rating_number, r.title, r.comments, r.created, r.modified
			FROM ".$this->user_rating_table." as r
			LEFT JOIN ".$this->members_table." as u ON (r.user_token = u.user_token)
			WHERE r.user_token = '".$user_token."'";
		return  $this->get_data($sql_query);		
	}
	public function get_rating_average($user_token){
		$user_rating = $this->get_user_rating($user_token);
		$rating_number = 0;
		$count = 0;		
		foreach($user_rating as $user_rating_details){
			$rating_number+= $user_rating_details['user_rating_number'];
			$count += 1;			
		}
		$average = 0;
		if($rating_number && $count) {
			$average = $rating_number/$count;
		}
		return $average;	
	}
	public function save_rating($POST, $user_token){		
		$insert_rating = "INSERT INTO ".$this->user_rating_table." (user_rating_id, user_token, user_rating_number, title, comments, created, modified) 
		VALUES (NULL,'".$user_token."', '".$POST['rating']."', '".$POST['title']."', '".$POST["comment"]."', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."')";
		mysqli_query($this->dbConnect, $insert_rating);	
	}
}
?>