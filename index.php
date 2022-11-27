<?php
require(__DIR__.'\config.php');

$values = array('username' => "prova 22");

$db = new DB();

$db->queryinsert('login', $values, 1);

print '<br>';
$db->last_insert_id();

$db->query("SELECT * FROM login", 1);
while ($res = $db->next_assoc()){
    print '<pre>';
    print_r($res);
    print '</pre>';
}
