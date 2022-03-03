
//-----------------INCLUDED LIBRARIES-----------------------
#include <WiFi.h>
#include <WiFiClient.h>
#include <HTTPClient.h>
#include <Stepper.h>
#include <Arduino.h>


//----------------PIN DEFINITIONS----------------------------
#define ON_Board_LED 2
#define stepPin 15
#define dirPin 4
#define btUp 5
#define btDn 18
#define manualMode 19


//----------------INTERNET CONNECTION VARIABLES-----------------------
const char* ssid = ""; 
const char* password = ""; 


//-----------------WEBSITE----------------------
const char *host = "";


//---------------VARIABLES DEFINITONS-------------------------

int currentPos; // curretn position
int previousPos = 0; // previous position
int revolutions; // number of revolutions
int btnPos;

bool flag = false; // flag for first run
bool flagBtnMode = false; //flag for button mode first run

Stepper mystepper(400, stepPin,dirPin); // stepper define

void setup() {

  //-----------------STEPPER SETUP---------------------
  mystepper.setSpeed(200); // step speed set to 800 RPM


  //------------------PIN DECLERATIONS-----------------
  pinMode(stepPin, OUTPUT); // pulse for stepper driver
  pinMode(dirPin, OUTPUT); // direction of rotation
  pinMode(ON_Board_LED,OUTPUT);
  digitalWrite(ON_Board_LED, LOW); // set on board led off

  pinMode(btUp, INPUT_PULLUP);
  pinMode(btDn, INPUT_PULLUP);
  pinMode(manualMode, INPUT_PULLUP);

  //-------------SERIAL COMUNICATION----------------------
  Serial.begin(9600);
  delay(500);


  //-----------------CONNECTION TO WIFI---------------------
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  Serial.println("");
    

  //--------------WAIT FOR WIFI TO CONNECT------------------
  Serial.print("Connecting");
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    //----------------ON BOARD LED BLINK IF UNTIL CONNECTION----------------
    digitalWrite(ON_Board_LED, LOW);
    delay(250);
    digitalWrite(ON_Board_LED, HIGH);
    delay(250);
  
  }

  digitalWrite(ON_Board_LED, HIGH); // turn ON on board led if connection is established 
  Serial.println("");
  Serial.print("Successfully connected to : ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
  Serial.println();

}

