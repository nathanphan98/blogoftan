<?php  
class blog{

	//DB Stuff
	private $conn;
	private $table = "blog_post";

	//Blog Properties
	public $n_blog_post_id;
	public $n_category_id;
	public $v_post_title;
	public $v_post_meta_title;
	public $v_post_path;
	public $v_post_summary;
	public $v_post_content;
	public $v_main_image_url;
	public $v_second_image_url;
	public $v_alt_image_url;
	public $n_blog_post_views;
	public $f_post_status;
	public $d_date_created;
	public $d_time_created;
	public $d_date_updated;
	public $d_time_updated;
	public $n_user_id;

	//Last id insert
	public $last_insert_id;

	//Constructor with DB
	public function __construct($db){
		$this->conn = $db;
	}

	//Read previous record
	public function read_previous(){
		$sql = "SELECT * FROM $this->table
				WHERE n_blog_post_id = (SELECT max(n_blog_post_id) 
									   FROM $this->table WHERE n_blog_post_id < :current_id) 
				AND f_post_status = 1";

		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(":current_id",$this->n_blog_post_id);
		$stmt->execute();

		return $stmt;
	}

	//Read next record
	public function read_next(){
		$sql = "SELECT * FROM $this->table
				WHERE n_blog_post_id = (SELECT min(n_blog_post_id) 
									   FROM $this->table WHERE n_blog_post_id > :current_id) 
				AND f_post_status = 1";

		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(":current_id",$this->n_blog_post_id);
		$stmt->execute();

		return $stmt;
	}

	//Read multi records
	public function read(){
		$sql = "SELECT * FROM $this->table ORDER BY $this->table.n_blog_post_id DESC";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();

		return $stmt;
	}
	//Read multi records
	public function read_client(){
		$sql = "SELECT * FROM $this->table where f_post_status = 1 ORDER BY $this->table.n_blog_post_id DESC";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();

		return $stmt;
	}

	public function read_blog_by_page($blog_from, $offset ,$key){
		$sql = "SELECT * FROM $this->table join blog_tags on $this->table.n_blog_post_id = blog_tags.n_blog_post_id WHERE f_post_status = 1 and v_post_title like '%$key%' or v_tag like '%$key%' ORDER BY $this->table.n_blog_post_id DESC LIMIT $blog_from, $offset";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();

		return $stmt;
	}

	//search blogs
	public function read_search_bar($key){
		$sql = "SELECT * FROM $this->table join blog_tags on $this->table.n_blog_post_id = blog_tags.n_blog_post_id where v_post_title like '%$key%' or v_tag like '%$key%'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();

		return $stmt;
	}

	public function read_popular(){
		$sql = "SELECT * FROM $this->table order by n_blog_post_views DESC limit 3";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();

		return $stmt;
	}

	//Read records by user id
	public function read_by_user_id(){
		$sql = "SELECT * FROM $this->table where n_user_id=:get_user_id ORDER BY $this->table.n_blog_post_id DESC";

		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':get_user_id',$this->n_user_id);
		$stmt->execute();

