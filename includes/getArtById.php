<?	
	include 'config.php';
	include 'database.php';
	if (isset($_GET["id"])) {
	$q = "select * from " . $table . " where id='" . mysqli_escape_string($link, $_GET["id"]) . "'";
	$res = mysqli_query($link, $q);
	if ($currPath){
		$t = "";
	} else {
		$t = "./../";
	}
	if (!$res) {
		include "invalideId.php";
	}
	$row = mysqli_fetch_array($res);
	if (isset($_GET["orig"])){
		echo "<html><head><title>".$config["origTitle"]."</title></head><body><img align=\"middle\" src=\"".$t. $row['path']."\"></img></body></html>";
	} else {
		$filename = $t . $row['path'].".php";
		include $filename;
	}
	} else {
		include "invalideId.php";
	}

?>