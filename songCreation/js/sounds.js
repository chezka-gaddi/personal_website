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

var snd = new Audio();
snd.autoplay = false;

function playSound() {
	var song = hist.getActions();
  var idx = song.length;
	var index = 0;
	snd = new Audio(sounds[song[index].note]);
  console.log(sounds[song[index].note]);
	snd.play();

	var x = setInterval(function () {
		if (snd.currentTime > song[index].dur)
			snd.pause();
	}, 500);

	//when the sound ends, move to the next
	snd.onpause = function () {
		index++;
		if (song.length > index) {
			snd.src = sounds[song[index].note];
			snd.play();
		} else {
			clearInterval(x);
		}
	};
}

//helper class to handle the current location in the undo/redo list
function History() {
	var Actions = [];
  var TempActions = [];
	var index = 0;
  var tempIndex = 0;
  
	this.getActions = function (idx) {
		var songList = Actions.slice(0, index);
    if (tempIndex > 0) {
      songList.push(TempActions[tempIndex - 1]);
    }
    return songList;
	}

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
		if (TempActions.length > 0) {
			if (tempIndex > 0) {
				TempActions[tempIndex - 1].undo();
			}
			TempActions[tempIndex].exec();
			tempIndex = tempIndex + 1;
			updateUI();
		} else if (index < Actions.length) {
			var cmd = Actions[index];
			cmd.exec();
			index = index + 1;
			updateUI();
		}
	}

	//is undo available
	this.canUndo = function () {
		return Actions.length > 0 || TempActions.length > 0;
	}

	//is redo available
	this.canRedo = function () {
		return index < Actions.length || tempIndex < TempActions.length;
	}
}


function TempUndoRedo(note, dur, noteDur) {
	this.type = "temp";
	this.note = note;
	this.dur = dur;
	this.noteDur = noteDur;

	// adds a note
	this.exec = function () {
		var out = document.getElementById("change")
		out.innerHTML += " " + this.note;

		var container = document.createElement("div");
		container.classList.add("bar");
		var divnode = document.createElement("div");
		divnode.classList.add("gray");
		divnode.classList.add(this.noteDur);
		divnode.classList.add(this.note.toLowerCase());

		container.appendChild(divnode);
		document.getElementById("sheet-music").appendChild(container);
	  document.getElementById(this.note).checked = true;
  }

	this.undo = function () {
		var out = document.getElementById("change");
		out.innerHTML = out.innerHTML.slice(0, -3);
		var music = document.getElementById("sheet-music");
		music.removeChild(music.lastChild);
	}
}


//concrete UndoRedo class. Since we have undo and redo, we much have
//a "action" (exec) function and an undo
//ideally, this should forward these calls onto the class that does the task
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
		var out = document.getElementById("change")
		out.innerHTML += " " + this.note;

		var container = document.createElement("div");
		container.classList.add("bar");
		var divnode = document.createElement("div");

		divnode.classList.add(this.noteDur);
		divnode.classList.add(this.note.toLowerCase());
    
    console.log(divnode.classList);
		container.appendChild(divnode);
		document.getElementById("sheet-music").appendChild(container);
	}

	// removes note
	this.undo = function () {
		var out = document.getElementById("change");
		out.innerHTML = out.innerHTML.slice(0, -3);
		var music = document.getElementById("sheet-music");
		music.removeChild(music.lastChild);
	}
}

function trial(event) {
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

function keyEvent() {
	var i, group = document.getElementsByName("notes");
	var dur = document.getElementById("duration").selectedIndex;

	var button = null;
	for (i = 0; i < group.length; i++) {
		if (group[i].checked) {
			button = group[i].id;
			group[i].checked = false;
		}
	}

	if (button != null) {
		hist.executeAction(new UndoRedo(button, dur));
	}
}

function updateUI() {
	document.getElementById("undo").disabled = !hist.canUndo();
	document.getElementById("redo").disabled = !hist.canRedo();
}

function save() {

}

function load() {
	return document.getElementById("change").innerHTML = "LOADING";
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
	document.getElementById("update").onclick = trial;

	document.getElementById("undo").onclick = hist.undoCmd;
	document.getElementById("redo").onclick = hist.redoCmd;
	document.getElementById("play").onclick = playSound;
	document.getElementById("save").onclick = save;
	updateUI();
}
