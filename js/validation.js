function validateForm(){
	var x = document.forms["set-result"]["played"].value;
	if( x === null || x === "empty"){
		alert("Please select decks first.");
	}

	var x = document.forms["set-result"]["against"].value;
	if( x === null || x === "empty"){
		alert("Please select decks first.");
	}
	
}