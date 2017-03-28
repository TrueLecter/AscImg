<?
	include "database.php";
	include "config.php";

	header("Content-type: application/json");
	$limit = 0;
	$perPage = 12; //3 rows, 4 in row
	if (isset($_GET["page"])){
		$page = intval($_GET["page"]);
	}

	$STMT = $link->prepare("SELECT * FROM `" . $table . "` WHERE private=' ' ORDER BY id DESC LIMIT " . ($limit * $perPage) . "," . (($limit + 1) * $perPage));
	$STMT->execute();
	$CSTMT = $link->prepare("SELECT COUNT(*) as num FROM `" . $table . "` WHERE private=' ' ORDER BY id DESC");
	$CSTMT->execute();

	$count = $CSTMT->fetch();
	$count = $count['num'];
	//table
	$table = array();
	$i = 0;
	while ($i < $perPage && $row = $STMT->fetch()) {
			$table[] = array('id' => strip_tags($row["id"]), 'image' => $row["path"].".c.png", 'date' => strip_tags($row["timestamp"]));
		$i = $i + 1;
	}
	if ($i == 0) {
		$table = array('empty' => true);
	}
	//pagination
	$totalpage = ceil($count / $perPage);
	$currentpage = $limit + 1;
	$firstpage = 1;
	$lastpage = $totalpage;
	$loopcounter = ((($currentpage + 2) <= $lastpage) ? ($currentpage + 2) : $lastpage);
	$startCounter = ((($currentpage - 2) >= 3) ? ($currentpage - 2) : 1);

	if ($count > $perPage) {
		$pagination = array('total' => $totalpage - 1, 'start' => $startCounter);
		if ($totalpage > 1) {
			for ($i = $startCounter; $i <= $loopcounter; $i++) {
				if ($i == ($limit + 1)) {
					$pagination[] = array('caption' => $i, 'active' => "true");
				} else {
					$pagination[] = array('page' => ($i - 1), 'caption' => $i);
				}
			}
		}
	} else {
		$pagination = array('empty' => true);
	}

	$response = array('table' => $table, 'pagination' => $pagination);

	echo json_encode($response, 128);
?>