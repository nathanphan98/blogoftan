<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include "includes/database.php";
include "includes/users.php";
$database = new database();
$db = $database->connect();
$new_user = new user($db);
?>
