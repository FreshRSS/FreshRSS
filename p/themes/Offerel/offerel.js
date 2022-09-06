const grabber_size = 5;
const side_panel = document.getElementById('aside_feed');
const main = document.getElementById('stream');
const item_title = document.querySelector('.title');

let mouse_pos;

if(main) main.addEventListener("mousedown", function(e){
	if (e.offsetX < grabber_size) {
		mouse_pos = e.x;
		document.addEventListener("mousemove", resize, false);
	}
}, false);

document.addEventListener("mouseup", function(){
	document.removeEventListener("mousemove", resize, false);
}, false);

function resize(e){
	const dx = mouse_pos - e.x;
	mouse_pos = e.x;
	side_panel.style.width = (parseInt(getComputedStyle(side_panel, '').width) - dx) + "px";
	item_title.style.width = (parseInt(getComputedStyle(item_title, '').width) - dx) + "px";
}