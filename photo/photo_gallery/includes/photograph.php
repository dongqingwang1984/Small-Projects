<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once(LIB_PATH.DS.'database.php');
    class Photograph extends DatabaseObject{
        protected static $table_name="photograph";
        protected static $db_fields = array('id', 'filename','type', 'size','caption');
        public $id;
	public $filename;
	public $type;
	public $size;
	public $caption;
        
        
     public static function find_all() {
	return self::find_by_sql("SELECT * FROM ".self::$table_name);
     }
  
    public static function find_by_id($id=0) {
        $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id={$id} LIMIT 1");
	return !empty($result_array) ? array_shift($result_array) : false;
    }
  
    public static function find_by_sql($sql="") {
        global $database;
        $result_set = $database->query($sql);
        $object_array = array();
        while ($row = $database->fetch_array($result_set)) {
            $object_array[] = self::instantiate($row);
    }
        return $object_array;
  }

    private static function instantiate($record) {
		// Could check that $record exists and is an array
        $object = new self;
		// Simple, long-form approach:
		// $object->id 				= $record['id'];
		// $object->username 	= $record['username'];
		// $object->password 	= $record['password'];
		// $object->first_name = $record['first_name'];
		// $object->last_name 	= $record['last_name'];
		
		// More dynamic, short-form approach:
	foreach($record as $attribute=>$value){
            if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
            }
	}
		return $object;
    }
	
    private function has_attribute($attribute) {
	  // get_object_vars returns an associative array with all attributes 
	  // (incl. private ones!) as the keys and their current values as the value
	  $object_vars = $this->attributes();
	  // We don't care about the value, we just want to know if the key exists
	  // Will return true or false
	  return array_key_exists($attribute, $object_vars);
    }
        
    protected function attributes(){
        //return an array of attribute keys and their values
        //previous:return get_object_vars($this);
        $attrinutes = array();
        foreach(self::$db_fields as $field){
            if(property_exists($this, $field)){
                $attributes[$field] = $this->$field;
            }
        }
        
        return $attributes;
        
    }
    
    protected function sanitized_attributes(){
        global $database;
        $cleean_attributes = array();
        //Sanitize the values before submitting
        //Note: does not alter the actual value of each attribute
        foreach ($this->attributes() as $key => $value){
            $clean_attributes[$key] = $database->escape_value($value);
        }
        return $clean_attributes;
    }
    public function save(){
        //A new record won't have an id yet.
        return isset($this->id)?$this->update():$this->create();
    }
        
    public function create(){

        global $database;
        
        $attributes = $this->attributes();
        $attribute_pairs = array();
        
        foreach($attributes as $key => $value){
            $attribute_pairs[] = "{$key}='{$value}'";
        }
        
        $sql = "INSERT INTO ".self::$tablename." (";
        //$sql .= "username, password, first_name, last_name";
        $sql .= join(", ", array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .="')";
        
        echo $sql. "<br>";
        
        if($database->query($sql)){
            $this->id = $database->insert_id();
            return true;
        }else{
            return false;
        }
    }

    public function update(){
        global $database;
        
        $attributes = $this->attributes();
        $attribute_pairs = array();
        
        foreach($attributes as $key => $value){
            $attribute_pairs[] = "{$key}='{$value}'";
        }
        
        $sql = "UPDATE ".self::$tablename." SET ";
        $sql.= join(", ", $attribute_pairs);
        $sql .= " WHERE id=". $database->escape_value($this->id);
        
        echo $sql."<br>";
        
        if($database->query($sql)){
            $this->id = $database->insert_id();
            return true;
        }else{
            return false;
        }
    }

    public function delete(){
        global $database;
        
        $sql = "DELETE FROM ".self::$tablename." ";
        $sql .= "WHERE id=".$database->escape_value($this->id);
        $sql .= " LIMIT 1";
        
        echo $sql."<br>";
        
        $database->query($sql);
        
        return($database->affected_rows()== 1) ? true : false;
    }

}



