<?
include "./admin_head.php";


session_unset();
session_destroy();

move_page("./login.php");
?>s
