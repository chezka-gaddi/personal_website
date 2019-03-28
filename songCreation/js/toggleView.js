/*******************************************************************************
 * @file
 * @brief Contains functions to attach and execute CSS special effects.
 ******************************************************************************/

window.onload = function() {
    var headers = document.getElementsByClassName('clickable-heading');
    for (var i = 0; i < headers.length; i++) {
        headers[i].onclick = toggleContent;
    }
}


function toggleContent(event) {
    if (event.target && event.target.className == 'clickable-heading') {
        var next = event.target.nextElementSibling;

        if (next.style.display == "none") {
            next.style.display = "block";
        } else {
            next.style.display = "none";
        }
    }
}
