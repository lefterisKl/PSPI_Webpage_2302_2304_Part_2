<?php 

require 'comments.php';

checkIfCommentPost();

?>

<!DOCTYPE html>
<html lang="el" id="commentsPage">

    <head>
        <title lang="en">Edsger Dijkstra</title>
        <meta charset="utf-8"/>
		<meta name="description" content="The main page of a website for the life and work of Edsger Dijkstra">
		<link rel="icon" type="image/png" href="./images/mortarboard-32-1925.png">
        <link rel="stylesheet" href="/style.css"/>
		
		<script type="text/javascript" src="/JS/comments.js"></script>

    </head>

    <body>


		<article>
            <p>
				Εδω μπορείτε να αφήσετε τα σχόλια σας και να δείτε σχόλια άλλων σχετικά με την ζωή και το 
				έργο του Edsger Dijkstra.
			</p>
			<form method="post" action="commentsPage.php" id="comment-form">

				<textarea id="forumTA" title="You can write here your first comment" rows="4" cols="50" name="comment"
							placeholder="Πληκτρολογήστε εδώ το σχόλιο σας" required></textarea>
				<input  name="email" type="email" placeholder="Εισάγεται το e-mail σας" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
				<input id="commentSubmit" type="submit" value="Υποβολή Σχολίου"  required>

			</form>

			
			<div id="comments">
				<?php createComments();?>
			</div>

			<ul id="paginator">
				<?php createPaginator();?>
			</ul>

		<article>

    </body>
    <script type="text/javascript" src="/JS/loadHeader.js"></script>

</html>

