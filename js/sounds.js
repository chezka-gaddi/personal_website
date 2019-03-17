var sounds = [
  "../res/notes/C4.wav",
	"../res/notes/D4.wav",
	"../res/notes/E4.wav",
	"../res/notes/F4.wav",
	"../res/notes/G4.wav",
	"../res/notes/A4.wav",
	"../res/notes/B4.wav",
	"../res/notes/C5.wav"]

var snd = new Audio();
snd.autoplay = false;
var song = [];
var duration = [];

function playSound()
{
	var index = 0;
  time = 0;
	snd = new Audio(song[index]);
  snd.play();

  setInterval(function() {
    if (snd.currentTime > duration[index])
      snd.pause();
      }, 500);

	//when the sound ends, move to the next
	snd.onpause = function() {
   	index++;
		if(sounds.length > index)
		{
	    snd.src=song[index];
		  snd.play();
		}
	};
}

//helper class to handle the current location in the undo/redo list
function History() {
	var UndoRedos =[];
	var index = 0

	//new UndoRedo, remove everything after the current UndoRedo index
	//and append the new function
	this.executeAction = function(cmd){
		UndoRedos.length = index; //trims length from 0 to index
		UndoRedos.push(cmd);
		index = UndoRedos.length

		//run the UndoRedo and update
		cmd.exec();
		updateUI();
	}


	//undo called. Call the undo function on the current UndoRedo and move back one
	this.undoCmd = function(){
		if(index > 0)
		{
			var cmd = UndoRedos[index-1];
			cmd.undo();
			index= index - 1;
			updateUI();
		}
	}

	//redo called. Call the execution function on the current UndoRedo and move forward one
	this.redoCmd = function(){
		if(index < UndoRedos.length)
		{
			var cmd = UndoRedos[index];
			cmd.exec();
			index = index + 1;
			updateUI();
		}
	}

	//is undo available
	this.canUndo = function(){
		return UndoRedos.length > 0;
	}

	//is redo available
	this.canRedo = function(){
		return index < UndoRedos.length;
	}
}


//concrete UndoRedo class. Since we have undo and redo, we much have
//a "action" (exec) function and an undo
//ideally, this should forward these calls onto the class that does the task
function UndoRedo(letter, note, dur){
	this.letter = letter;
  this.note = note;
  this.dur = dur;
  this.noteDur = 2;
  if (dur < 0.5)
    this.noteDur = "eighth";
  else if (dur < 1)
    this.noteDur = "quarter";
  else if (dur < 2)
    this.noteDur = "half";

	this.exec = function(){
    var newId = "new" + idNum;
    idNum += 1;

		var out = document.getElementById("change")
		out.innerHTML += " " + letter.toUpperCase();

		var container = document.createElement("div");
    container.classList.add("bar");
    var divnode = document.createElement("div");
    divnode.setAttribute("id", newId);
    divnode.classList.add(this.noteDur);
    divnode.classList.add(letter);

    container.appendChild(divnode);
    document.getElementById("sheet-music").appendChild(container);

    song.push(sounds[note]);
    duration.push(dur);
	}

	// removes note
	this.undo = function(){
		var out = document.getElementById("change");
		out.innerHTML = out.innerHTML.slice(0,-2);
    var music = document.getElementById("sheet-music");
    music.removeChild(music.lastChild);
    song.pop();
    duration.pop();
	}
}

function keyEvent() {
  var i, group = document.getElementsByName("notes");
  var dur = document.getElementById("length").value;

  for (i = 0; i < group.length; i++) {
    if (group[i].checked)
      button = group[i].id;
      group[i].checked = false;
  }

  var val = document.getElementById(button).value;
  hist.executeAction(new UndoRedo(button.toLowerCase(), val, dur));
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

  for (i = 0; i < group.length; i++) {
    if (group[i].checked) {
      button = group[i].id;
      var val = group[i].value;

      var note = new Audio(sounds[val]);
      note.play();
      setInterval(function() {
        if (note.currentTime > dur)
          note.pause();
        }, 10);
    }
  }
}

var hist = new History();
var idNum = 0

// attach all functions to html elements
window.onload = function() {
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
}
