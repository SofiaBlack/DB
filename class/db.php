<?php
class DB {
    private $DB_HOST;
    private $DB_NAME;
    private $DB_USER;
    private $DB_PASSWORD;

    private $CONN;
    private $QUERY;

public function __construct() {
    $this->DB_HOST =  DB_HOST;
    $this->DB_NAME = DB_NAME;
    $this->DB_USER = DB_USER;
    $this->DB_PASSWORD = DB_PASSWORD;
    try {
        $this->CONN = new PDO("mysql:host=" . $this->DB_HOST . ";dbname=" . $this->DB_NAME, $this->DB_USER, $this->DB_PASSWORD);
        $this->CONN->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        die();
    }
}

public function query($query, $data = array(), $DEBUG = 0){
   $this->QUERY = $this->CONN->prepare($query);
   if (count($data) > 0) {
    $this->QUERY->execute($data);
   } else {
    $this->QUERY->execute();
   }
   if ($DEBUG == 1) {
       print $query;
    }
}

public function queryarray($queryarray, $DEBUG = 0) {
    $query = "SELECT ".implode(', ', $queryarray['select']);
    $query .= " FROM ".implode(', ', $queryarray['from']);
    if($queryarray['join']){
        foreach($queryarray['join'] as $table => $condictions) {
            $query .= " LEFT JOIN ".$table." ON ".implode(' AND ', $condictions);
        }
    }
    if($queryarray['where']){ 
        $query .= " WHERE ".implode(' AND ', $queryarray['where']);
    }
    if($queryarray['orderby']){ 
        $query .= " ORDERBY ".implode(' AND ', $queryarray['orderby']);
    }
    if($queryarray['limit']){ 
        $query .= " LIMIT ".implode(', ', $queryarray['limit']);
    }
    $this->query($query, $DEBUG);
}

/**
 * The function uses the PDO's bind method
 * $table -> table's name
 * $values[array] as field -> new value
 * $where[array|string]
 * $DEBUG[0|1] if 1 print the query and the array's datas - default = 0
 */
public function queryupdate($table, $values, $where, $DEBUG = 0){
    $sets = array();
    foreach($values as $data => $value) {
        $sets[] = $data." = :".$data;
    }
    $query = "UPDATE ".$table;
    $query .= " SET ".implode(', ', $sets);
    if(is_array($where)) {
        $query .= " WHERE ".implode(' AND ', $where);
    } else {
        $query .= " WHERE ".$where;
    }
    if ($DEBUG == 1) {
        print_r($values);
    }
    $this->query($query, $values, $DEBUG);
}

/**
 * The function uses the PDO's bind method
 * $table -> table's name
 * $values[array] as field -> new value
 * $DEBUG[0|1] if 1 print the query and the array's datas - default = 0
 */
function queryinsert($table, $values, $DEBUG = 0){
    $sets = array();
    $fields = array();
    foreach($values as $data => $value) {
        $fields[] = $data;
        $sets[] = ":".$data;
    }
    $query = "INSERT INTO ".$table;
    $query .= "(".implode(', ', $fields).")";
    $query .= "VALUES (".implode(', ', $sets).")";
    if ($DEBUG == 1) {
        print_r($values);
    }
    $this->query($query, $values, $DEBUG);
}

public function next_assoc(){
    return $this->QUERY->fetch(PDO::FETCH_ASSOC);
}

public function num_rec(){
    print $this->QUERY->rowCount();
}

public function last_insert_id() {
    print $this->CONN->lastInsertId();
}


}
?>



