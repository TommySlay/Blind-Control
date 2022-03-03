// DEFINE VARIABLES

var isConneted = false; // SET INIT CONN TO DB TO FALSE
var auto = false; // SET INIT MODE TO FALSE

// POST DATA DO DB FUNCTION

function postStat(e) {
  e.preventDefault(); //NO REFRESH
  if(isConneted == true){

  var val = e.target.value;
  console.log("Position set to: " + val);

  var params = "Stat=" + val;

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "roleta_updateData1.php", true); 
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  xhr.send(params);
}else{
  console.log("DB NOT CONN");
}
}

var lastDbStat = '';

// GET POSITION FROM DB


function getId() {

  var params = "ID=" + 1;

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "roleta_getData2.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  xhr.onload = function(){
    var lastDbStat = xhr.response;
    
    
    console.log("String from DB: " + lastDbStat);
    showImg(lastDbStat[0]);
    
    console.log("Position is set to: " + lastDbStat[0]);
  }

  xhr.send(params);
}

// SHOW PICTURES ON WEBSITE

function showImg(el) {
  for (let index = 0; index < 9; index++) {
    document.getElementById("img" + index).style.display = "none"; 
  }

  document.getElementById("img" + el).style.display = "block";
  var posOutpu = '';

  posOutpu += 


    '<p> POSITION ' + el + '</p>';


  document.getElementById('pics-text').innerHTML = posOutpu;

}

// GET WEATHER FROM WEATHER API "open world weather"


function loadWeather(){
  var xhr = new XMLHttpRequest();

  xhr.open('GET', 'https://api.openweathermap.org/data/2.5/weather?q=Zagreb&appid=71c6ea4857590089256b7d183c3c2c9a&lang=en&units=metric');

  xhr.onload = function(){
    if(this.status == 200){
      var wData = JSON.parse(this.responseText);

      console.log("weather updated!")
      var output = ''; 

        output += 

          '<div class="weather">' +
          // picture
          '<img src="http://openweathermap.org/img/wn/'+ wData.weather[0].icon +'@2x.png" width ="70" height = "70">' +
          // temperatur
          '<ul>' +
          '<li>Temp: ' + parseInt(wData.main.temp + "°C") + ' °C</li>' +
          '</ul>'+
          // real feel
          '<ul>' +
          '<li>Feels like: ' + parseInt(wData.main.feels_like) + ' °C</li>' +
          '</ul>'+
          // preassure
          '<ul>' +
          '<li>Preassure: ' + parseInt(wData.main.pressure) +  ' hPa</li>' +
          '</ul>'+
          // humidity
          '<ul>' +
          '<li>Humidity: ' + parseInt(wData.main.humidity) + ' %</li>' +
          '</ul>'+
          // current weather
          '<ul>' +
          '<li>Weather: ' + wData.weather[0].main + '</li>' +
          '</ul>'+
          // description
          '<ul>' +
          '<li>Description: ' + wData.weather[0].description + '</li>' +
          '</ul>'+

        '</div>';

      document.getElementById('weather').innerHTML = output; 

      var weather = wData.weather[0].description; 
      console.log("Weather description" + weather);
    
      var param = "Weather=" + weather; 
    
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "roleta_updateData1.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      
      xhr.send(param);
    }
  }

  xhr.send();
}

// STARTING VALUES OF SWITCH "DISCONNECT"

var checkbox = document.querySelector("input[id=switch]"); 
let conn='<div class="mod"><p>DISCONNECTED</p></div>'; 
var btns = document.getElementsByClassName("button"); 
document.getElementById('connection').innerHTML = conn; 

// CONNECT OR DISCONNECT FROM DB


checkbox.addEventListener('change', function() { 

  if (this.checked) { 
    console.log("Connected to DB!"); 

    isConneted = true; 
    for (var i = 0; i < btns.length; i++) { 
      btns[i].addEventListener("click", postStat);
    }

    var conn = ''; 

    conn += 

    '<div class="connection">' +

    '<p>CONNECTED</p>' +  

    '</div>';

    document.getElementById('connection').innerHTML = conn; 
    



  } else { 
    console.log("Not connected to DB!");
    isConneted = false;

    var conn = '';

    conn += 

    '<p>DISCONNECTED</p>';

    document.getElementById('connection').innerHTML = conn;

  }
});



// START POSITION OF AUTO/MANUAL MODE

var mode = document.querySelector("input[id=mode]"); 
let mod='<div class="mod"><p>MANUAL</p></div>'; 
document.getElementById('mod').innerHTML = mod; 

// SET MODE MANUAL/AUTO
mode.addEventListener('change', function(e) {
  if (this.checked) {
    console.log("SET TO AUTO!");

    var mod = '';

    e.preventDefault();
  
    var val = 1; 
  
    var param = "Mode=" + val;
  
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "roleta_updateData1.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    xhr.send(param);

    mod += 

    '<div class="mod"><p>AUTO</p></div>';

    document.getElementById('mod').innerHTML = mod;



  } else {
    console.log("SET TO MANUAL!");

    var mod = '';

    e.preventDefault();
  
    var val = 2; 
    var param = "Mode=" + val;
  
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "roleta_updateData1.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      
    xhr.send(param);

    mod += 

    '<div class="mod"><p>MANUAL</p></div>';

    document.getElementById('mod').innerHTML = mod;

  }
});

// STARTING VALUE IS MANUAL

function starting(){
    
  var val = 2;
  console.log("SET TO MANUAL!");

  var param = "Mode=" + val;

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "roleta_updateData1.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    

  xhr.send(param);
}

// WHEN PAGE IS REFREASHED OR OPENED FOR THE FIRST TIME

starting();


getId();


loadWeather();


setInterval(function(){
  getId()
},10000)


setInterval(function(){
  loadWeather()
},10000)