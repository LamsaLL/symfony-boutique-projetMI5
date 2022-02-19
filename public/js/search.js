$(function () {
  // Activation tooltip bootstrap sur la page
  $('[data-toggle="tooltip"]').tooltip();
  // Comportement du bouton de recherche
  $("#searchButton").click(function () {
    var searchString = $("#searchString").val().trim();
    // Check if the url contain en or fr
    var lang = window.location.href.split("/")[3];
    if (lang == "en") {
      location = "/en/shop/search/" + searchString;
    } else {
      location = "/shop/search/" + searchString;
    }
    return false;
  });
});
