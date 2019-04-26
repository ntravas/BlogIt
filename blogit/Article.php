<?php
class Article {
	private $tablename = 'posts';
	private $ID;
	private $user;
	private $image;
	private $articleText;
	private $date;
	private $db;

	function __construct( $db ) {
		$this->db = $db;

	}

	public

	function addArticle( $user, $title, $articleText, $image, $db ) {
		$this->user = $user;
		$this->title = $title;
		$this->articleText = $articleText;
		$this->image = $image;
		$this->db = $db;


		$sql = 'INSERT INTO posts (image, user_id, title, article_text) 
		VALUES ("'.$this->image.'", ' . $this->user . ',"' . $this->title . '" ,"' . $this->articleText . '")';

		if ( $this->db->query( $sql ) ) {
			header( 'location: posts.php?userid=' . $user . '&status=success' );
		} else {
			header( 'location: writearticle.php?userid=' . $user . '&status=fail' );
		}
	}



	public

	function listAllArticles( $db ) {

		$this->db = $db;

		$sql = 'SELECT * FROM posts ORDER BY ID DESC';
		$result = $this->db->query( $sql );
		return $result;

	}

	public

	function fetchArticleData( $ID, $db ) {
		$this->db = $db;
		$this->ID = $ID;

		$sql = 'SELECT * FROM posts WHERE ID = ' . $this->ID;
		$result = $this->db->query( $sql );
		return $result->fetch_assoc();
	}

	public

	function checkIfArticleExists( $ID, $db ) {
		$this->db = $db;
		$this->ID = $ID;

		$sql = 'SELECT * FROM posts WHERE ID = ' . $this->ID;
		$result = $this->db->query( $sql );

		if ( $result->num_rows == 1 ) {
			return 1;
		} else {
			return 0;
		}
	}

	public

	function deleteArticle( $db ) {
		if ( isset( $_POST[ 'articleDelete' ] ) ) {
			$articleID = $_POST[ 'articleid' ];

			$sql = 'DELETE FROM posts WHERE ID = ' . $articleID;

			if ( $this->db->query( $sql ) ) {
				header( "location: posts.php" );
			}

		}


	}

	public

	function fetchArticlesPerPage( $limit, $offset, $db ) {
		$this->db = $db;
		$sql = 'SELECT * FROM posts ORDER BY ID DESC LIMIT '.$limit.'  OFFSET '.$offset;
		$result = $this->db->query($sql);
		return $result;
		
		
		
    

	}
}
?>