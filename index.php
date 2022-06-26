<?php
require(__DIR__.'\config.php');

$db = new DB();

$db->query("SELECT * FROM login", 0);

$data['nome'] = 'sofia';
$data['cognome'] = 'montagna';

$where[] = 'id = 1 AND lingua = ita';


$prova = implode(' AND ', $where);

//print_r($where['where']);
//print($prova);

$db -> queryupdate('prova', $data, $where);

while ($res = $db->next_assoc()){
    print '<pre>';
    print_r($res);
    print '</pre>';
}