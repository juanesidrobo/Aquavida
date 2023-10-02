<?php

/*
  Rui Santos
  Complete project details at https://RandomNerdTutorials.com/esp32-esp8266-mysql-database-php/
  
  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files.
  
  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.
*/

$servername = "localhost";

// REPLACE with your Database name
$dbname = "Aqua_vida";
// REPLACE with Database user
$username = "root";
// REPLACE with Database user password
$password = "";

// Keep this API Key value to be compatible with the ESP32 code provided in the project page. 
// If you change this value, the ESP32 sketch needs to match
$api_key_value = "tPmAT5Ab3j7F9";

$api_key= $sensor1 = $location = $value1 =$sensor2 = $value2 = $tiempo = $alarma = "";
//$action = $sensor1 = $location = $value1 =$sensor2 = $value2 = $tiempo = $alarma = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if($api_key == $api_key_value) {
        $sensor1 = test_input($_POST["sensor1"]);
        $location = test_input($_POST["location"]);
        $value1 = test_input($_POST["value1"]);
        $sensor2 = test_input($_POST["sensor2"]);
        $value2 = test_input($_POST["value2"]);
        $tiempo = test_input($_POST["tiempo"]);
        $alarma = test_input($_POST["alarma"]);
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        $sql = "INSERT INTO SensorData (sensor1, location, value1, sensor2, value2, tiempo , alarma)
        VALUES ('" . $sensor1 . "', '" . $location . "', '" . $value1 . "', '" . $sensor2 . "', '" . $value2 . "', '" . $tiempo ."', '" . $alarma . "')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
        $conn->close();
    }
    else {
        echo "Wrong API Key provided.";
    }

}
else if ($_SERVER["REQUEST_METHOD"] == "GET"){
    $api_key = test_input($_GET["api_key"]);
    if($api_key == $api_key_value){
        $varX = test_input($_GET["var"]);
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM sensordata ORDER BY id DESC LIMIT 1";
        if ($result = $conn->query($sql)) {
            $row = mysqli_fetch_row($result);
            echo $row[8];
            //echo "tiempo";
        }
        else {
            echo false;
        }
        $conn->close();
    } else {
        echo "Wrong API key provided";
    }
}
else {
    echo "No data posted with HTTP POST/GET.";
}
/*
function getAllOutputStates() {
    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT id, sensor1, location, value1, sensor2, value2, reading_time, alarma, tiempo FROM sensordata ORDER BY id DESC LIMIT 1";
    if ($result = $conn->query($sql)) {
        return $result;
    }
    else {
        return false;
    }
    $conn->close();
}*/

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
