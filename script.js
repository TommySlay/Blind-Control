// DEFINIRANJE POCETNIH VARIJABLI

var isConneted = false; // Pocetna vrijednost switcha konekcije
var auto = false; // Pocetna vrijednost switcha moda rada

// FUNKCIJA ZA SLANJE PODATKA POLOZAJA SA TIPKALA U DATA BAZU

function postStat(e) {
  e.preventDefault(); // Bez refresh-anja stranice
  if(isConneted == true){

  var val = e.target.value;
  console.log("Position set to: " + val);

  var params = "Stat=" + val; // Postavljanje vrijednosti za upisivanje u DB

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "prijava.php", true); // Otvaranje PHP-a za spjanje na DB
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  xhr.send(params);
}else{
  console.log("DB NOT CONN");
}
}

var lastDbStat = ''; // Pocetna vrijednost data baze (vec je popunjena)

// FUNKCIJA ZA DOBIVANJE VRIJEDNOSTI IZ DATA BAZE


function getId() {

  var params = "ID=" + 1; // Odredivanje retka za dobivanje vrijednosti (dobiva se samo "Stat")

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "roleta_getData2.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  xhr.onload = function(){ // Funkcija koja dobivenu vrijednost sprema u varijablu i prikazuje
    var lastDbStat = xhr.response;
    
    
    console.log("String from DB: " + lastDbStat);
    showImg(lastDbStat[0]);
    
    console.log("Position is set to: " + lastDbStat[0]);
  }

  xhr.send(params);
}

// FUNKCIJA ZA ODREDIVANJE BROJA SLIKE ZA PRIKAZ

function showImg(el) {
  for (let index = 0; index < 9; index++) {
    document.getElementById("img" + index).style.display = "none";  // Prikaz bez slike
  }

  document.getElementById("img" + el).style.display = "block"; // Prikaz slike sa pripadajucim brojem

  var posOutpu = '';

  posOutpu += 

  //'<div>' + 

    '<p> POSITION ' + el + '</p>';

  //'</div>';

  document.getElementById('pics-text').innerHTML = posOutpu;

}

// FUKCIJA ZA DOBIVANJE VRIJEDNOSTI O VREMENU SA JSON WEB STRANICE


function loadWeather(){
  var xhr = new XMLHttpRequest();
  // Dohvacanje stranice ovisno o gradu i API-u
  xhr.open('GET', 'https://api.openweathermap.org/data/2.5/weather?q=Zagreb&appid=71c6ea4857590089256b7d183c3c2c9a&lang=en&units=metric');

  xhr.onload = function(){
    if(this.status == 200){
      var wData = JSON.parse(this.responseText);

      console.log("weather updated!")
      var output = ''; // Postavljanje varijable za podatke sa JSON stranice

        output += 

          '<div class="weather">' +
          // Dohvacanje ikone
          '<img src="http://openweathermap.org/img/wn/'+ wData.weather[0].icon +'@2x.png" width ="70" height = "70">' +
          // Dohvacanje temperature
          '<ul>' +
          '<li>Temp: ' + parseInt(wData.main.temp + "°C") + ' °C</li>' +
          '</ul>'+
          // Dohvacanje osjetne temperature
          '<ul>' +
          '<li>Feels like: ' + parseInt(wData.main.feels_like) + ' °C</li>' +
          '</ul>'+
          // Dohvacanje tlaka zraka
          '<ul>' +
          '<li>Preassure: ' + parseInt(wData.main.pressure) +  ' hPa</li>' +
          '</ul>'+
          // Dohvacanje vlaznosti zraka
          '<ul>' +
          '<li>Humidity: ' + parseInt(wData.main.humidity) + ' %</li>' +
          '</ul>'+
          // Dohvacanje vremena (koristi se za AUTO mod rada)
          '<ul>' +
          '<li>Weather: ' + wData.weather[0].main + '</li>' +
          '</ul>'+
          // Dohvacanje detaljnijeg vremena
          '<ul>' +
          '<li>Description: ' + wData.weather[0].description + '</li>' +
          '</ul>'+

        '</div>';

      document.getElementById('weather').innerHTML = output; // Slanje podatka u html za prikaz

      var weather = wData.weather[0].description; // Spremanje podatka  vremenu u varijablu
      console.log("Weather description" + weather);
    
      var param = "Weather=" + weather; // Pretvaranje u varijablu za slanje u DB
    
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "prijava.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      
      xhr.send(param);
    }
  }

  xhr.send();
}

