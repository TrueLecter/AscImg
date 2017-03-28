<!DOCTYPE html>
<html>
<head>
	<title>Wipeing art database.</title>
</head>
<body>
<?
	include "header.php";
	include "config.php";
	function deleteDir($dirPath) {
	    if (! is_dir($dirPath)) {
	        throw new InvalidArgumentException("$dirPath must be a directory");
	    }
	    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
	        $dirPath .= '/';
	    }
	    $files = glob($dirPath . '*', GLOB_MARK);
	    foreach ($files as $file) {
	        if (is_dir($file)) {
	            self::deleteDir($file);
	        } else {
	            unlink($file);
	        }
	    }
	    rmdir($dirPath);
	}

	if (isset($_GET["pass"]) && $_GET["pass"] === md5("megaSuperSecterPass228")){
		deleteDir("./../uploads/");
		mysqli_query($link, "TRUNCATE TABLE ".$table);
	} else {
		echo "<center><h1 style=\"color: red\">Invalid password</h1></center>";
	}
	include "footer.php";
?>
</body>
</html>
