window.onscroll = function() {myFunction()};

var sidebar = document.getElementById("sidebar");
var sticky = sidebar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    sidebar.classList.add("sticky")
  } else {
    sidebar.classList.remove("sticky");
  }
}