// DEFINIRANJE POCETNIH VRIJEDNOSTI PREKLOPKE KONEKCIJE

var checkbox = document.querySelector("input[id=switch]"); // Odredivanje preklopke konekcije
let conn='<div class="mod"><p>DISCONNECTED</p></div>'; // Postavljanje pocetnog teksta "DISCONNECT"
var btns = document.getElementsByClassName("button"); // Dobivanje vrijednosti za tipkala
document.getElementById('connection').innerHTML = conn; // Slanje podatka u html za prikaz

// DOBIVANJE PODATKA O POLOZAJU PREKLOPKE KONEKCIJE I SLANJE PODATKA U DATA BAZU I HTML


checkbox.addEventListener('change', function() { // Budenje na pomjeni stanja

  if (this.checked) { // Uvjet "ukljuceno"
    console.log("Connected to DB!"); // Informacija u konzoli da je ukljuceno

    isConneted = true; // Pretvaranje varijable u "true" 
    for (var i = 0; i < btns.length; i++) { // Petlja za mijenjanje vrijednosti u data bazi s obzirom na pritisnuto tipkalo
      btns[i].addEventListener("click", postStat);
    }

    var conn = ''; // Pocetna varijabla za html ispis konekcije

    conn += 

    '<div class="connection">' +

    '<p>CONNECTED</p>' +  // Informacija za ispis "CONNECTED"

    '</div>';

    document.getElementById('connection').innerHTML = conn; // Slanje informacije u html
    



  } else { // Uvjet "nije ukljuceno"
    console.log("Not connected to DB!");
    isConneted = false;

    var conn = '';

    conn += 

    '<p>DISCONNECTED</p>';

    document.getElementById('connection').innerHTML = conn;

  }
});



// DEFINIRANJE POCETNIH VRIJEDNOSTI PREKLOPKE MODA RADA

var mode = document.querySelector("input[id=mode]"); // Odredivanje preklopke moda rada
let mod='<div class="mod"><p>MANUAL</p></div>'; // Postavljanje pocetnog teksta "MANUAL"
document.getElementById('mod').innerHTML = mod; // Slanje informacije u html za prikaz

// DOBIVANJE PODATKA O POLOZAJU PREKLOPKE KONEKCIJE I SLANJE PODATKA U DATA BAZU I HTML

mode.addEventListener('change', function(e) {
  if (this.checked) {
    console.log("SET TO AUTO!");

    var mod = '';

    e.preventDefault();
  
    var val = 1; // Za "AUTO" mod rada je odredena vrijednost 1 koja se sprema u data bazu
  
    var param = "Mode=" + val;
  
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "prijava.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    xhr.send(param);

    mod += 

    '<div class="mod"><p>AUTO</p></div>';

    document.getElementById('mod').innerHTML = mod;



  } else {
    console.log("SET TO MANUAL!");

    var mod = '';

    e.preventDefault();
  
    var val = 2; // Za "MANUAL" mod rada je odredena vrijednost 2 koja se sprema u data bazu
  
    var param = "Mode=" + val;
  
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "prijava.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      
    xhr.send(param);

    mod += 

    '<div class="mod"><p>MANUAL</p></div>';

    document.getElementById('mod').innerHTML = mod;

  }
});

// FUNKCIJA KOJA POSTAVLJA POCETNU VRIJEDNOST U DATA BAZI KAO "MANUAL"

function pocetno(){
    
  var val = 2;
  console.log("SET TO MANUAL!");

  var param = "Mode=" + val;

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "prijava.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    

  xhr.send(param);
}

// POZIV FUNKCIJE POCETNO
pocetno();

// POZIV FUNKCIJE ZA DOBIVANJE VRIJEDNOSTI POLOZAJA IZ DATA BAZE
getId();

// POZIV FUNKCIJE ZA DOBIVANJE PODATAKA VREMENA I SLANJE U DATA BAZU
loadWeather();

// ODREDIVANJE VREMENA POZIVA FUNKCIJE (SVAKIH 10 SEKUNDI)
setInterval(function(){
  getId()
},10000)

// ODREDIVANJE VREMENA POZIVA FUNKCIJE (SVAKIH 10 SEKUNDI)
setInterval(function(){
  loadWeather()
},10000)