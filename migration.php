<?php

$db = new PDO("sqlite:database.db") or die("fails reading the file");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try {
    $dropTablelist = ["users", "events", "votes","options"];

    foreach ($dropTablelist as $t) {
        $db->exec("drop table if exists $t");
    }
    $db->exec("create table users(id int NOT NULL,name varchar(30))");
    $db->exec("create table events(id int NOT NULL,name varchar(30))");
    $db->exec("create table options(option_id int NOT NULL,event_id int NOT NULL,name varchar(30))");
    $db->exec("create table votes(user_id int NOT NULL,event_id int NOT NULL,option_id int NOT NULL)");


    /*generate some data*/
    for($i=0;$i<10;$i++){
        $user["name"] = "user00{$i}";
        $user["id"] = $i;
        $event["name"] = "event00{$i}";
        $event["id"] = $i;
        $db->exec("insert into users values({$user["id"]},'{$user['name']}')");
        $db->exec("insert into events values({$event["id"]},'{$event["name"]}')");
        for($j=0;$j<5;$j++){
            $option["name"] = "E00{$i} option0{$j}";
            $db->exec("insert into options values({$j},{$i},'{$option["name"]}')");
        }
    }

} catch (PDOException $e) {
    var_dump($e);
}

$db = null;

?>