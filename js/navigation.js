document.addEventListener("DOMContentLoaded", function() {
  	// TODO: this could be better
	// TODO: needs aria roles

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