$(function () {
  // Activation tooltip bootstrap sur la page
  $('[data-toggle="tooltip"]').tooltip();
  // Comportement du bouton de recherche
  $("#searchButton").click(function () {
    var searchString = $("#searchString").val().trim();
    location = "/fr/shop/search/" + searchString;
    return false;
  });
});
