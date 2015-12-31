function loadHeader(){

	request = new XMLHttpRequest();
	request.open("GET","/PHP/header.php");

	request.onreadystatechange = function(){

		if(request.readyState == 4)
			if(request.status == 200){

				var i = 0;
				var nodes = document.createElement("p");;
				var firstChild = document.body.firstChild

				nodes.innerHTML = request.responseText;
				for(i = 0; i < nodes.childNodes.length; i++)
					document.body.insertBefore(nodes.childNodes[i],firstChild);
			}

	};

	request.send()

}

loadHeader()
