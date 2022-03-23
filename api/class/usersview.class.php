<?php 

/**
 * 
 */
class UsersView extends Users
{
	
	private $table = "users";
	public function showAllData(){
		$query = $this->getAllData();
		return $query;
	}
	public function showActiveData($column, $data){
		$query = $this->selectBy($this->table, $column, $data);
		if($query){
			if($this->rowCount > 0 ){
				return $query;
			}else{
				return 0;
			}
		}
	}
	public function showDatabyID($values){
		$query = $this->selectByID($this->table, $values);
		return $query; 

	}	
	
}