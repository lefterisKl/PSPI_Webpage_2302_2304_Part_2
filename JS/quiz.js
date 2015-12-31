var correctAnswers = 0;
var waitTime = 1500;


function updateQnA(question, answer1, answer2, answer3) {

    var questionNode = document.getElementById("question");
	var answerNode 	 = document.getElementById("radio1").parentNode;

    questionNode.textContent = question;
     
    answerNode.childNodes[1].textContent = answer1;
    answerNode = document.getElementById("radio2").parentNode;
    answerNode.childNodes[1].textContent = answer2;
    answerNode = document.getElementById("radio3").parentNode;
    answerNode.childNodes[1].textContent = answer3;

	document.getElementById("radio1").checked = false;
    document.getElementById("radio2").checked = false;
    document.getElementById("radio3").checked = false;
	document.getElementById("confirmButton").disabled = false;

}

function showCorrectness(isCorrect) {

    var form = document.getElementById("quiz-form");
	var header = document.getElementById("resultHeader");
 
    if (isCorrect === "1") {
        form.style.color = "green";
        header.textContent = "Σωστή Απάντηση!!!";
		correctAnswers = correctAnswers + 1;
    }
	else {
        form.style.color   = "red";
        header.textContent = "Λάθος Απάντηση!!!";
    }

	header.style.visibility = "visible"
    setTimeout(function () {form.style.color = "black"; header.style.visibility = "hidden"; }, waitTime);

}

function finalize() {

    var i;
	var header = document.getElementById("resultHeader");

	header.textContent = "Συνολικά σωστές απαντήσεις : " + correctAnswers + "/10";
	header.style.visibility = "visible";

    for (i = 0; i < 10; i = i + 1) {
        var name = i.toString();
        document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/'
    }

    document.cookie = 'previousQuestion=; expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/';

	correctAnswers = 0;
    document.getElementById("repeat").style.display="inline"; 

}


function sendRequest(selectedAnswer) {

    var request = new XMLHttpRequest();
    request.open("POST", "/PHP/quiz.php");
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    request.onreadystatechange = function () {
    
        if (request.readyState === 4) {
            if (request.status === 200) {

                var data = request.responseText.split(';');
				if (data[0] === "") {
					showCorrectness(data[4]);
					setTimeout(finalize,waitTime)
				}
				else if(data[4] === ""){
					updateQnA(data[0], data[1], data[2], data[3]);
				}
				else{
                        showCorrectness(data[4]);
                        setTimeout(updateQnA,waitTime,data[0], data[1], data[2], data[3]);
				}
			}
            else {
                //Error from server start panicking!!!!
                window.alert("There was an error communicating with the server. Received status "+ request.status);
            }

        }
       
	};

    request.send("userAnswer=" + selectedAnswer);

}

function buttonListener() {

	var button = document.getElementById("confirmButton");
    var radio1 = document.getElementById("radio1");
	var radio2 = document.getElementById("radio2");
	var radio3 = document.getElementById("radio3");

    if (radio1.checked) 
        sendRequest("1");
	else if (radio2.checked) 
        sendRequest("2");
    else if (radio3.checked)
        sendRequest("3");
    else{
        window.alert("Πρέπει να επιλέξετε μία απάντηση.");
		return;
	}

	button.disabled = true;

}

function repeatListener()
{
    
    window.location = "quiz.html";
}


window.onload = function f() {
	document.getElementById("confirmButton").addEventListener("click", buttonListener);
    document.getElementById("repeat").addEventListener("click",repeatListener);
	sendRequest("-1");    
    document.getElementById("repeat").style.display="none"; 
};

window.onunload = finalize;



