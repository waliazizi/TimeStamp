
<?php
session_start();

$DB_host = "localhost";
$DB_user = "root";
$DB_pass = "@ll!swell";
$DB_name = "timestamp";

try {
    $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}", $DB_user, $DB_pass);
    $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}
catch(PDOException $e)
{
    echo $e->getMessage();
}
include "TSA.php";
$tsa = new TSA($DB_con);
//echo 'db is connected now!';

