<?php
/**
 * Created by PhpStorm.
 * User: Gennaro
 * Date: 6/6/2018
 * Time: 10:22 AM
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
$URL = $_POST["url"];

$IP = get_client_ip_env();

// Function to get the client ip address
function get_client_ip_env() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}

$unique_id = bin2hex(openssl_random_pseudo_bytes(4));

$add = $connection->prepare("INSERT INTO `urls`(`ip_address`, `url_value`, `url_short_id`) VALUES (?,?,?);");
$add->bind_param('sss',$IP,$URL, $unique_id);

$add->execute();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>url.gennaro.me</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="jumbotron text-center">
    <h1>url.gennaro.me</h1>
</div>

<div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
        <h1 class="text-center">Your Shortened URL is</h1>
        <?php
        echo '<h3 class="text-center"><a href="http://url.gennaro.me/' . $unique_id . '">http://www.url.gennaro.me/' . $unique_id .  '</a></h3>';
        ?>
    </div>
</div>



</body>
</html>

