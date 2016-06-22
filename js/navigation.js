document.addEventListener("DOMContentLoaded", function() {
  

	[].forEach.call(document.querySelectorAll("#nav-toggle"), function(el) {
  		el.addEventListener("click", function() {
    		document.querySelector("#site-navigation").classList.toggle("expanded");
  		});
	});


	[].forEach.call(document.querySelectorAll("#nav-close"), function(el) {
  		el.addEventListener("click", function() {
    		document.querySelector("#site-navigation").classList.toggle("expanded");
  		});
	});

});