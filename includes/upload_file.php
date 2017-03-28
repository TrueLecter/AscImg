<?php
include "database.php";
include "config.php";
$data = array();
$time = time();
$allow = array("jpg", "jpeg", "gif", "png");
if (isset($_GET['files'])) {
	$error = false;
	$files = array();
	$uploaddir = './../' . $uploads;
	foreach ($_FILES as $file) {
		$fName = $time . "/" . basename($file['name']);
		$fileName = $uploaddir . $fName;
		$info = explode('.', strtolower(basename($file['name'])));
		if (in_array(end($info), $allow)) {
			if (mkdir($uploaddir . $time . "/", 0777 ,true) && move_uploaded_file($file['tmp_name'], $fileName)) {
				$q = "INSERT INTO " . $table . " (`key`, `path`, `timestamp`, `private`, `procced`) VALUES (?, ?, ?, ' ', ' ')";
				$STMT = $link->prepare($q);
				if (!$STMT->execute(array(md5($time), $uploads.$fName, $time))) {
					$data = array("error" => 1, "url" => "", "errorDesc" => "Internal server error. ".$q);
				} else {
					$data = array("error" => 0, "name" => $uploads . $fName, "id" => $link->lastInsertedId());
				}
			}
		} else {
			$data = array("error" => 2, "url" => "", "info" => $info, "errorDesc" => "Unsupported file format.");
		}
	}
} else {
	$data = array("error" => 3, "url" => "", "errorDesc" => "No file selected.");
}
echo json_encode($data);
?> 