		return $stmt;
	}

	//Read one category
	public function read_single_category(){
		$sql = "SELECT * FROM $this->table 
				WHERE n_category_id = :get_id";

		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':get_id',$this->n_category_id);
		$stmt->execute();

		return $stmt;					
	}

	//Read one record
	public function read_single(){
		$sql = "SELECT * FROM $this->table 
				WHERE n_blog_post_id = :get_id";

		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':get_id',$this->n_blog_post_id);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		//Set Properties
		$this->n_blog_post_id = $row['n_blog_post_id'];
		$this->n_category_id=$row['n_category_id'];
		$this->v_post_title=$row['v_post_title'];
		$this->v_post_meta_title=$row['v_post_meta_title'];
		$this->v_post_path=$row['v_post_path'];
		$this->v_post_summary=$row['v_post_summary'];
		$this->v_post_content=$row['v_post_content'];
		$this->v_main_image_url=$row['v_main_image_url'];
		$this->v_second_image_url=$row['v_second_image_url'];
		$this->v_alt_image_url=$row['v_alt_image_url'];
		$this->n_blog_post_views=$row['n_blog_post_views'];
		$this->f_post_status=$row['f_post_status'];
		$this->d_date_created=$row['d_date_created'];
		$this->d_time_created=$row['d_time_created'];
		$this->d_date_updated=$row['d_date_updated'];
		$this->d_time_updated=$row['d_time_updated'];
		$this->n_user_id=$row['n_user_id'];
	}

	public function read_single_client(){
		$sql = "SELECT * FROM $this->table 
				WHERE n_blog_post_id = :get_id";

		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':get_id',$this->n_blog_post_id);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		//Set Properties
		$this->n_blog_post_id = $row['n_blog_post_id'];
		$this->n_category_id=$row['n_category_id'];
		$this->v_post_title=$row['v_post_title'];
		$this->v_post_meta_title=$row['v_post_meta_title'];
		$this->v_post_path=$row['v_post_path'];
		$this->v_post_summary=$row['v_post_summary'];
		$this->v_post_content=$row['v_post_content'];
		$this->v_main_image_url=$row['v_main_image_url'];
		$this->v_second_image_url=$row['v_second_image_url'];
		$this->v_alt_image_url=$row['v_alt_image_url'];
		$this->n_blog_post_views=$row['n_blog_post_views'];
		$this->f_post_status=$row['f_post_status'];
		$this->d_date_created=$row['d_date_created'];
		$this->d_time_created=$row['d_time_created'];
		$this->d_date_updated=$row['d_date_updated'];
		$this->d_time_updated=$row['d_time_updated'];
		$this->n_user_id=$row['n_user_id'];

		$this->n_blog_post_views+=1;
		$sqlview="update $this->table set n_blog_post_views = $this->n_blog_post_views where n_blog_post_id =:get_id";
		
		$stmt = $this->conn->prepare($sqlview);
		$stmt->bindParam(':get_id',$this->n_blog_post_id);
		$stmt->execute();
	}

	
	//Create blog_post
	public function create(){
		//Create query
		$query = "INSERT INTO $this->table
		          SET n_category_id = :category_id,
		          	  v_post_title = :post_title,
		          	  v_post_meta_title = :post_meta_title,
		          	  v_post_path = :post_path,
		          	  v_post_summary = :post_summary,
		          	  v_post_content = :post_content,
		          	  v_main_image_url = :main_image,
					  v_second_image_url = :second_image,
		          	  v_alt_image_url = :alt_image,
		          	  n_blog_post_views = :blog_post_views,
		          	  f_post_status = :blog_post_status,
		          	  d_date_created = :date_created,
		          	  d_time_created = :time_created,
					  d_date_updated = :date_created,
		          	  d_time_updated = :time_created,
					  n_user_id = :user_id";		
		//Prepare statement
		$stmt = $this->conn->prepare($query);

		//Clean data
		$this->v_post_title = htmlspecialchars(strip_tags($this->v_post_title));
		$this->v_post_meta_title = htmlspecialchars(strip_tags($this->v_post_meta_title));
		$this->v_post_path = htmlspecialchars(strip_tags($this->v_post_path));
		$this->v_post_summary = htmlspecialchars(strip_tags($this->v_post_summary));
		$this->v_post_content = htmlspecialchars(strip_tags($this->v_post_content));

		//Bind data
		$stmt->bindParam(':category_id',$this->n_category_id);
		$stmt->bindParam(':post_title',$this->v_post_title);
		$stmt->bindParam(':post_meta_title',$this->v_post_meta_title);
		$stmt->bindParam(':post_path',$this->v_post_path);
		$stmt->bindParam(':post_summary',$this->v_post_summary);
		$stmt->bindParam(':post_content',$this->v_post_content);
		$stmt->bindParam(':main_image',$this->v_main_image_url);
		$stmt->bindParam(':second_image',$this->v_second_image_url);
		$stmt->bindParam(':alt_image',$this->v_alt_image_url);
		$stmt->bindParam(':blog_post_views',$this->n_blog_post_views);
		$stmt->bindParam(':blog_post_status',$this->f_post_status);		
		$stmt->bindParam(':date_created',$this->d_date_created);
		$stmt->bindParam(':time_created',$this->d_time_created);
		$stmt->bindParam(':date_updated',$this->d_date_created);
		$stmt->bindParam(':time_updated',$this->d_time_created);
		$stmt->bindParam(':user_id',$this->n_user_id);

		//Execute query
		if($stmt->execute()){
			return true;
		}
		//Print error if something goes wrong
		printf("Error: %s. \n", $stmt->error);
		return false;
	}

	//Update blog_post
	public function update(){
		//Create query
		$query = "UPDATE $this->table
		          SET 	n_category_id = :category_id,
						v_post_title = :post_title,
						v_post_meta_title = :post_meta_title,
						v_post_path = :post_path,
						v_post_summary = :post_summary,
						v_post_content = :post_content,
						v_main_image_url = :main_image_url,
						v_second_image_url = :second_image_url,
						v_alt_image_url = :alt_image_url,
						n_blog_post_views = :blog_post_views,
						f_post_status = :post_status,
						d_date_created = :date_created,
						d_time_created = :time_created,
						d_date_updated = :date_updated,
						d_time_updated = :time_updated
		          WHERE 
		          	  	n_blog_post_id = :get_id";

		//Prepare statement
		$stmt = $this->conn->prepare($query);

		//Clean data
		$this->v_post_title = htmlspecialchars(strip_tags($this->v_post_title));
		$this->v_post_meta_title = htmlspecialchars(strip_tags($this->v_post_meta_title));
		$this->v_post_path = htmlspecialchars(strip_tags($this->v_post_path));
		$this->v_post_summary = htmlspecialchars(strip_tags($this->v_post_summary));
		$this->v_post_content = htmlspecialchars(strip_tags($this->v_post_content));
		$this->v_main_image_url = htmlspecialchars(strip_tags($this->v_main_image_url));
		$this->v_second_image_url = htmlspecialchars(strip_tags($this->v_second_image_url));
		$this->v_alt_image_url = htmlspecialchars(strip_tags($this->v_alt_image_url));


		//Bind data
		$stmt->bindParam(':get_id',$this->n_blog_post_id);
		$stmt->bindParam(':category_id',$this->n_category_id);
		$stmt->bindParam(':post_title',$this->v_post_title);
		$stmt->bindParam(':post_meta_title',$this->v_post_meta_title);
		$stmt->bindParam(':post_path',$this->v_post_path);
		$stmt->bindParam(':post_summary',$this->v_post_summary);
		$stmt->bindParam(':post_content',$this->v_post_content);
		$stmt->bindParam(':main_image_url',$this->v_main_image_url);
		$stmt->bindParam(':second_image_url',$this->v_second_image_url);
		$stmt->bindParam(':alt_image_url',$this->v_alt_image_url);
		$stmt->bindParam(':blog_post_views',$this->n_blog_post_views);
		$stmt->bindParam(':post_status',$this->f_post_status);
		$stmt->bindParam(':date_created',$this->d_date_created);
		$stmt->bindParam(':time_created',$this->d_time_created);
		$stmt->bindParam(':date_updated',$this->d_date_updated);
		$stmt->bindParam(':time_updated',$this->d_time_updated);

		//Execute query
		if($stmt->execute()){
			return true;

		}
		//Print error if something goes wrong
		printf("Error: %s. \n", $stmt->error);
		return false;

	}

	//Delete blog_post
	public function delete(){

		//Create query
		$query = "DELETE FROM $this->table
		          WHERE n_blog_post_id = :get_id";
		
		//Prepare statement
		$stmt = $this->conn->prepare($query);

		//Clean data
		$this->n_blog_post_id = htmlspecialchars(strip_tags($this->n_blog_post_id));

		//Bind data
		$stmt->bindParam(':get_id',$this->n_blog_post_id);

		//Execute query
		if($stmt->execute()){
			return true;
		}

		//Print error if something goes wrong
		printf("Error: %s. \n", $stmt->error);
		return false;

	}

	public function last_id(){
		$this->last_insert_id = $this->conn->lastInsertId();
		return $this->last_insert_id;
		
	}


}
