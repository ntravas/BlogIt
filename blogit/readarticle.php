<?php
session_start();
include_once( 'Database.php' );
include_once( 'Article.php' );
include_once( 'Comments.php' );
include_once( 'User.php' );


$database = new Database();
$conn = $database->connect();
$article = new Article( $conn );
$articleData = $article->fetchArticleData( $_GET[ 'id' ], $conn );
$articleExsists = $article->checkIfArticleExists( $_GET[ 'id' ], $conn );
$comment = new Comments( $conn );
$user = new User( $conn );
$commentData = $comment->fetchAllCommentsForSpecifiedArticle( $_GET[ 'id' ], $conn );


include_once( 'header.php' );

?>
<br><br><br>
<div class="container">


	<?php
	if ( $articleExsists == 1 ) {
		echo '<h1>' . $articleData[ 'title' ] . '</h1>';
		if ($articleData['image'] != NULL)
				echo '<img src="res/images/' . $articleData[ 'image' ] . '" class="img-fluid post" alt="Responsive image">';
				else echo '<img src="res/images/default.jpg" class="img-fluid post" alt="Responsive image">';
		echo'<br>';
		echo'<br>';
		echo $articleData[ 'article_text' ];
	} else {
		return header( 'location: 404.php' );
	}

	?>
	<h3 id="comments" class="comments">Comments <small>
	<?php
		
		if ($commentData->num_rows >  0) echo(' <em>('.$commentData->num_rows.' comment/s)</em>');
		else echo(' <em>(Be the first one to comment.)</em>');
		
		?>
		</small>
	</h3>
	<br>

	<?php if(!$_SESSION) {
	echo("Log in to view and write comments.");
} else {?>
	<form action="<?php echo($_SERVER['PHP_SELF'])?>?id=<?php echo($_GET['id']) ?>" enctype="multipart/form-data" method="post">
		<div class="form-group">
			<textarea required name="comment" class="form-control" rows="5" placeholder="Write your comment here..." id="comment"></textarea>
		</div>
		<button name="comment_button" type="submit" class="btn btn-primary ">Comment Article</button>
	</form>

	<br>

	<?php 
	
		if ($commentData->num_rows > 0 ) {
			while ($commentList = $commentData->fetch_assoc()) {
				$commentUsername = $user->getUsernameByUserId($commentList['user_id'],$conn);
				$commentUsername = $commentUsername->fetch_assoc();
				?>

	<div id="#comment<?php echo($commentList['ID']) ?>" class="media border p-3">
		<div class="media-body">
			<h4> <a href="myaccount.php?id=<?php echo($commentList['user_id']) ?>"><?php echo $commentUsername['username'] ?></a></h4>
			<p>
				<?php echo $commentList['comment_text'] ?>
			</p>
			<h5><small><i>Posted on <?php echo(date("d. F Y", strtotime($commentList['date_time'] ))) ?></i> 
						
						<?php 
						
							if (($_SESSION['user_id'] == $commentList['user_id']) || $_SESSION['user_type'] == 1) {
								echo '<br>';
								echo '<br>';
								echo('<form method = "POST" action = "'.$comment->removeComment($_GET['id'],$conn ).'">
								<input type = "hidden" name = "commentID" value = "'.$commentList['ID'].'">
								<button class="btn btn-danger" name ="commentsDelete" type ="submit">Remove</button></form>');
							}
						
						?>
						
						</small></h5>
		</div>
	</div>

	<?php

	}

	}
	}

	?>
</div>
	</body>
<footer>Life Blog 2018</footer>
</html>