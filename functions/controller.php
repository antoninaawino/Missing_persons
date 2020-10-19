<?php

require_once 'funct.php';

$app = new App();

if (isset($_POST['register'])) {
	if (isset($_POST['role'])) {
		$role = $_POST['role'];
	}else {
		$role = 'user';
	}
	$id_no = htmlspecialchars(strip_tags($_POST['id_no']));
	$fname = htmlspecialchars(strip_tags($_POST['fname']));
	$email = htmlspecialchars(strip_tags($_POST['email']));
	$phone = htmlspecialchars(strip_tags($_POST['phone']));
	$password = htmlspecialchars(strip_tags($_POST['password']));
	$cpassword = htmlspecialchars(strip_tags($_POST['cpassword']));
	if (empty($id_no) || empty($fname) || empty($email) || empty($phone) || empty($password) || empty($password) || empty($cpassword)) {
		$_SESSION['error'] = "Some fields are not filled";
	}
	if ($password !== $cpassword) {
		$_SESSION['error'] = 'Password mismatch';
	}
	if ($app->checkUser($email, $phone) !== 'success') {
		$_SESSION['error'] = $app->checkUser($email, $phone);
	}
	if (isset($error)) {
		return header('Location: ../register.php');
	} elseif ($app->createUser($id_no, $fname, $email, $phone, $password,$role)) {
		$_SESSION['success'] = "Account created successfully";
		return header('Location: ../login.php');
	}
}

if (isset($_POST['login'])) {
	$email = htmlspecialchars(strip_tags($_POST['email']));
	$password = htmlspecialchars(strip_tags($_POST['password']));
	if ($app->checkUser($email, NULL) == 'success') {
		$_SESSION['error'] = 'You have no account yet please register';
		header('Location: ../login.php');
	} elseif ($app->login($email, $password) == 'true') {
		return header('Location: ../index.php');
	} else {
		$_SESSION['error']= $app->login($email, $password);
		header('Location: ../login.php');
	}
}

if (isset($_POST['create_lost'])) {
	$name = htmlspecialchars(strip_tags($_POST['fname']));
	$place = htmlspecialchars(strip_tags($_POST['place']));
	$rplace = htmlspecialchars(strip_tags($_POST['rplace']));
	$email = htmlspecialchars(strip_tags($_POST['email']));
	$phone = htmlspecialchars(strip_tags($_POST['phone']));
	$comment = htmlspecialchars(strip_tags($_POST['comment']));
	$date = htmlspecialchars(strip_tags($_POST['date']));
	$image = $_FILES['image'];
	
	if (!empty($name) && !empty($place) && !empty($rplace) && !empty($email) && !empty($phone) && !empty($comment) && !empty($date)) {
		if ($app->createLost($name, $place, $rplace, $email, $phone, $comment, $date) == 'true') {
			$_SESSION['success'] = 'Person added successfully';
			header('Location: ../create-lost.php');
		}
	} else {
		$_SESSION['error'] = "Some fields cannot be left empty";
		return header('Location: ../create-lost.php');
	}
}
if (isset($_POST['create_found'])) {
	$name = htmlspecialchars(strip_tags($_POST['fname']));
	$place = htmlspecialchars(strip_tags($_POST['place']));
	$email = htmlspecialchars(strip_tags($_POST['email']));
	$phone = htmlspecialchars(strip_tags($_POST['phone']));
	$comment = htmlspecialchars(strip_tags($_POST['comment']));
	$date = htmlspecialchars(strip_tags($_POST['date']));

	if (!empty($name) && !empty($place) && !empty($email) && !empty($phone) && !empty($comment) && !empty($date)) {
		if ($app->createFound($name, $place, $email, $phone, $comment, $date) == 'true') {
			$_SESSION['success'] = "Person added successfully";
			return header('Location: ../create-found.php');
		} else {
			$_SESSION['error'] = $app->createFound($name, $place, $email, $phone, $comment, $date);
			return header('Location: ../create-found.php');
		}
	} else {
		$_SESSION['error'] = 'Some fields cannot be left empty';
		return header('Location: ../create-found.php');
	}
}

if (isset($_GET['pid']) && isset($_GET['tab'])) {
	$id = htmlspecialchars(strip_tags($_GET['pid']));
	$table = $_GET['tab'];
	if ($table=='lost') {
		$url = 'manage-lost.php';
	}elseif ($table == 'found') {
		$url = 'manage-found.php';
	}
	if (!empty($id) && !empty($table)) {
		if ($app->approveLost($id,$table)) {
			$_SESSION['success'] = "Approved successfully";
			return header("Location: ../$url");
		}else {
			$_SESSION['error'] = "Could not approve";
		}
	}

}
