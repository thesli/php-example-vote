<?php
$db = new PDO("sqlite:database.db") or die("it fails anyway.");
$P = $_POST;
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$clearVoteSql = "delete from votes where (user_id = {$P['user_id']}) and (event_id = {$P['event_id']} )";
$db->exec($clearVoteSql);

echo "<p>";
print($clearVoteSql);
echo "</p>";
foreach(array_keys($P['option_id']) as $o){
    $addVoteSql = "insert into votes(user_id, event_id, option_id) values ({$P['user_id']},{$P['event_id']},{$o})";
    echo "<p>";
    print($addVoteSql);
    echo "</p>";
    $db->exec($addVoteSql);
}

?>

<pre>
THE INPUT:

<?php

print_r($_POST);

?>
</pre>

<p>
    SQL to Execute:


</p>


<a href="index.php?eventID=<?= $_POST['event_id'] ?>">GO BACK TO UR VOTED PAGE</a>

