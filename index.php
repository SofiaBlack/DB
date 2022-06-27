<?php
require(__DIR__.'\config.php');

$values = array('username' => "uuuu");

$db = new DB();

$db->queryinsert('login', $values, 1);

print '<br>';
$db->last_insert_id();

$db->query("SELECT * FROM login", 0);
while ($res = $db->next_assoc()){
    print '<pre>';
    print_r($res);
    print '</pre>';
}
