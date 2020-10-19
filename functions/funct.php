<?php

declare(strict_types=1);

session_start();
date_default_timezone_set('Africa/Nairobi');
require 'database.php';
require_once 'AfricasTalkingGateway.php';
/**
 * 
 */
class App extends DB
{

	function __construct()
	{
		$this->db = parent::__construct();
	}

	public function redirect($url)
	{
		return header('Location: $url');
	}

	public function checkUser($email, $phone)
	{
		try {
			$stmt = $this->db->prepare("SELECT * FROM user_details WHERE (email=:email OR phone=:phone)");
			$stmt->execute(['email' => $email, ':phone' => $phone]);
		} catch (\PDOException $e) {
			return $e->getMessage();
		}
		if ($stmt->rowCount() > 0) {
			return 'Phone or email have been taken';
		} else {
			return 'success';
		}
	}

	public function createUser($id_no, $name, $email, $phone, $pass, $role)
	{
		try {
			$query = $this->db->prepare("INSERT INTO user_details(id_no, name, email,  phone, password,created_at) VALUES (:id_no, :name,:email, :phone, :pass, :create)");
			$query->execute(array(':id_no' => $id_no,':name' => $name,':email' => $email,':phone' => $phone,':pass' => password_hash($pass, PASSWORD_DEFAULT),':create' => date('Y-m-d H:i:s')));
			$this->createRole($email, $phone, $role);
			return TRUE;
		} catch (\PDOException $e) {
			return $e->getMessage();
		}
	}

	public function getUser($email = NULL, $phone = NULL)
	{
		try {
			$stmt = $this->db->prepare("SELECT * FROM user_details WHERE (email=:email OR phone=:phone)");
			$stmt->execute([':email' => $email, ':phone' => $phone]);
			return $stmt->fetch();
		} catch (\PDOException $e) {
			return $e->getMessage();
		}
	}

	public function getUserById($id)
	{
		try {
			$stmt = $this->db->prepare("SELECT * FROM user_details WHERE id=:id");
			$stmt->execute([':id'=>$id]);
			return $stmt->fetch();
		} catch (\PDOException $e) {
			return $e->getMessage();
		}
	}

	public function createRole($email, $phone, $role)
	{
		$user = $this->getUser($email, $phone);
		try {
			$stmt = $this->db->prepare('INSERT INTO privileges (user_id,name,created_at) VALUES (:id,:name,:created_at)');
			$stmt->execute([':id' => $user['id'], ':name' => $role, ':created_at' => date('Y-m-d H:i:s')]);
		} catch (\PDOException $e) {
			return $e->getMessage();
		}
	}

	public function login($email, $pass)
	{
		try {
			$query = $this->db->prepare("SELECT * FROM user_details WHERE email=:email OR phone=:phone LIMIT 1");
			$query->execute([':email' => $email, ':phone' => $email]);
			$user = $query->fetch();
		} catch (PDOException $e) {
			return $e->getMessage();
		}
		try {
			$stmt = $this->db->prepare('SELECT * FROM privileges WHERE user_id=:id');
			$stmt->execute([':id' => $user['id']]);
			$role = $stmt->fetch();
		} catch (\PDOException $e) {
			return $e->getMessage();
		}
		if ($query->rowCount() > 0 && $stmt->rowCount() > 0) {
			if (password_verify($pass, $user['password'])) {
				if ($role['name'] === 'user') {
					$_SESSION['user_lost_found'] = $user;
				} elseif ($role['name'] === 'admin') {
					$_SESSION['admin_lost_found'] = $user;
				}
				return TRUE;
				
			}
		} else {
			return "Invalid details provided";
		}
	}

