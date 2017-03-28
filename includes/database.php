<?
	$host = 'localhost';
	$user = 'root';
	$password = '111111';
	$db = 'projects';

    $table = 'image2ascii';
    $link = new PDO("mysql:host=".$host.";dbname=".$db, $user, $password);
    $q = 'create table if not exists '.$table.' (`key` text, `path` text, `timestamp` int, `private` text, `procced` text, `id` int NOT NULL AUTO_INCREMENT, PRIMARY KEY(id))';
    $STMT = $link->prepare($q);
    $STMT->execute();
?>		
