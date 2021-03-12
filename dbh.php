<?php

define('DB_SERVER','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME','companydata');

$conn = new mysqli('localhost','root','','companydata');
if($conn === false) {
    die ("error in connection". $conn->connect_error);
}

?>