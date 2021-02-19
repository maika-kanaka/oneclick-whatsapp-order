// Shortcode Benerator
function generateWAshortcode(form) {
	var Vselected_wa_number = document.getElementById("selected_wa_number").value
	var VWAbuttonText = document.getElementById("WAbuttonText").value  
	var VWAcustomMessage = document.getElementById("WAcustomMessage").value
	var VWAnewTab = document.getElementById("WAnewTab").value
	var generatedWAbuttonData = '[waorder phone="'+Vselected_wa_number+'" button="'+VWAbuttonText+'" message="'+VWAcustomMessage+'" target="'+VWAnewTab+'"]';
	document.getElementById("generatedShortcode").innerHTML = generatedWAbuttonData;
}

jQuery(document).ready(function( $ ) {
  $(".octo-category-filter").select2();
  theme: "classic"
  $('select').select2({
    placeholder: {
      id: '-1', // the value of the option
      text: 'Search and pick a term...'
    }
  });
});

jQuery(document).ready(function( $ ) {
  $(".octo-post-filter").select2({
    placeholder: "Search and pick a post..."
  });
});

jQuery(document).ready(function( $ ) {
  $(".octo-page-filter").select2({
    placeholder: "Search and pick a page..."
  });
});