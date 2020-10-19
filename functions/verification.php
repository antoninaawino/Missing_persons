<?php 
include 'class/class.db_connect.php';

// Email check
	if(!empty($_POST["email"])) {

	try {
		$email= $_POST["email"];
		$sql ="SELECT email FROM  users WHERE email=:email";
		$query= $db->prepare($sql);
		$query->bindParam(':email', $email, PDO::PARAM_STR);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);
	} catch (PDOException $e) {
		die($e->getMessage());
	}
	if($query -> rowCount() > 0)
	{
	echo "<span style='color:red'>Email-id already exists.</span>";
	}

	}
	// Phone check 
	if(!empty($_POST["phone"])) {

	try {
		$phone= $_POST["phone"];
		$sql ="SELECT phone FROM  users WHERE phone=:phone";
		$query= $db->prepare($sql);
		$query->bindParam(':phone', $phone, PDO::PARAM_STR);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);
	} catch (PDOException $e) {
		die($e->getMessage());
	}
	if($query -> rowCount() > 0)
	{
	echo "<span style='color:red'>Phone no already exists.</span>";
	}
}
if(!empty($_POST["ademail"])) {

	try {
		$admail= $_POST["ademail"];
		$sql ="SELECT email FROM  users WHERE email=:email";
		$query= $db->prepare($sql);
		$query->bindParam(':email', $admail, PDO::PARAM_STR);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);
	} catch (PDOException $e) {
		die($e->getMessage());
	}
	if($query -> rowCount() > 0)
	{
	echo "<span style='color:red'>Email account already taken.</span>";
	}
	}


	if(!empty($_POST["adphone"])) {


	try {
		$adphone= $_POST["adphone"];
		$sql ="SELECT phone FROM  users WHERE phone=:phone";
		$query= $db->prepare($sql);
		$query->bindParam(':phone', $adphone, PDO::PARAM_STR);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);
	} catch (PDOException $e) {
		die($e->getMessage());
	}
	if($query -> rowCount() > 0)
	{
	echo "<span style='color:red'>Phone already exists.</span>";
	}
	}

	if (!empty($_POST['txt'])) {
		
	}


 ?>