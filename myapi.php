<?php
// Connect to database
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
$mysqli = new
mysqli("sql313.epizy.com","epiz_31706710","nML6muCF5RqxIs","epiz_31706710_2204769"); if ($mysqli
-> connect_errno) {
echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
exit();
}

$city=$_GET['city'];

include "data_import.php";
// Execute SQL query
$sql = "select * from weather where city='{$city}' order by weather_when desc limit 1";
$result = $mysqli -> query($sql);


// adding all the datas into the array

$row =mysqli_fetch_assoc($result);



// showing the last element of the array 
print json_encode($row);

?>


