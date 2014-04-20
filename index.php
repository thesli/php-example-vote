<?php
$db = new PDO("sqlite:database.db") or die("it fails anyway.");
// mysql: $db = new PDO('mysql:host=localhost;dbname=testdb;charset=utf8', 'username', 'password');

$currentEventID = isset($_GET["eventID"]) ? $_GET["eventID"] : 0;
$userList = $db->query("select * from users");

//echo "<pre>";
//foreach($userList as $u){
//    print_r($u);
//    $u['id'];
//    $u['name'];
//}
//echo "</pre>";

$eventList = $db->query("select * from events");
$optionList = $db->query("select * from options where event_id = {$currentEventID}");
$voteList = $db->query("select * from votes where event_id = {$currentEventID}");
$votedUserIDArray = [];

foreach ($voteList as $v) {
    if (!isset($votedUserIDArray["{$v['option_id']}"])) {
        $votedUserIDArray["{$v['option_id']}"] = array();
    }
    array_push($votedUserIDArray["{$v['option_id']}"], $v['user_id']);
}

?>



<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>

<fieldset>
    <form action="createEvent.php" method="post">
        new Event Name: <input type="text" name="eventName"/>
        <input type="submit"/>
    </form>
</fieldset>


<form action="vote.php" method="post">
    <fieldset>
        You are now:
        <select name="user_id" id="">
            <?php foreach ($userList as $u): ?>
                <option value="<?= $u['id'] ?>"><?= $u['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </fieldset>
    <fieldset>
        Event:
        <select name="event_id" id="eventSelector">
            <?php foreach ($eventList as $e): ?>
                <?php if ($currentEventID != $e['id']): ?>
                    <option value="<?= $e['id'] ?>"><?= $e['name'] ?></option>
                <?php else: ?>
                    <option value="<?= $e['id'] ?>" selected><?= $e['name'] ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>




    </fieldset>
    <fieldset>
        Option:
        <table>
            <tr>
                <th>Name:</th>
                <th>Joined IDs:</th>
                <th>Count</th>
            </tr>
            <?php foreach ($optionList as $o): ?>
                <tr>
                    <td><input type="checkbox" name="<?= 'option_id[' . $o['option_id'] . ']' ?>"/> <?= $o['name'] ?>
                    </td>
                    <td>
                        <?php if (isset($votedUserIDArray["{$o['option_id']}"])): ?>
                            <?php foreach ($votedUserIDArray["{$o['option_id']}"] as $v): ?>
                                "<?= $v ?>"
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (isset($votedUserIDArray["{$o['option_id']}"])): ?>
                            <?= count($votedUserIDArray["{$o['option_id']}"]) ?>
                        <?php else: ?>
                            0
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </fieldset>
    <fieldset>
        <input type="submit"/>
    </fieldset>
</form>


</body>

<script>
    var eventSelector = document.querySelector("#eventSelector");
    eventSelector.onchange = function () {
        var eventValue = eventSelector.value;
        location.href = "index.php?eventID=" + eventValue;
    }
</script>

</html>