/***************************************************************************
 * @file
 * @brief Contains all the dictionaries, classes and functions to play Audio 
 **************************************************************************/

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
  var variables = parseNotes();
  var tones = variables[0];
  var dur = variables[1];
  var tempo = document.getElementById("tempo").checked;
  if (tempo) {
    tempo = 2;
  } else {
    tempo = 1;
  }

  var index = 0;
  snd = new Audio(sounds[tones[index]]);
  snd.play();

  console.log("Tempo: " + tempo)
  console.log("Duration: " + duration[dur[index]])
  var x = setInterval(function () {
    if (snd.currentTime > (duration[dur[index]]/tempo))
      snd.pause();
  }, 500);

  snd.onpause = function () {
    index++;
    if (tones.length > index) {
      snd.src = sounds[tones[index]];
      snd.play();
    } else {
      clearInterval(x);
    }
  };
}

