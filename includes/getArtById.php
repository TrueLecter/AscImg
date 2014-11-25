<?	
	include 'config.php';
	include 'database.php';
	if (isset($_GET["id"])) {
	$q = "select * from " . $table . " where id='" . mysqli_escape_string($link, $_GET["id"]) . "'";
	$res = mysqli_query($link, $q);
	if (!$res) {
		include "invalideId.php";
	}
	$row = mysqli_fetch_array($res);
	$filename = "./../" . $row['path'].".php";
	include $filename;
	} else {
		include "invalideId.php";
	}
?>