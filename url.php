<?php
/**
 * Created by PhpStorm.
 * User: Gennaro
 * Date: 6/7/2018
 * Time: 6:05 PM
 */

//Database info:
$servername = "";
$username = "";
$password = "";
$dbname = "";


//Creates database connection:
$connection = new mysqli($servername, $username, $password, $dbname);

//Checks database connection
if($connection->connect_errno){
    die("Database Error.");

}

$url_unique_id = $_GET["path"];

$search = $connection->prepare("SELECT url_value from urls WHERE url_short_id = ?");
$search->bind_param('s', $url_unique_id);
$search->bind_result($url);

$search->execute();
$search->store_result();


if($search->num_rows == 0){
    echo "INVALID URL";
}
else{
    $search->fetch();
    header("location:" . $url);
}
