var btns = document.getElementsByClassName("button");
var lastDbStat = '';


// ---------------------------------

for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", postStat);
}

function postStat(e) {
  e.preventDefault();

  var val = e.target.value;
  console.log(e);

  var params = "Stat=" + val;

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "prijava.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  xhr.send(params);
}

function showImg(el) {
  for (let index = 0; index < 9; index++) {
    document.getElementById("img" + index).style.display = "none";
  }

  document.getElementById("img" + el).style.display = "block";
}

function getId() {

  var params = "ID=" + 1;

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "roleta_getData2.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  xhr.onload = function(){
    var lastDbStat = xhr.response;
    showImg(lastDbStat);
    console.log(lastDbStat);
  }

  xhr.send(params);
}


//-----------------------------------------------------

getId();