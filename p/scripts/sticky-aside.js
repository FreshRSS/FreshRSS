window.onscroll = function() {addSticky()};

var sidebar = document.getElementById("sidebar");
var sticky = sidebar.offsetTop;

function addSticky() {
  if (window.pageYOffset >= sticky) {
    sidebar.classList.add("sticky")
  } else {
    sidebar.classList.remove("sticky");
  }
}