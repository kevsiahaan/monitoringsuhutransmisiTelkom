#include <ESP8266HTTPClient.h>
#include <ESP8266WiFi.h>
#include <WiFiClientSecure.h>
#include <UniversalTelegramBot.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>
LiquidCrystal_I2C lcd(0x27, 16, 2);//atau 0x3F

WiFiClient wifiClient;

// Wifi network station credentials
#define WIFI_SSID "NETWORK ARNET"
#define WIFI_PASSWORD "telkom2021"
// Telegram BOT Token (Get from Botfather)
#define BOT_TOKEN "1921527598:AAHrvcYYHNlc2zKFvISkA1sOlXIwUJO8ye8"

const unsigned long BOT_MTBS = 1000; // mean time between scan messages

X509List cert(TELEGRAM_CERTIFICATE_ROOT);
WiFiClientSecure secured_client;
UniversalTelegramBot bot(BOT_TOKEN, secured_client);
unsigned long bot_lasttime; // last time messages' scan has been done


void handleNewMessages(int numNewMessages)
{
  Serial.print("handleNewMessages ");
  Serial.println(numNewMessages);

  for (int i = 0; i < numNewMessages; i++)
  {
    String chat_id = bot.messages[i].chat_id;
    String text = bot.messages[i].text;

    String from_name = bot.messages[i].from_name;
    if (from_name == "")
      from_name = "Guest";

    if (text == "/temperature")
    {
      delay(2000);
      int dataadc = analogRead(A0);
      float suhu = dataadc * (3.3 / 1023.0) * 100.0;
      float fahrenheit = (9 / 5 * suhu) + 32;
      float kelvin    = suhu + 273.15;
      String temp = " Temperature : \n";
      temp += float(suhu);
      temp += " *C \n";
      temp += float(fahrenheit);
      temp  += " *F \n";
      temp  += float(kelvin);
      temp  += " *K";
      bot.sendMessage(chat_id, temp, "");
    }

    if (text == "/voltage")
    {
      delay(2000);
      int dataadc = analogRead(A0);
      float v = dataadc * (3.3 / 1023.0);
      String hum = "Voltage : ";
      hum += float(v);
      hum += " volt";
      bot.sendMessage(chat_id, hum, "");
    }
    if (text == "/start")
    {
      String welcome = "Welcome to bot monitoring temperature R.Transmission Telkom Pematang Siantar\n" + from_name + ".\n";
      welcome += "Select Command : \n\n";
      welcome += "/temperature : display current temperature\n";
      welcome += "/voltage : display current volt in device\n";
      bot.sendMessage(chat_id, welcome, "Markdown");
    }
  }
}

// Inisialisasi Variabel host untuk IP address Server(Komputer)
const char* server = "192.168.1.3";

void setup()
{
  Serial.begin(115200);
  Serial.println();
  lcd.begin();
  lcd.clear();
  lcd.noCursor();


  // attempt to connect to Wifi network:
  configTime(0, 0, "pool.ntp.org");      // get UTC time via NTP
  secured_client.setTrustAnchors(&cert); // Add root certificate for api.telegram.org
  Serial.print("Connecting to Wifi SSID ");
  Serial.print(WIFI_SSID);
  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);
  while (WiFi.status() != WL_CONNECTED)
  {
    Serial.print(".");
    delay(500);
  }
  Serial.print("\nWiFi connected. IP address: ");
  Serial.println(WiFi.localIP());

  // Check NTP/Time, usually it is instantaneous and you can delete the code below.
  Serial.print("Retrieving time: ");
  time_t now = time(nullptr);
  while (now < 24 * 3600)
  {
    Serial.print(".");
    delay(100);
    now = time(nullptr);
  }
  Serial.println(now);
}

void loop()
{
  int dataadc = analogRead(A0);
  float suhu = dataadc * (3.3 / 1023.0) * 100.0;
  float v = dataadc * (3.3 / 1023.0);
  const int pinBuzzer = 12;
  pinMode(pinBuzzer, OUTPUT);
  delay(200);

  lcd.setCursor(0, 0);
  lcd.print("SUHU = ");
  lcd.print(suhu);
  lcd.print("     ");
  lcd.setCursor(0, 1);
  lcd.print("Tegangan = ");
  lcd.print(v);
  lcd.print("     ");
  Serial.println(suhu);
  Serial.println(v);

  if (suhu > 32) {
    digitalWrite(pinBuzzer, HIGH);
    delay(200);
    digitalWrite(pinBuzzer, LOW);
    delay(200);
    digitalWrite(pinBuzzer, HIGH);
    delay(200);
    digitalWrite(pinBuzzer, LOW);
    delay(1000);
  } else {
    digitalWrite(pinBuzzer, LOW);
  }

  if (millis() - bot_lasttime > BOT_MTBS)
  {
    int numNewMessages = bot.getUpdates(bot.last_message_received + 1);

    while (numNewMessages)
    {
      Serial.println("got response");
      handleNewMessages(numNewMessages);
      numNewMessages = bot.getUpdates(bot.last_message_received + 1);
    }

    bot_lasttime = millis();
  }

  // kirim data ke data base
  //cek koneksi nodemcu ke Web server
  WiFiClient client ;
  const int httpPort = 80 ;
  if (!client.connect(server, httpPort))
  {
    Serial.println("Gagal terkoneksi ke web server");
    return ;
  }

  //apabila terkoneksi ke web server maka kita kirim data
  HTTPClient http;

  //Siapkan variabel LINK URL untuk kirim data
  String Link = "http://"+String(server)+ "/grafiksensor/kirimdata.php?suhu=" + String(suhu);
    //eksekusi link URL
  http.begin (wifiClient, Link);
  http.GET();
  //tangkap respon kirim data
  String respon = http.getString();
  Serial.println(respon);

  delay(500);
  http.end();
  
}
