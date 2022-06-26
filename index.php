<?php
require(__DIR__.'\config.php');

$db = new DB();

$db->query("SELECT * FROM login", 0);

$db->num_rec();

while ($res = $db->next_assoc()){
    print '<pre>';
    print_r($res);
    print '</pre>';
}
