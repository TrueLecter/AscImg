<?	
	include 'config.php';
	include 'database.php';
	if (isset($_GET["id"])) {
		$q = "select * from " . $table . " where id = ?";
		$STMT = $link->prepare($q);
		$res = $STMT->execute(array($_GET["id"]));
		if (!$res) {
			include "invalideId.php";
		}
		if ($currPath){
			$t = "";
		} else {
			$t = "./../";
		}
		$row = $STMT->fetch();
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