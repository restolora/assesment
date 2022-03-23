<?php 
/**
 * 
 */
class UsersController extends Users
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

	public function newData($values, $error_msg){
		$this->add($values, $error_msg);
	}

	public function delData($values){
		$this->deleteData($values);
	}

	public function editData($setValues, $values){
		$this->updateData($setValues, $values);

	}	
	
}