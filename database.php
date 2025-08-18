<?php
//Database Connection
$conn = new mysqli('localhost', 'root', '', 'admin'); 
if($conn->connect_error){
    die('Connection Failed  : ' .$conn->connect_error);
}
?>