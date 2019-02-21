window.onscroll = function() {
  changeActive();
  createProgressBars();
}

window.onload = function() {
  createProgressBars();
}

function changeActive() {
  var current = window.pageYOffset;
  var education = document.getElementById("education");
  var educationOffset = education.offsetTop;
  var offset = educationOffset / 5;
  educationOffset -= offset;
  var experience = document.getElementById("experience");
  var experienceOffset = experience.offsetTop;
  experienceOffset -= offset;
  var skills = document.getElementById("skills");
  var skillsOffset = skills.offsetTop;
  skillsOffset -= offset;
  var projects = document.getElementById("projects");
  var projectsOffset = projects.offsetTop;
  projectsOffset -= offset;
  var contact = document.getElementById("contact");
  var contactOffset = contact.offsetTop;
  contactOffset -= offset;

  if (current < educationOffset) {
    document.getElementById("profileButton").classList.add("active");
    document.getElementById("educationButton").classList.remove("active");
  } else if (current < experienceOffset) {
    document.getElementById("profileButton").classList.remove("active");
    document.getElementById("educationButton").classList.add("active");
    document.getElementById("experienceButton").classList.remove("active");
  } else if (current < skillsOffset) {
    document.getElementById("educationButton").classList.remove("active");
    document.getElementById("experienceButton").classList.add("active");
    document.getElementById("skillsButton").classList.remove("active");
  } else if (current < projectsOffset) {
    document.getElementById("experienceButton").classList.remove("active");
    document.getElementById("skillsButton").classList.add("active");
    document.getElementById("projectsButton").classList.remove("active");
  } else if (current < contactOffset) {
    document.getElementById("skillsButton").classList.remove("active");
    document.getElementById("projectsButton").classList.add("active");
    document.getElementById("contactButton").classList.remove("active");
  } else {
    document.getElementById("projectsButton").classList.remove("active");
    document.getElementById("contactButton").classList.add("active");
  }
}

var star =["one", "two", "three", "four", "five"];
var first = false;

function createProgressBars() {
  var current = window.pageYOffset;
  var skills = document.getElementById("skills");
  var skillsOffset = skills.offsetTop-450;

  if (current >= skillsOffset && first == false) {
    var change = document.getElementsByClassName("toRate");
    var rating = document.getElementById("rating");

    for (idx=0; idx < change.length; idx++) {
      var original = change[idx];
      var parent = document.createElement("div");
      parent.style.display = "inline-block";
      parent.innerHTML = rating.innerHTML;

      var rate = parseInt(original.innerHTML)
      for (i=0; i < rate; i++) {
        parent.getElementsByClassName(star[i])[0].style.color = "#116466";
        parent.getElementsByClassName(star[i])[0].classList.add("fadeInLeft");
        parent.getElementsByClassName(star[i])[0].classList.add("delay-1s");
      }

      original.innerHTML = parent.innerHTML;
      first = true;
    }
  }
}
