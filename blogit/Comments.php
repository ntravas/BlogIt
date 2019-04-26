<?php

class Comments {
	private $tableName = "comments";
	private $ID;
	private $article;
	private $user;
	private $commentText;
	private $dateTime;
	private $db;

	function __construct( $db ) {
		$this->db = $db;

		if ( isset( $_POST[ 'comment_button' ] ) ) {
			$this->sendComment( $_SESSION[ 'user_id' ], $_GET[ 'id' ] );
		}
	}

	private

	function sendComment( $user, $article ) {
		$this->user = $user;
		$this->article = $article;
		$this->commentText = $_POST[ 'comment' ];

		$stmt = $this->db->prepare( 'INSERT INTO comments(post_id, user_id, comment_text) VALUES(?, ?, ?)' );
		$stmt->bind_param( "iis", $this->article, $this->user, $this->commentText );

		if ( $stmt->execute() ) {
			header( 'location: readarticle.php?id=' . $this->article );
		}
	}

	public

	function fetchAllCommentsForSpecifiedArticle( $article, $db ) {
		$this->db = $db;
		$this->article = $article;

		$sql = 'SELECT * FROM comments WHERE post_id = ' . $this->article;
		return $this->db->query( $sql );
	}

	public

	function removeComment( $article, $db ) {
		if ( isset( $_POST[ 'commentsDelete' ] ) ){
			$commentID = $_POST['commentID'];
			
			$sql = 'DELETE FROM comments WHERE ID = '.$commentID;
			$result = $this->db->query( $sql );
	
			if ( $result ) {
				header( "location: readarticle.php?id=" . $article );
			}
			
		}

			
	}
}

?>