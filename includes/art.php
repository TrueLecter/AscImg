<?php
include "database.php";
include "config.php";

function getColorCode($r, $g, $b) {
	$r = dechex($r);
	$g = dechex($g);
	$b = dechex($b);
	if (strlen($r) < 2) {
		$r = 0 . $r;
	}
	if (strlen($g) < 2) {
		$g = 0 . $g;
	}
	if (strlen($b) < 2) {
		$b = 0 . $b;
	}
	return "#" . $r . $g . $b;
}

function randomChar() {
	return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1);
}

if (isset($_GET["id"])) {
	$q = "select * from " . $table . " where id='" . mysqli_escape_string($link, $_GET["id"]) . "'";
	$res = mysqli_query($link, $q);
	if (!$res) {
		$errorWithID = json_encode(array("errorDesc" => "Invalid id!", "error" => 1));
		$errorWithID = "ID";
		die($errorWithID);
	}
	$row = mysqli_fetch_array($res);
	$filename = "./../" . $row['path'];
	$fileError = json_encode(array("errorDesc" => "Unable to open file!", "error" => 2));
	$fileError = "File";
	$myfile = fopen($filename . ".php", "w") or die($fileError);
	$width = 150;
	$height = 150;
	list($width_orig, $height_orig, $type) = getimagesize($filename);
	if ($width_orig > $width || $height_orig > $height) {
		$scale = min($width / $width_orig, $height / $height_orig);
		$width = ceil($scale * $width_orig);
		$height = ceil($scale * $height_orig);
	} else {
		$height = $height_orig;
		$width = $width_orig;
	}
	if ($type == 1) {
		$image = imagecreatefromgif($filename);
	} else if ($type == 2) {
		$image = imagecreatefromjpeg($filename);
	} else if ($type == 3) {
		$image = imagecreatefrompng($filename);
	} else {
		$image = imagecreatetruecolor($width, $height);
	}
	$image_p = imagecreatetruecolor($width, $height);
	fwrite($myfile, "<html><head><title>ASCII art</title></head><body style=\"background-color: black;\"><pre style=\"font: 10px/6px monospace; text-align: center;\">");
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	for ($i = 0; $i < $height; $i++) {
		$txt = "";
		for ($j = 0; $j < $width; $j++) {
			$rgb = imagecolorat($image_p, $j, $i);
			$r = ($rgb >> 16) & 0xFF;
			$g = ($rgb >> 8) & 0xFF;
			$b = $rgb & 0xFF;
			$txt.= "<span style=\"color: " . getColorCode($r, $g, $b) . "\">" . randomChar() . "</span>";
		}
		fwrite($myfile, $txt . "\n");
	}
	fwrite($myfile, "</pre></body></head>");
	fclose($myfile);
	echo json_encode(array("art" => "includes/getArtById.php?id=" . $_GET["id"], "error" => 0));
} else {
	echo json_encode(array("error" => 5, "errorDesc" => "Empty request!"));
}
?>