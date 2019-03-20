var sounds = {
	"C4": "../res/notes/C4.wav",
	"D4": "../res/notes/D4.wav",
	"E4": "../res/notes/E4.wav",
	"F4": "../res/notes/F4.wav",
	"G4": "../res/notes/G4.wav",
	"A4": "../res/notes/A4.wav",
	"B4": "../res/notes/B4.wav",
	"C5": "../res/notes/C5.wav"
};

var snd = new Audio();
snd.autoplay = false;

function playSound() {
	var idx = hist.getIndex();
	var song = hist.getActions();
	var index = 0;
	snd = new Audio(sounds[song[index].note]);
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
	var index = 0

	this.getIndex = function (idx) {
		return index;
	}

	this.getActions = function (idx) {
		return Actions;
	}

	//new UndoRedo, remove everything after the current UndoRedo index
	//and append the new function
	this.executeAction = function (cmd) {
		Actions.length = index;		//trims length from 0 to index
		if (index != 0 && Actions[index - 1].type == "temp") {
			Actions[index - 1].undo();
		}

		Actions.push(cmd);
		index = Actions.length;

		//run the UndoRedo and update
		cmd.exec();
		updateUI();
	}


	//undo called. Call the undo function on the current UndoRedo and move back one
	this.undoCmd = function () {
		if (index > 0) {
			var cmd = Actions[index - 1];
			cmd.undo();
			index = index - 1;

			if (index != 0 && Actions[index - 1].type == "temp") {
				cmd.exec();
			}
			updateUI();
		}
	}

	//redo called. Call the execution function on the current UndoRedo and move forward one
	this.redoCmd = function () {
		if (index < Actions.length) {
			var cmd = Actions[index];
			cmd.exec();
			index = index + 1;
			updateUI();
		}
	}

	//is undo available
	this.canUndo = function () {
		return Actions.length > 0;
	}

	//is redo available
	this.canRedo = function () {
		return index < Actions.length;
	}
}


function TempUndoRedo(note, dur) {
	this.type = "temp";
	this.note = note;
	this.dur = dur;
	this.noteDur = 2;

	if (dur < 0.5)
		this.noteDur = "eighth";
	else if (dur < 1)
		this.noteDur = "quarter";
	else if (dur < 2)
		this.noteDur = "half";

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
	this.noteDur = 2;

	if (dur < 0.5)
		this.noteDur = "eighth";
	else if (dur < 1)
		this.noteDur = "quarter";
	else if (dur < 2)
		this.noteDur = "half";

	// adds a note
	this.exec = function () {
		var out = document.getElementById("change")
		out.innerHTML += " " + this.note;

		var container = document.createElement("div");
		container.classList.add("bar");
		var divnode = document.createElement("div");
		divnode.classList.add(this.noteDur);
		divnode.classList.add(this.note.toLowerCase());

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
	var dur = document.getElementById("length").value;
	var noteDur = "whole";
	if (dur < 0.5)
		noteDur = "eighth";
	else if (dur < 1)
		noteDur = "quarter";
	else if (dur < 2)
		noteDur = "half";

	var i, group = document.getElementsByName("notes");
	var button = null;
	for (i = 0; i < group.length; i++) {
		if (group[i].checked) {
			button = group[i].id;
			var val = group[i].value;

			var note = new Audio(sounds[val]);
			note.play();
			setInterval(function () {
				if (note.currentTime > dur)
					note.pause();
			}, 10);
		}
	}

	hist.executeAction(new TempUndoRedo(button, dur));
}

function keyEvent() {
	var i, group = document.getElementsByName("notes");
	var dur = document.getElementById("length").value;

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
	document.getElementById("set").onclick = trial;

	document.getElementById("undo").onclick = hist.undoCmd;
	document.getElementById("redo").onclick = hist.redoCmd;
	document.getElementById("play").onclick = playSound;
	updateUI();
}
