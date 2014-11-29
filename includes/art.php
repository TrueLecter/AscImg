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
	$q = "select * from " . $table . " where id='" . mysqli_escape_string($link, $_GET["id"]) . "' AND procced=' '";
	$res = mysqli_query($link, $q);
	if (!$res) {
		$errorWithID = json_encode(array("errorDesc" => "Invalid id!", "error" => 1));
		die($errorWithID);
	}
	if (isset($_GET["private"])){
		$q = "UPDATE ".$table." SET private = 'yes' WHERE id ='". mysqli_escape_string($link, $_GET["id"])."'";
		mysqli_query($link, $q);
	}
	$row = mysqli_fetch_array($res);
	if ($row["procced"] === "yes"){
		echo json_encode(array("art" => "index.php?id=" . $_GET["id"], "error" => 0));
	}
	$filename = "./../" . $row['path'];
	$fileError = json_encode(array("errorDesc" => "Unable to open file!", "error" => 2));
	$fileError = "File";
	$myfile = fopen($filename . ".php", "w") or die($fileError);
	$width = 150;
	$height = 150;
	$background = "black";
	if (isset($_GET["additionalOptions"])){
		if (isset($_GET["customSize"])){
			if(isset($_GET["width"])){
				$width = (intval($_GET["width"]) < 150) ? $_GET["width"] : 150;
			} 
			if(isset($_GET["height"])){
				$width = (intval($_GET["height"]) < 150) ? $_GET["height"] : 150;
			} 
		}
		if (isset($_GET["customBackgroud"])){
			$background = "#" . $_GET["customBackgroud"];
		}
	}
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
	imagealphablending($image_p, false);
 	imagesavealpha($image_p,true);
 	$transparent = imagecolorallocatealpha($image_p, 255, 255, 255, 127);
 	imagefilledrectangle($image_p, 0, 0, $width, $height, $transparent);
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	fwrite($myfile, "<html><head><title>ASCII art</title></head><body style=\"background-color:".$background.";\"><pre style=\"font: 10px/6px monospace; text-align: center;\">");
	for ($i = 0; $i < $height; $i++) {
		$txt = "";
		for ($j = 0; $j < $width; $j++) {
			$rgb = imagecolorat($image_p, $j, $i);
			$r = ($rgb >> 16) & 0xFF;
			$g = ($rgb >> 8) & 0xFF;
			$b = $rgb & 0xFF;
			$alpha = ($rgb >> 24) & 0x7F;
			$alpha = (127 - $alpha) / 127;
			if ($alpha > 115){
				$txt .= " ";	
			}
			$txt.= "<span style=\"color: " . getColorCode($r, $g, $b) . "; opacity: ".$alpha.";\">" . randomChar() . "</span>";
		}
		fwrite($myfile, $txt . "\n");
	}
	$q = "UPDATE ".$table." SET procced = 'yes' WHERE id ='". mysqli_escape_string($link, $_GET["id"])."'";
	mysqli_query($link, $q);
	fwrite($myfile, "</pre></body></head>");
	fclose($myfile);
	echo json_encode(array("art" => "index.php?id=" . $_GET["id"], "error" => 0));
} else {
	echo json_encode(array("error" => 5, "errorDesc" => "Empty request!"));
}
?>