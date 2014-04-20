<?php

print_r($_POST);

$db = new PDO("sqlite:database.db") or die("it fails anyway.");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "insert into events(id, name) values(select max(id) from events,'{$_POST['eventName']}')";

$db->exec($sql);

?>