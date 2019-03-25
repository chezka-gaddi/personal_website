var sounds = {
  "C4": "res/tones/C4.wav",
  "D4": "res/tones/D4.wav",
  "E4": "res/tones/E4.wav",
  "F4": "res/tones/F4.wav",
  "G4": "res/tones/G4.wav",
  "A4": "res/tones/A4.wav",
  "B4": "res/tones/B4.wav",
  "C5": "res/tones/C5.wav"
};

var duration = {
  "whole": 2,
  "half": 1,
  "quarter": 0.5,
  "eighth": 0.25
}

var snd = new Audio();
snd.autoplay = false;


function parseNotes() {
  var song = document.getElementById("sheet-music");
  var notes = song.children;
  var dur = [];
  var tones = [];

  for (i = 0; i < notes.length; i++) {
    var classes = notes[i].lastChild.classList;
    if (typeof classes != "undefined") {
      tones.push(classes.item(0));
      dur.push(classes.item(1));
    }
  }

  var variables = [tones, dur];
  return variables;
}


function play() {
  console.log("About to play some tunes");
  var variables = parseNotes();
  var tones = variables[0];
  var dur = variables[1];
  var tempo = document.getElementById("tempo").checked;
  if (tempo) {
    tempo = 2;
  } else {
    tempo = 1;
  }

  console.log(tones.length);
  console.log(tones);
  console.log(dur);
  var index = 0;
  snd = new Audio(sounds[tones[index]]);
  snd.play();
  console.log("Playing: " + tones[index]);

  var x = setInterval(function () {
    if (snd.currentTime > (duration[dur[index]]/tempo))
      snd.pause();
  }, 500);

  //when the sound ends, move to the next
  snd.onpause = function () {
    index++;
    if (tones.length > index) {
      snd.src = sounds[tones[index]];
      console.log("Playing: " + tones[index]);
      snd.play();
    } else {
      clearInterval(x);
    }
  };
}


// REBENITSCH: MANAGE
function History() {
  var Actions = [];
  var TempActions = [];
  var index = 0;
  var tempIndex = 0;

  //new UndoRedo, remove everything after the current UndoRedo index
  //and append the new function
  this.executeAction = function (cmd) {
    if (cmd.type == "temp") {
      TempActions.length = tempIndex;
      if (tempIndex > 0) {
        TempActions[tempIndex - 1].undo();
      }
      TempActions.push(cmd);
      tempIndex = TempActions.length;
    } else {
      if (tempIndex > 0) {
        TempActions[tempIndex - 1].undo();
        tempIndex = 0;
      }
      Actions.length = index;		//trims length from 0 to index
      Actions.push(cmd);
      index = Actions.length;
    }

    // run the UndoRedo and update
    cmd.exec();
    updateUI();
  }

  //undo called. Call the undo function on the current UndoRedo and move back one
  this.undoCmd = function () {
    if (tempIndex > 0) {
      TempActions[tempIndex - 1].undo();
      tempIndex = tempIndex - 1;
      if (tempIndex > 0) {
        TempActions[tempIndex - 1].exec();
      }
    } else if (index > 0) {
      var cmd = Actions[index - 1];
      cmd.undo();
      index = index - 1;
    }
    updateUI();
  }

  //redo called. Call the execution function on the current UndoRedo and move forward one
  this.redoCmd = function () {
    if (TempActions.length == 0 || (index < Actions.length && tempIndex == 0) ) {
      var cmd = Actions[index];
      cmd.exec();
      index = index + 1;
      updateUI();
    } else if (TempActions.length > 0) {
      if (tempIndex > 0) {
        TempActions[tempIndex - 1].undo();
      }
      TempActions[tempIndex].exec();
      tempIndex = tempIndex + 1;
      updateUI();
    }
  }

  //is undo available
  this.canUndo = function () {
    return index > 0 || tempIndex > 0;
  }

  //is redo available
  this.canRedo = function () {
    return index < Actions.length || tempIndex < TempActions.length;
  }
}


// REBENITSCH: COMMAND
function TempUndoRedo(note, dur, noteDur) {
  this.type = "temp";
  this.note = note;
  this.dur = dur;
  this.noteDur = noteDur;

  // adds a note
  this.exec = function () {
    var classes = [this.note, this.noteDur, "gray"];
    drawNote(classes);
  }

  this.undo = function () {
    var out = document.getElementById("change");
    var idx = out.innerHTML.lastIndexOf("/");
    idx = out.innerHTML.length - idx;
    console.log("Index of last /: " + idx);
    out.innerHTML = out.innerHTML.slice(0, -idx);

    var music = document.getElementById("sheet-music");
    music.removeChild(music.lastChild);
  }
}


