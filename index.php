<?php
require(__DIR__.'\config.php');

$db = new DB();

$db->query("SELECT * FROM login", 0);

$query = array();

$query['select'][] = "P.*";

$query['from'][] = "prodotti P";

$query['where'][] = "P.id = 1";
$query['where'][] = "P.lingua = ita";

$query['orderby'][] = "DESC";
$query['limit'][] = "10,1";

$query['select'][] = "T.*";
$query['join']['table T'][] = "P.id = T.id";

$query['select'][] = "S.*";
$query['join']['second S'][] = "T.id = S.id";



//print_r($where['where']);
//print($prova);

$db -> queryarray($query);

while ($res = $db->next_assoc()){
    print '<pre>';
    print_r($res);
    print '</pre>';
}