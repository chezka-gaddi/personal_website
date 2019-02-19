window.onscroll = function() {
  changeActive();
}

function changeActive() {
  var current = window.pageYOffset;
  var profile = document.getElementById("profile");
  var profileOffset = profile.offsetTop;
  var education = document.getElementById("education");
  var educationOffset = education.offsetTop;
  var experience = document.getElementById("experience");
  var experienceOffset = experience.offsetTop;
  var skills = document.getElementById("skills");
  var skillsOffset = skills.offsetTop;
  var projects = document.getElementById("projects");
  var projectsOffset = projects.offsetTop;
  var contact = document.getElementById("contact");
  var contactOffset = contact.offsetTop;

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
