<?php

$connection = mysqli_connect("localhost","php","phpPassWord","SiteComments");

function insertComment($body,$email){

	global $connection;
     
   
    $filteredBody = $connection->escape_string(addslashes($body));
    $filteredEmail = $connection->escape_string(addslashes($email));
    
    
	$insertCode = "INSERT INTO Comments (body,email) VALUES ('$filteredBody','$filteredEmail')";
	$connection->query($insertCode);
}

function echoComments($from,$amount){

	global $connection;
    
    
	$query = "SELECT body,email FROM Comments ORDER BY ID DESC LIMIT $from,$amount";
	$results = $connection->query($query);
 

	if($results->num_rows == 0){
		echo "No comments yet.";
		return;
	}

	while($row = $results->fetch_assoc())
		echo '<div class="comment">' . 
		'<div class="comment-body">'   . htmlspecialchars($row["body"])  . "</div>".
		'<div class="comment-email"><a href=mailto:'. htmlspecialchars($row["email"]) .'>'  . $row["email"] . "</a></div>".
		"</div>";

}

function createComments(){

	if(isset($_GET["page"])){
		#First some checking on page's value.
		$page = $_GET["page"];

		if(!is_numeric("$page"))
			$page = 1;
		else
			$page = intval("$page",0);

		$totalPages = ceil(commentsCount()/10);

		if($page < 1)
			$page = 1;
		if($page > $totalPages)
			$page = $totalPages;

		echoComments(($page - 1)*10,10);
	}
	else
		echoComments(0,10);

}

function echoPageLink($page,$pageName){
	echo '<li><a href="/PHP/commentsPage.php?page=' . $page .'">' . $pageName . "</a></li>\n";
}

function echoPageLinkWithId($page,$pageName,$id){
   echo '<li><a id="' . $id . '" href="/PHP/commentsPage.php?page=' . $page .'">' . $pageName . "</a></li>\n";
 
    
}

function echoPaginator($currentPage){

	$comment_count = commentsCount();
	$totalPages = ceil($comment_count/ 10);

	if($comment_count <= 10)
		return;
    $currentPageInt = intval($currentPage);
    $previousPage = $currentPageInt -1;
    if($currentPageInt>1)
    {
        echoPageLink("$previousPage","Προηγούμενη");
        echoPageLink("1","1");
    }
    else
    {
        echoPageLinkWithId("$currentPage","1","currentPage");
    }
    

	$previous = intval($currentPage) - 2;
	$count    = 1;

	if($previous > 2)
		echo " ... ";
	else{
		$previous = 2;
		$count = 5 - $currentPage;
	}

	while($previous <= $totalPages && $count <= 5){
        if($previous == $currentPageInt){
            echoPageLinkWithId("$previous","$previous","currentPage");
        }
        else{
            echoPageLink("$previous","$previous");
        }
		
		echo "  ";
		$count = $count + 1;
		$previous = $previous + 1;
	}


	if($count == 6 && $previous < $totalPages+1){
        if(intval($currentPage)<$totalPages-3)
        {
            echo " ... ";
        }
		echoPageLink("$totalPages","$totalPages");
	}
     
    if($currentPageInt<$totalPages)
    {
        $nextPage = $currentPageInt +1; 
        echoPageLink("$nextPage","Επόμενη");
    }
        
}

function createPaginator(){

	if(isset($_GET["page"]))
		echoPaginator($_GET["page"]);
	else
		echoPaginator("1");

}

function commentsCount(){

	global $connection;

	$query = "SELECT COUNT(body) as count FROM Comments";
	$results = $connection->query($query);

	return $results->fetch_assoc()["count"];

}


function checkIfCommentPost(){

	if(isset($_POST["comment"]))
		insertComment($_POST["comment"],$_POST["email"]);

}

?>
