var js_login_var = $('script[src*=../*.php]');
var loggedin = js_login_var.attr('loggedin');
// Get the modal
var modal = document.getElementById("myModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
//if( loggedin == "0") {
window.onload = function() {
  modal.style.display = "block";
}
//}