<?php

class User {
	private $tableName = "user";
	private $ID;
	private $username;
	private $password;
	private $email;
	private $userType;
	private $db;

	public

	function __construct( $db ) {
		$this->db = $db;

		if ( isset( $_POST[ 'login' ] ) ) {
			$this->login();
		}

		if ( isset( $_POST[ 'register' ] ) ) {
			$this->register();
		}
		
		if(isset($_POST['update_data'])){
			$this->update($_SESSION['user_id']);
		}
		
		if(isset($_POST['update_password'])){
			$this->changePassword($_SESSION['user_id']);
		}
	}

	private

	function login() {
		$this->username = $this->db->real_escape_string( $_POST[ 'username' ] );
		$this->password = $this->db->real_escape_string( $_POST[ 'password' ] );

		$sql = 'SELECT * FROM user WHERE username = "' . $this->username . '"';
		echo $sql;
		$userExists = $this->db->query( $sql );

		if ( $userExists->num_rows == 1 ) {
			$userData = $userExists->fetch_assoc();

			if ( $this->password == $userData[ 'password' ] ) {

				$_SESSION[ 'user_id' ] = $userData[ 'ID' ];
				$_SESSION[ 'username' ] = $userData[ 'username' ];
				$_SESSION[ 'email' ] = $userData[ 'email' ];
				$_SESSION[ 'user_type' ] = $userData[ 'user_type' ];

				header( 'location: index.php?userid='.$_SESSION['user_id'].'' );

			} else {
				header( 'location: login.php?status=password' );
			}

		} else {
			header( 'location: login.php?status=nouser' );
		}
	}

	

	private function register() {
		$this->username = $this->db->real_escape_string( $_POST[ 'username' ] );
		$this->password = $this->db->real_escape_string( $_POST[ 'password' ] );
		$this->email = $this->db->real_escape_string( $_POST[ 'email' ] );
		$this->userType = 2;
		$this->status = 1;

		$stmt = $this->db->prepare( 'INSERT INTO user(username, password, user_type, email, status) 
		VALUES(?, ?, ?, ?, ?)' );
		$stmt->bind_param( "ssisi", $this->username, $this->password, $this->userType, $this->email, $this->status );
		if($stmt->execute()){
			header( 'location: signup.php?status=registered&username=' . $this->username);
		}
		else{
			header('location: signup.php?status=fail');
		}

	}
	
	private 
		function update($ID) {
		$this->ID = $ID;
		$this->username = $_POST['username'];
		$this->email = $_POST['email'];
		
		$sql = 'UPDATE user SET email = "'.$this->email.'", username = "'.$this->username.'" WHERE ID = '.$this->ID;
		if ($this->db->query($sql)) {
			header("location: myaccount.php?id=".$this->ID."&status=100");
		}
	}
	
	private 
		function changePassword($ID) {
		$this->ID = $ID;
		$this->password = $_POST['password'];
		
		
		$sql = 'UPDATE user SET password = "'.$this->password.'" WHERE ID = '.$this->ID;
		if ($this->db->query($sql)) {
			header("location: myaccount.php?userid=".$this->ID."&status=101");
		}
	}
	
	public
	function fetchData( $ID, $db ) {
		$this->db = $db;
		$this->ID = $ID;

		$sql = 'SELECT * FROM user WHERE ID = '.$this->ID;
		return $this->db->query( $sql );
		
	}
	
	public function removeAccount($ID, $db) {
		$this->ID = $ID;
		$this->db = $db;
		
		$sql = 'DELETE FROM user WHERE ID = '.$this->ID;
		echo $sql;
		$this->db->query($sql);
	}
	
	public
		function getUsernameByUserId($ID, $db){
		$this->db = $db;
		$this->ID = $ID;

		$sql = 'SELECT username FROM user WHERE ID = '.$this->ID;
		return $this->db->query( $sql );
	}
}
?>