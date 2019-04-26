<?php

session_start();

if ( !isset( $_GET[ 'userid' ] ) || $_GET[ 'userid' ] == '' ) {
	header( 'location: writearticle.php?userid=' . $_SESSION[ 'user_id' ] );
}
if ( $_GET[ 'userid' ] != $_SESSION[ 'user_id' ] ) {
	header( 'location: writearticle.php?userid=' . $_SESSION[ 'user_id' ] );
}

include_once( 'Database.php' );
include_once( 'User.php' );
include_once( 'Article.php' );

$database = new Database();
$conn = $database->connect();
$article = new Article( $conn );
$user = new User( $conn );

include( 'uploadpicture.php' );
include_once( 'header.php' );


?>



	<div class="container">

		<form method="post" enctype="multipart/form-data" action="<?php echo($_SERVER['PHP_SELF'].'?userid='.$_SESSION[ 'user_id' ]) ?>">
		<div class="form-group">
			
			<br><br>
			<label>Title:</label>
			<input class="form-control" type="text" name="title">
		</div>
		<div class="form-group">
			<label for="comment">Enter Article Text:</label>
			<textarea class="form-control" rows="15" name="article_text"></textarea>
		</div>

		<input type="file" name="file[]" id="file" class="selectphoto"  /><br>
<br>
						<input type="submit" value="Upload Article" name="submit" id="upload" class="upload  btn btn-primary"/>
		</form>
		
	</div>
</body>
</html>