void loop() {
  flagBtnMode = false;
  

  HTTPClient http; // declare object of class HTTPClient

  //------------------GETTING DATA FROM DATABASE--------------------
  String GetAddress, LinkGet, getData;
  int id = 1;
  GetAddress = "roleta_getData2.php";
  LinkGet = host + GetAddress; 
  getData = "ID=" + String(id);
  Serial.println("----------------Connect to Server-----------------");
  Serial.println("Get Position from Database");
  Serial.print("Request Link: ");
  Serial.println(LinkGet);
  http.begin(LinkGet); // specify request destination
  http.addHeader("Content-Type", "application/x-www-form-urlencoded"); // specify content-type header
  int httpCodeGet = http.POST(getData); // send the request
  String payloadGet = http.getString(); // get the response payload from database
  Serial.print("Response Code : "); //--> if response code = 200 means successful connection, if -1 means connection failed.
  Serial.println(httpCodeGet); // print HTTP return code
  Serial.print("Returned ALL data from database: ");
  Serial.println(payloadGet); 
  Serial.print("Returned POSITION data from database: ");
  Serial.println(payloadGet[0]);
  char payloadPos = payloadGet[0];
  Serial.print("Returned MODE data from database: ");
  Serial.println(payloadGet[1]); 
  char payloadMod = payloadGet[1];
  Serial.print("Returned clear data from database: ");
  Serial.println(payloadGet[2]);
  char payloadWea = payloadGet[2];
  Serial.println("Flag button Mode: ");
  Serial.println(flagBtnMode);


  //-----------------------DISCONNECTING FROM DATABASE---------------
  
  Serial.println("----------------Closing Connection----------------");
  http.end(); // close connection
  Serial.println();
  Serial.println("Please wait 1 seconds for the next connection.");
  Serial.println();

  delay(1000); // GET data at every 1 seconds


  //----------------MOTOR CONTROL----------------------

  if (httpCodeGet == 200){

    currentPos = (int) payloadPos;
    btnPos = (int) payloadPos;
    Serial.println(payloadPos);
    Serial.println(currentPos);

    if(flag == false){
      previousPos = currentPos;
      flag = true;
    }
    
    revolutions = (currentPos - previousPos) * 4000; 
    previousPos = currentPos;

    mystepper.step(revolutions);


  }else {
    Serial.println("ERROR");
  
  }


  //------------BUTTON MODE------------------

  while (digitalRead(manualMode) == 0 ){

    Serial.println("BUTTON MODE");

    if(flagBtnMode == false){
    flagBtnMode = true;
    btnPos = btnPos - 48;
    flag = false;
    }

    Serial.println("Position: ");
    Serial.println(btnPos);
    Serial.println("Flag button Mode: ");
    Serial.println(flagBtnMode);


    while(digitalRead(btUp) == 0 && btnPos < 8){

    mystepper.step(800);
    btnPos ++;
    Serial.println(btnPos);


    }

    while(digitalRead(btDn) == 0 && btnPos > 0){

      mystepper.step(-800);
      btnPos --;
      Serial.println(btnPos);


    }

    //-------------POST DATA TO DATABASE----------------
    String PostAddress, LinkPost, PostData;

    PostAddress = "roleta_updateData2.php";
    LinkPost = host + PostAddress;

    PostData = "Stat=" + String(btnPos);
    Serial.println(PostData);
    Serial.println("----------------Connect to Server-----------------");
    Serial.println("Post Data to Database");
    Serial.print("Request Link: ");
    Serial.println(LinkPost);
    http.begin(LinkPost); // specify request destination
    http.addHeader("Content-Type", "application/x-www-form-urlencoded"); // specify content-type header
    int httpCodePost = http.POST(PostData); // send the request
    Serial.print("Response Code : "); // if response code = 200 means successful connection, if -1 means connection failed
    Serial.println(httpCodePost); // print HTTP return code

    //-----------------------DISCONNECTING FROM DATABASE---------------
  
    Serial.println("----------------Closing Connection----------------");
    http.end(); // close connection
    Serial.println();
    delay(200);

    
  }



  //-----------------------AUTO MOD RADA---------------------------
  
  while( payloadMod == '1'){


    if(payloadWea == 'c'){
      String PostAddress, LinkPost, PostData;

      PostAddress = "roleta_updateData2.php";
      LinkPost = host + PostAddress;

      PostData = "Stat=" + String(0);
      Serial.println(PostData);
      Serial.println("----------------Connect to Server-----------------");
      Serial.println("Post Data to Database");
      Serial.print("Request Link: ");
      Serial.println(LinkPost);
      http.begin(LinkPost); // specify request destination
      http.addHeader("Content-Type", "application/x-www-form-urlencoded"); // specify content-type header
      int httpCodePost = http.POST(PostData); // send the request
      Serial.print("Response Code : "); // if response code = 200 means successful connection, if -1 means connection failed
      Serial.println(httpCodePost); // print HTTP return code

      //-----------------------DISCONNECTING FROM DATABASE---------------
    
      Serial.println("----------------Closing Connection----------------");
      http.end(); // close connection
      Serial.println();
      delay(200);

    }else{
      String PostAddress, LinkPost, PostData;
      PostAddress = "roleta_updateData2.php";
      LinkPost = host + PostAddress;

      PostData = "Stat=" + String(8);
      Serial.println(PostData);
      Serial.println("----------------Connect to Server-----------------");
      Serial.println("Post Data to Database");
      Serial.print("Request Link: ");
      Serial.println(LinkPost);
      http.begin(LinkPost); // specify request destination
      http.addHeader("Content-Type", "application/x-www-form-urlencoded"); // specify content-type header
      int httpCodePost = http.POST(PostData); // send the request
      Serial.print("Response Code : "); // if response code = 200 means successful connection, if -1 means connection failed
      Serial.println(httpCodePost); // print HTTP return code

      //-----------------------DISCONNECTING FROM DATABASE---------------
    
      Serial.println("----------------Closing Connection----------------");
      http.end(); // close connection
      Serial.println();
      
      delay(200);
      Serial.println("Weather is not clear!");
    }
    break;
  }

}