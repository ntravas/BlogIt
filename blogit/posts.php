<?php

session_start();

include_once( 'Database.php' );
include_once( 'Article.php' );
include_once( 'userType.php' );

if ( !isset( $_GET[ 'page' ] ) || $_GET[ 'page' ] == '' ) {
	header( 'location: posts.php?page=1' );
}

if ( isset( $_GET[ 'page' ] ) ) {
	$page = $_GET[ 'page' ];

} else {
	$page = 1;
}


$database = new Database();
$conn = $database->connect();
$article = new Article( $conn );
$listOfArticles = $article->listAllArticles( $conn );
$userType = new UserType();


$resultsPerPage = 4;
$numberOfResults = $listOfArticles->num_rows;
$numberOfPages = ceil( $numberOfResults / $resultsPerPage );




if ( !isset( $_GET[ 'page' ] ) ) {
	$page = 1;

} else {
	$page = $_GET[ 'page' ];

}
$offset = ( $page - 1 ) * $resultsPerPage;
$articlesPerPage = $article->fetchArticlesPerPage( $resultsPerPage, $offset, $conn );


include_once( 'header.php' );

?>

<div class="container">
	<div class="float-right">
		<?php 
	if (isset( $_SESSION[ 'user_id' ] ) && $_SESSION[ 'user_type' ] == 1 ){
		echo '<br>';
		echo '<br>';
		echo '<a class="btn btn-primary" href="writearticle.php" role="button">Add article</a>';
		
	}
		?> </div>
	<div style="clear: both"></div>

	<div class="panel panel-default">
		<?php


		while ( $list = $articlesPerPage->fetch_assoc() ) {
			echo '<br>';
			echo '<br>';
			echo '<div class="row pr">';
			echo '<div class="col-sm-4">';
			if ( $list[ 'image' ] != NULL )
				echo '<img src="res/images/' . $list[ 'image' ] . '" class="img-responsive post" alt="Responsive image">';
			else echo '<img src="res/images/default.jpg" class="img-fluid post" alt="Responsive image">';
			echo '</div>';
			echo '<div class="col-sm-8">';
			echo '<h2> <a href="readarticle.php?id=' . $list[ 'ID' ] . '">' . $list[ 'title' ] . '</a></h2>';
			echo '<h5>' . date( "d. F Y", strtotime( $list[ 'created_at' ] ) ) . '</h5>';

			$string = strip_tags( $list[ 'article_text' ] );
			if ( strlen( $string ) > 500 ) {


				$stringCut = substr( $string, 0, 500 );
				$endPoint = strrpos( $stringCut, ' ' );


				$string = $endPoint ? substr( $stringCut, 0, $endPoint ) : substr( $stringCut, 0 );
				$string .= '... <a href="readarticle.php?id=' . $list[ 'ID' ] . '">Read More</a>';
			}
			echo '<p>' . $string . '</p>';

			if ( isset( $_SESSION[ 'user_id' ] ) && $_SESSION[ 'user_type' ] == 1 ) {
				echo( '<form method = "POST" action = "' . $article->deleteArticle( $conn ) . '">
								<input type = "hidden" name = "articleid" value = "' . $list[ 'ID' ] . '">
								<button class="btn btn-danger" name ="articleDelete" type ="submit">Delete</button></form>' );
			}

			echo '</div>';
			echo '<hr>';
			echo '</div>';
		}
		echo '<ul class="pagination">';
		for ( $page = 1; $page <= $numberOfPages; $page++ ) {
			echo '<li class="page-item"><a class="page-link"  href="posts.php?page=' . $page . '">' . $page . '</a></li>';
		}
		echo '</ul>';
		?>

	</div>
</div>
<footer>Life Blog 2018</footer>
</body>

</html>