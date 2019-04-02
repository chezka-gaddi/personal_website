/*******************************************************************************
 * @file
 * @brief Contains functions for attaching Javascript functions to buttons and
 * functions that edit CSS special effects.
 ******************************************************************************/

// Attach all functions to html elements
window.onload = function () {
    document.getElementById("confirm").onclick = confirmNoteEvent;
    document.getElementById("C4").onclick = trial;
    document.getElementById("A4").onclick = trial;
    document.getElementById("B4").onclick = trial;
    document.getElementById("D4").onclick = trial;
    document.getElementById("E4").onclick = trial;
    document.getElementById("F4").onclick = trial;
    document.getElementById("G4").onclick = trial;
    document.getElementById("C5").onclick = trial;
    document.getElementById("update").onclick = updateLastNote;
    document.getElementById("undo").onclick = hist.undoCmd;
    document.getElementById("redo").onclick = hist.redoCmd;
    document.getElementById("play").onclick = play;
    updateUI();
}


function activateButton() {
    var selection = document.getElementById("songTitle").value;
    var loadBtn = document.getElementById("loadSongButton");
    if (selection.includes(".xml")) {
        loadBtn.classList.remove("disabled");
    } else {
      if (!loadBtn.classList.contains("disabled")) {
        loadBtn.classList.add("disabled");
      }
    }
  }
 

function save() {
    var variables = parseNotes();
    var tones = variables[0];
    var dur = variables[1];
    var musicString = '';
  
    for (var i = 0; i < tones.length; i++) {
        musicString += tones[i] + ' ' + dur[i] + ' ';
    }
  
    document.cookie = "songToSave=" + musicString;
    var title = document.getElementById("songTitle").value;
    document.cookie = "songTitle=" + title;
}
