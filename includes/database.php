<?
	$host = '';
	$user = '';
	$password = '';
	$db = '';
    $table = 'image2ascii';
	$link = mysqli_connect($host, $user, $password, $db);
    $q = 'create table if not exists '.$table.' (`key` text, `path` text, `timestamp` int, `id` int NOT NULL AUTO_INCREMENT, PRIMARY KEY(id))';
    mysqli_query($link, $q);
?>		