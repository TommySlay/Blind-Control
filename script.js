

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

//--------------------WEATHER---------------------------


function loadWeather(){
  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'https://api.openweathermap.org/data/2.5/weather?q=Zagreb&appid=71c6ea4857590089256b7d183c3c2c9a&lang=en&units=metric');

  xhr.onload = function(){
    if(this.status == 200){
      var wData = JSON.parse(this.responseText);

      console.log(wData);
      var output = '';

        output += 
        '<div class="weather">' +

        '<img src="http://openweathermap.org/img/wn/'+ wData.weather[0].icon +'@2x.png" width ="70" height = "70">' +

        '<ul>' +
        '<li>Temp: ' + parseInt(wData.main.temp) + '</li>' +
        '</ul>'+

        '<ul>' +
        '<li>Feels like: ' + parseInt(wData.main.feels_like) + '</li>' +
        '</ul>'+

        '<ul>' +
        '<li>Preassure: ' + parseInt(wData.main.pressure) + '</li>' +
        '</ul>'+

        '<ul>' +
        '<li>Humidity: ' + parseInt(wData.main.humidity) + '</li>' +
        '</ul>'+

        '<ul>' +
        '<li>Weather: ' + wData.weather[0].main + '</li>' +
        '</ul>'+

        '<ul>' +
        '<li>Description: ' + wData.weather[0].description + '</li>' +
        '</ul>'+

        '</div>';

      document.getElementById('weather').innerHTML = output;
    }
  }

  xhr.send();
}


//-----------------------------------------------------

// Current position
getId();

//Load weather first time
loadWeather();

// load weather every x miliseconds
setInterval(function(){
  loadWeather()
},10000)