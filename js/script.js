function bioNext() {
  var boringF = document.getElementById("boringFacts");
  var funF = document.getElementById("funFacts");
    if (boringF.style.display === "none") {
      boringF.style.display = "block";
      funF.style.display = "none";
    } else {
      boringF.style.display = "none";
      funF.style.display = "block";
    }
  }
