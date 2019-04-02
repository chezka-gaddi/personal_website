window.onload = function() {
    var curr_page = document.title.toLocaleLowerCase();
    console.log(curr_page);
    var nav = document.getElementById(curr_page);
    nav.classList.add("active");
}