	public function createLost($name, $place, $rplace, $email, $phone, $comment, $date)
	{
		$targetDir = "../persons/";
		$allowTypes = array('jpg', 'png', 'jpeg', 'gif');

		if (!empty(array_filter($_FILES['image']))) {
			foreach ($_FILES['image']['name'] as $key => $val) {
				$fiName = $_FILES['image']['name'];
				$fileName = basename($_FILES['image']['name'][$key]);
				$targetFilePath = $targetDir . $fileName;

				$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
				if (in_array($fileType, $allowTypes)) {
					if (move_uploaded_file($_FILES["image"]["tmp_name"][$key], $targetFilePath)) {
						$insertValuesSQL = implode(',', $fiName);
					} else {
						$errorUpload .= $_FILES['image']['name'][$key] . ', ';
					}
				} else {
					$errorUploadType .= $_FILES['image']['name'][$key] . ', ';
				}
			}
			if (!empty($insertValuesSQL)) {
				if (empty($_SESSION['user_lost_found'])) {
					$id = $_SESSION['admin_lost_found']['id'];
				} else {
					$id = $_SESSION['user_lost_found']['id'];
				}

				try {

					$stmt = $this->db->prepare("INSERT INTO lost_persons(user_id, name, place_lost, residence, email, phone, photo, comments, date_lost, created_at) 
					VALUES (:user_id, :name, :place, :rplace, :email, :phone, :photo, :comments, :date_lost, :time)");
					$stmt->execute(array(':user_id' => $id, ':name' => $name, ':place' => $place, ':rplace' => $rplace, ':email' => $email, ':phone' => $phone, ':photo' => $insertValuesSQL, ':comments'=>$comment, ':date_lost'=>$date, ':time' => date('Y-m-d H:i:s')));
					return TRUE;
				} catch (\PDOException $e) {
					return $e->getMessage();
				}
				if ($stmt) {
					$errorUpload = !empty($errorUpload) ? 'Upload Error: ' . $errorUpload : '';
					$errorUploadType = !empty($errorUploadType) ? 'File Type Error: ' . $errorUploadType : '';
					$errorMsg = !empty($errorUpload) ? '<br/>' . $errorUpload . '<br/>' . $errorUploadType : '<br/>' . $errorUploadType;
					$statusMsg = "Files are uploaded successfully." . $errorMsg;
				} else {
					$statusMsg = "Sorry, there was an error uploading your file.";
				}
			}
		}
	}

	public function createFound($name, $place, $email, $phone, $comment, $date)
	{
		$targetDir = "../persons/";
		$allowTypes = array('jpg', 'png', 'jpeg', 'gif');

		if (!empty(array_filter($_FILES['images']))) {
			foreach ($_FILES['images']['name'] as $key => $val) {
				$fiName = $_FILES['images']['name'];
				$fileName = basename($_FILES['images']['name'][$key]);
				$targetFilePath = $targetDir . $fileName;
				$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
				if (in_array($fileType, $allowTypes)) {
					if (move_uploaded_file($_FILES["images"]["tmp_name"][$key], $targetFilePath)) {
						$insertValuesSQL = implode(',', $fiName);
					} else {
						$errorUpload .= $_FILES['images']['name'][$key] . ', ';
					}
				} else {
					$errorUploadType .= $_FILES['images']['name'][$key] . ', ';
				}
			}
			if (!empty($insertValuesSQL)) {
				if (empty($_SESSION['user_lost_found'])) {
					$id = $_SESSION['admin_lost_found']['id'];
				} else {
					$id = $_SESSION['user_lost_found']['id'];
				}

				try {

					$stmt = $this->db->prepare("INSERT INTO found_persons(user_id, name, place_found, contact_email, contact_phone, photo, comments, date_found, created_at) 
					VALUES (:user_id, :name, :place, :email, :phone, :photo, :comments, :date_found, :time)");
					$stmt->execute([':user_id' => $id, ':name' => $name, ':place' => $place, ':email' => $email, ':phone' => $phone, ':photo' => $insertValuesSQL, ':comments'=>$comment, ':date_found'=>$date, ':time' => date('Y-m-d H:i:s')]);
					die($place);
					return TRUE;
				} catch (\PDOException $e) {
					return $e->getMessage();
				}
				if ($stmt) {
					$errorUpload = !empty($errorUpload) ? 'Upload Error: ' . $errorUpload : '';
					$errorUploadType = !empty($errorUploadType) ? 'File Type Error: ' . $errorUploadType : '';
					$errorMsg = !empty($errorUpload) ? '<br/>' . $errorUpload . '<br/>' . $errorUploadType : '<br/>' . $errorUploadType;
					$statusMsg = "Files are uploaded successfully." . $errorMsg;
				} else {
					$statusMsg = "Sorry, there was an error uploading your file.";
				}
			}
		}
	}

	public function getLostPersons()
	{
		try {
			$stmt = $this->db->prepare("SELECT * FROM lost_persons WHERE status=1 ORDER BY id DESC");
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch (\PDOException $e) {
			return $e->getMessage();
		}
	}

	public function getFoundPersons()
	{
		try {
			$stmt = $this->db->prepare("SELECT * FROM found_persons WHERE status=1 ORDER BY id DESC");
			$stmt->execute();
			return $stmt->fetchALL(PDO::FETCH_OBJ);
		} catch (\PDOException $e) {
			return $e->getMessage();
		}
	}

	public function getLost($lim=null)
	{
		if (!is_null($lim)) {
			$sql = "SELECT * FROM lost_persons WHERE status=1 ORDER BY id DESC LIMIT $lim";
		}else {
			$sql = "SELECT * FROM lost_persons status=1 ORDER BY id DESC";
		}
		try {
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
			$persons = $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch (\PDOException $e) {
			return $e->getMessage();
		}
		$people = [];
		foreach ($persons as $key => $value) {
			$image = explode(',', $value->photo);
			$user = $this->getUserById($value->user_id);
			$person = [
				'id' => $value->id,
				'name' => $value->name,
				'place' => $value->place_lost,
				'residence' => $value->residence,
				'email' =>$value->email,
				'phone' => $value->phone,
				'comment'=>$value->comments,
				'date_lost'=>$value->date_lost,
				'user' => $user['name'],
				'image' => $image[0],
				'status' => $value->status
			];
			array_push($people,$person);
		}
		return $people;
	}
	public function getFound($lim=null)
	{
		if (!is_null($lim)) {
			$sql = "SELECT * FROM found_persons WHERE status=1 ORDER BY id DESC LIMIT $lim";
		}else {
			$sql = "SELECT * FROM found_persons status=1 ORDER BY id DESC";
		}
		try {
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
			$persons = $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch (\PDOException $e) {
			return $e->getMessage();
		}
		$people = [];
		foreach ($persons as $key => $value) {
			$image = explode(',', $value->photo);
			$user = $this->getUserById($value->user_id);
			$person = [
				'id' => $value->id,
				'name' => $value->name,
				'place' => $value->place_found,
				'email' =>$value->contact_email,
				'phone' => $value->contact_phone,
				'comment'=>$value->comments,
				'date_lost'=>$value->date_found,
				'user' => $user['name'],
				'image' => $image[0],
				'status' => $value->status
			];
			array_push($people,$person);
		}
		return $people;
	}

	public function approveLost($id,$tab)
	{
		if ($tab === 'lost') {
			$sql = "UPDATE lost_persons SET status=1 WHERE id=:id";
		}elseif ($tab == 'found') {
			$sql = "UPDATE found_persons SET status=1 WHERE id=:id";
		}
		try {
			$stmt = $this->db->prepare($sql);
			$stmt->execute([':id'=>$id]);
			$this->sendMessage($id,$tab);
			return TRUE;
		} catch (\PDOException $e) {
			return $e->getMessage();
		}
	}

	public function search($name,$category)
	{
		if ($category == 'Lost') {
			$sql = "SELECT * FROM lost_persons WHERE name LIKE %$name%";
		}elseif($category == 'Found') {
			$sql = "SELECT * FROM lost_persons WHERE name LIKE %$name%";
		}
		try {
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} catch (\PDOException $e) {
			return $e->getMessage();
		}
	}

	public function sendMessage($id, $tab)
	{
		if ($tab == 'lost') {
			$users = $this->getFound();
			$message = "A new lost person has been posted to our website. Please visit and check";
		}elseif ($tab == 'found') {
			$users = $this->getLost();
			$message = "A new found person has been posted to our website. Please visit and check";
		}

		foreach ($users as $value) {
			$this->send($value->phone, $message);
		}
	}

	public function send($phone, $message)
	{
		$username   = "swiss";
		$apikey     = "44456f41910a7a109efabeefa993b4a79bd9315b3d9a4816f30bf18ef1387fa6";
		$recipients = $phone;
		$message    = $message;
		$gateway    = new AfricasTalkingGateway($username, $apikey);
		try {
			$results = $gateway->sendMessage($phone, $message);
			foreach ($results as $result) {
			}
		} catch (AfricasTalkingGatewayException $e) {
			echo "Encountered an error while sending: " . $e->getMessage();
		}
	}
	
}
