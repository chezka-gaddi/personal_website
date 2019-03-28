/*******************************************************************************
 * @file
 * @brief Contains all classes and functions to maintain the Undo/Redo feature.
 ******************************************************************************/

 
var hist = new History();

// REBENITSCH: MANAGE
function History() {
    var Actions = [];
    var TempActions = [];
    var index = 0;
    var tempIndex = 0;
  
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
  
      cmd.exec();
      updateUI();
    }
  
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
  
    this.canUndo = function () {
      return index > 0 || tempIndex > 0;
    }
  
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
  
  
    this.exec = function () {
      var classes = [this.note, this.noteDur, "gray"];
      drawNote(classes);
    }
    
    this.undo = function () {
      removeNote();
    }
  }
  
  
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
  
    this.exec = function () {
      console.log("Var Type of note: " + typeof this.note);
      var classes = [this.note, this.noteDur];
      drawNote(classes);
    }
  
    this.undo = function () {
      removeNote();
    }
  }
  
  
  // REBENITSCH: ACTION
  function drawNote(classes) {
    var container = document.createElement("div");
    container.classList.add("bar");
  
    var divnode = document.createElement("div");
    for (var i = 0; i < classes.length; i++) {
      divnode.classList.add(classes[i]);
    }
  
    container.appendChild(divnode);
    document.getElementById("sheet-music").appendChild(container);
  }
  
  
  // REBENITSCH: ACTION
  function removeNote() {
    var music = document.getElementById("sheet-music");
    music.removeChild(music.lastChild);
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
  
  
  function confirmNoteEvent() {
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
    
  
  function undrawNote() {
    var music = document.getElementById("sheet-music");
    if (music.classList.contains("staff-header")) {
      return null;
    } else if (music.lastChild.lastChild.classList.contains("gray")) {
      return music.lastChild;  
    } else {
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
  