<?php
include("funcs.php");
include("db.php");
include("user_db_list.php");

session_start();

// 認証下
sschk();

$id = $_GET["id"];

v($id);

$val= bookmark_del($id);



?>