//concrete UndoRedo class. Since we have undo and redo, we much have
//a "action" (exec) function and an undo
//ideally, this should forward these calls onto the class that does the task
// REBENITSCH: COMMAND
function UndoRedo(note, dur) {
  this.type = "norm";
  this.note = note;
  this.dur = dur;
  this.noteDur = null;
  switch(dur) {
    case 0:
      this.dur = 0.25;
      this.noteDur = "eighth";
      break;
    case 1:
      this.dur = 0.5;
      this.noteDur = "quarter";
      break;
    case 2:
      this.dur = 1;
      this.noteDur = "half";
      break;
    case 3:
      this.dur = 2;
      this.noteDur = "whole";
      break;
  }

  // adds a note
  this.exec = function () {
    console.log("Var Type of note: " + typeof this.note);
    var classes = [this.note, this.noteDur];
    drawNote(classes);
  }

  // removes note
  this.undo = function () {
    var out = document.getElementById("change");
    var idx = out.innerHTML.lastIndexOf("/");
    idx = out.innerHTML.length - idx;
    console.log("Index of last /: " + idx)
    out.innerHTML = out.innerHTML.slice(0, -idx);
    
    var music = document.getElementById("sheet-music");
    music.removeChild(music.lastChild);
  }
}


function drawNote(classes) {
  var out = document.getElementById("change");
  console.log(out.innerHTML);
  console.log("Length of inner: " + out.innerHTML.length);
  if (out.innerHTML.length == 0) {
    out.innerHTML += classes[0] + classes[1];
  } else {
    out.innerHTML += "/" + classes[0] + classes[1];
  }
  
  console.log("Drawing note: " + classes);	
  var container = document.createElement("div");
  container.classList.add("bar");

  var divnode = document.createElement("div");
  for (var i = 0; i < classes.length; i++) {
    divnode.classList.add(classes[i]);
  }

  console.log(divnode.classList);
  container.appendChild(divnode);
  document.getElementById("sheet-music").appendChild(container);
}


function trial() {
  var dur = document.getElementById("duration").selectedIndex;
  switch(dur) {
    case 0:
      dur = 0.25;
      noteDur = "eighth";
      break;
    case 1:
      dur = 0.5;
      noteDur = "quarter";
      break;
    case 2:
      dur = 1;
      noteDur = "half";
      break;
    case 3:
      dur = 2;
      noteDur = "whole";
      break;
  }

  var i, group = document.getElementsByName("notes");
  var button = null;
  for (i = 0; i < group.length; i++) {
    if (group[i].checked) {
      button = group[i].id;
      var note = new Audio(sounds[button]);
      note.play();
      setInterval(function () {
        if (note.currentTime > dur)
          note.pause();
      }, 10);
    }
  }

  hist.executeAction(new TempUndoRedo(button, dur, noteDur));
}


function addTempNote(note, dur) {
  switch(dur) {
    case 0:
      dur = 0.25;
      noteDur = "eighth";
      break;
    case 1:
      dur = 0.5;
      noteDur = "quarter";
      break;
    case 2:
      dur = 1;
      noteDur = "half";
      break;
    case 3:
      dur = 2;
      noteDur = "whole";
      break;
  }

  hist.executeAction(new TempUndoRedo(note, dur, noteDur));
}


function keyEvent() {
  var previous = document.getElementById("sheet-music").lastChild;
  if (previous.classList.contains("staff-header")) {
    return;
  } else {
    var note = previous.lastChild.classList.item(0);
    var dur = document.getElementById("duration").selectedIndex;

    hist.executeAction(new UndoRedo(note, dur));
  }
}


function updateUI() {
  document.getElementById("undo").disabled = !hist.canUndo();
  document.getElementById("redo").disabled = !hist.canRedo();
}


function save() {
  var variables = parseNotes();
  var tones = variables[0];
  var dur = variables[1];
  var musicString = '';

  console.log("Creating song to save");
  for (var i = 0; i < tones.length; i++) {
    musicString += tones[i] + ' ' + dur[i] + ' ';
  }

  console.log("Song: " + musicString);
  document.cookie = "songToSave=" + musicString;
  var title = document.getElementById("songTitle").value;
  console.log(title);
  document.cookie = "songTitle=" + title;
}


function undrawNote() {
  var music = document.getElementById("sheet-music");
  if (music.classList.contains("staff-header")) {
    return null;
  } else if (music.lastChild.lastChild.classList.contains("gray")) {
    return music.lastChild;  
  } else {
    console.log("Undrawing Note: " + music.lastChild.lastChild.classList);
    return music.removeChild(music.lastChild);
  }
}


function updateLastNote() {
  var previous = undrawNote().lastChild;
  if (previous != null) {
    var note = previous.classList.item(0);
    console.log("Note to be re-added: " + note);
    console.log("Note is type: " + typeof note);
    var dur = document.getElementById("duration").selectedIndex;
    addTempNote(note, dur);
  }
}

function activateButton() {
  var comboBox = document.getElementById("songsOnFile");
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


var hist = new History();

// attach all functions to html elements
window.onload = function () {
  document.getElementById("confirm").onclick = keyEvent;
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
