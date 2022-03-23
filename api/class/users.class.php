<?php

class Users extends dbconnect {
	public $tblname = "users";
	public $values = "";
	
	protected function getAllData(){
		$sql = "SELECT * FROM {$this->tblname}";				
		$query = $this->select( $sql, null );
		if($query){
			if($this->rowCount > 0 ){
				return $query;
			}else{
				return '{}';
			}
		}
	}

	protected function add($values){
		return $this->insert($this->tblname, $values);
	}

	protected function deleteData($values){
		$this->delete($this->tblname,$values);
	}

	protected function updateData($setValues , $values){
		// UPDATE category SET fieldname = :data, fieldname2 = :data  WHERE id = :data 
		// $setValues  = array("category_name" => 'aw', "is_active" => 1);
		$set_str = null;
		foreach ($setValues as $key => $value) {
			# code...
			$set_str .= $key ."=:". $key;
			if($value != (count($setValues) - 1 )){
				$set_str .= ", ";
			}
		}

		// $values = array("category_ID" => 16);
		// $table = "category";
		$vals = array($values);
		$fieldnames = array_keys($vals[0]);
		
		$sql = "UPDATE ". $this->tblname;
		$fields = implode("= ",$fieldnames).'=';
		$bound = ":".implode(", :", $fieldnames);
		$sql .= " SET ". $set_str ." WHERE " . $fields.$bound;
        $val = array_merge( $setValues, $values);	
		$query = $this->update( $sql, $val , "Error executing updating query.");
        return $query;
	}
	protected function updateData1($setValues, $values, $data){

		$setfields = implode(' = ?, ', array_values($setValues));
		$setfields .= ' = ?';

		$paramFields = implode(' = ? AND ', array_values($values));
		$paramFields .= ' = ?';

		$sql = "UPDATE ". $this->tblname ." SET ". $setfields ." WHERE ". $paramFields;
		$query = $this->update( $sql, $data , "Error executing updating query.");
		return $query;
	}


	protected function selectByID($table , $values){
    	
    	$vals = array($values);
        $fieldnames = array_keys($vals[0]);

        $sql = "SELECT * FROM ". $table;
        $fields = implode($fieldnames)."=";
        $bound = ":".implode(", :", $fieldnames);
        $sql .= " WHERE " . $fields.$bound;

		foreach ($vals as $val) {
		    $query = $this->select( $sql, $val, "Error in getting all products by category.");
		}		
		if($query){
			if($this->rowCount > 0 ){
				return $query;
			}
			return '{}';
			
		}	
	} 

	public function selectBy($table, $values, $data){
	    $sql = "SELECT * FROM ". $table;
	    $Operator = "AND";
	    $fields = implode(' ? '.$Operator.' ', $values)." ?";
	    $sql .= " WHERE " . $fields ;
	    // echo $sql;
	    $vals = array($data);
	    foreach ($vals as $val) {
		    $query = $this->select( $sql, $val);
		}		
	    if($query){
			if($this->rowCount > 0 ) return $query;
			return '{}';
		}		    
	}



}
