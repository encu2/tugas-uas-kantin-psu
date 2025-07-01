<?php
$host="151.243.222.93:38882";
$user="root";
$passw="FST_Jaya25";
$dbnm="kantin_psu";
$mysqli = new mysqli($host,$user,$passw,$dbnm);
// Check connection
if ($mysqli -> connect_errno) {
echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
exit();
}
?>
