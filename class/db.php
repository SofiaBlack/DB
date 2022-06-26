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
        echo "Errore: " . $e->getMessage();
        die();
    }
}

public function query($string, $DEBUG = 0){
   $this->QUERY = $this->CONN->prepare($string);
   $this->QUERY->execute();

   if ($DEBUG == 1) {
       print $string;
    }
}

public function queryarray() {
    
}

/**
 * $table -> table's name
 * $values[array] as field -> new value
 * $where[array|string]
 * $DEBUG[0|1] if 1 print the query - default = 0
 */
public function queryupdate($table, $values, $where, $DEBUG = 0){
    $sets = array();
    foreach($values as $data => $value) {
        $sets[] = $data." = ".$value;
    }
    $query = "UPDATE ".$table;
    $query .= " SET ".implode(', ', $sets);
    if(is_array($where)) {
        $query .= " WHERE ".implode(' AND ', $where);
    } else {
        $query .= " WHERE ".$where;
    }
    $this->query($query, $DEBUG);
}

public function next_assoc(){
    return $this->QUERY->fetch(PDO::FETCH_ASSOC);
}

public function num_rec(){
    print $this->QUERY->rowCount();
}


}
?>



