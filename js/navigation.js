document.addEventListener("DOMContentLoaded", function() {
  
	var navToggle = document.querySelector("#nav-toggle");

	[].forEach.call(document.querySelectorAll("#nav-toggle"), function(el) {
  		el.addEventListener("click", function() {
    		document.querySelector("#site-navigation").classList.toggle("expanded");
  		});
	});

});