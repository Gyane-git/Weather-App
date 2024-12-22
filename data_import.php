<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
// Select weather data for given parameters
date_default_timezone_set("Asia/Kathmandu");
$sql = "SELECT *
FROM weather
WHERE city = '{$_GET['city']}'
AND weather_when >= DATE_SUB(NOW(), INTERVAL 300 SECOND)
ORDER BY weather_when DESC limit 1";
$result = $mysqli -> query($sql);

// If 0 record found
if($result->num_rows==0){
$url = 'https://api.openweathermap.org/data/2.5/weather?q=' . $_GET['city'] . '&appid=bab281d79e5f1e9755a68d754cc313e7&units=metric';

// Get data from openweathermap and store in JSON object
$data = file_get_contents($url);
$json = json_decode($data, true);
// Fetch required fields
$weather_description = $json['weather'][0]['description'];
$weather_temperature = $json['main']['temp'];
$weather_wind = $json['wind']['speed'];
$weather_humidity=$json['main']['humidity'];
$weather_when =  date("Y-m-d H:i:s"); // now
$city = $json['name'];
$weather_temperature_min = $json['main']['temp_min'];
$weather_temperature_max= $json['main']['temp_max'];
// Build INSERT SQL statement
$sql = "INSERT INTO weather values('{$weather_description}','{$weather_temperature}','{$weather_wind}','{$weather_humidity}','{$weather_when}','{$city}','{$weather_temperature_min}','{$weather_temperature_max}')";

// Run SQL statement and report errors
if (!$mysqli -> query($sql)) {
echo("<h4>SQL error description: " . $mysqli -> error . "</h4>");
}
}
?>