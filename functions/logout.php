<?php
	session_start();
	session_destroy();
  $id = $_GET['id'];
    if (isset($_SESSION['user'])) {
      unset($_SESSION['user']["$id"]);
      header("Location: ../index.php");
    }else if (isset($_SESSION['admin'])) {
      unset($_SESSION['admin']["$id"]);
      header("Location: ../index.php");
    }else{
    	return header('Location: ../index.php');
    } 
 ?>