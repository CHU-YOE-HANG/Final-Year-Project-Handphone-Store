<?php

$servername = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "phone_shop";

$connect = mysqli_connect($servername, $dbuser, $dbpassword, $dbname);

if($connect)
{
  //echo("Connect successfully!");
}

?>