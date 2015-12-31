<?php

$FIRST_TIME = True;

$QnA = array(
  array("Οταν ήταν στο σχολείο, ο Edsger Dijkstra ήθελε να ακολουθήσει μια καρίερα στον τομέα της","Νομικής","Ιατρικής","Αστρονομίας",1)
  ,array("O Edsger Dijkstra δέχθηκε μια πρόταση για να δουλέψει ως προγραμματιστής απο τον","Bram Jan Loopstra","Carel S. Scholten","Adriaan van Wijngaarden",3)
  ,array("Στα τέλη του 1960, ο Dijkstra κατασκεύασε το λειτουργικό σύστημα","ΤΗΕ","Amoeba","HelenOS",1)
  ,array("O Edsger Dijkstra κέρδισε το βραβείο Turing την χρονία","1969","1971","1972",3)
  ,array("Η μέρα της εβδομάδας που o Dijkstra πήγαινε στο πανεπιστήμιο έγινε γνωστή ως","Tuesday Afternoon Club","Friday Morning Club","Wednesday Afternoon Club",1)
  ,array("Ο Edsger Dijkstra σχεδιάσε έναν αλγόριθμο γνωστό ως τον αλγόριθμο ","του τραπεζίτη","του φούρνου","του ζωγράφου",1)
  ,array("Ποιόν απο τους παρακάτω τομείς της πληροφορικής επηρέασε περισσότερο ο Edsger Dijkstra","Βάσεις Δεδομένων","Λειτουργικά Συστήματα","Τεχνητή Νοημοσύνη",2)
  ,array("Συμφωνά με τον Δομημένο Προγραμματισμό, τα υποσυστήματα λογισμικού πρεπει να ορίζονται ως πρός","Την υλοποίηση τους","Το μέγεθος τους","την διεπαφή τους",3)
  ,array("Μαζί με τον Jaap van Zonneveld, ο Dijkstra υλοποίησε τον πρώτο μεταγλωττιστή για την γλώσσα","Pascal","Ada","ALGOL 60",3)
  ,array("Ένας ορός που καθιέρωσε ο Edsger Dijkstra στον χώρο τής Πληροφορικής είναι","Ο Σημαφόρος","Το πλαίσιο","Ο πίνακας κατακερματισμού",1)
  );



function initializeCookies(){

  for($i = 0; $i < 10; $i++)
	  setcookie("$i","0",0,"/");

  setcookie("previousQuestion","-1",0,'/');

} 


function nextQuestion() {
  
	global $FIRST_TIME;
	global $QnA;

	$r = rand(0,9);
	$next_question = -1;

	if($FIRST_TIME){
		setcookie("$r","1",0,'/');
		setcookie("previousQuestion","$r",0,'/');
		return $r;
	}

	$questionsAnswered = 0;

	while( $_COOKIE["$r"] != "0" && $questionsAnswered<10)
	{
	  $r = ($r+1)%10;
	  $questionsAnswered++;
	}

	if($questionsAnswered==10)
		return -1;

	setcookie("$r","1",0,'/');
	setcookie("previousQuestion","$r",0,'/');

	return $r;
		
}

function echoQuestion($index,$prevAnswer){

	global $QnA;
	$s="";
	if($index == -1)
		$s=";;;;$prevAnswer";
	else
		$s=$QnA[$index][0] . ';' . $QnA[$index][1] . ';' . $QnA[$index][2] . ';' .$QnA[$index][3]. ';' . $prevAnswer;
	return $s;
}

function main(){
  
	global $FIRST_TIME;
	global $QnA;

	if(isset($_COOKIE['0']))
		$FIRST_TIME = False;
	else
		initializeCookies();

	$questionIndex = nextQuestion();

	if($FIRST_TIME == True){
		echo echoQuestion($questionIndex,"");
		return;
	}

	$isCorrect=0;

	if(intval($_POST["userAnswer"]) == $QnA[intVal($_COOKIE["previousQuestion"])][4] )
		$isCorrect=1;

	echo echoQuestion($questionIndex,"$isCorrect");
    
}

main()

?>
