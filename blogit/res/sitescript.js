// JavaScript Document

function openNavigation() {
	var x = document.getElementById("nav");
	if (x.className === "navigation") {
		x.className += " responsive-navi";
	} else {
		x.className = "navigation"
	}
}

