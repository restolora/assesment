<?php 
	
	/**
	 * 
	 */
	class dbconnect {
		private $SERVER = "localhost";
		private $DBUSER = "root";
		private $DBPWRD = "";
		private $DBNAME = "api";
		private $DBTYPE = "mysql";
		private $myDNS = null;
		public $conn = null;
		public $rowCount = null;

		function __construct()
		{
			// $this->setDNS();
			$this->connect();
		}
		protected function connect(){
			try {
				$dsn = $this->DBTYPE.":host=".$this->SERVER.";dbname=".$this->DBNAME;
				$this->conn = new PDO($dsn,$this->DBUSER,$this->DBPWRD);
				$this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $this->conn;
			} catch (PDOException $e) {
				print($e->getMessage());
			}
		}
		// protected function setDNS(){
		// 	$this->myDNS = $this->DBTYPE.":host=".$this->SERVER.";dbname=".$this->DBNAME;
		// }
		public function insert($table, $values){
			try {
				$vals = array($values);
				$fieldnames = array_keys($vals[0]);

				$sql = "INSERT INTO ". $table;
				$fields = "(".implode(" ,", $fieldnames).")";
				$bound = "(:".implode(", :", $fieldnames).")";
				$sql .= $fields . " VALUES " . $bound;
				$this->query = $this->conn->prepare($sql);
				foreach ($vals as $val) {
					$this->execQuery( $val );
				}

			} catch (Exception $e) {
				print("Error: ". $e->getMessage());
			}
		}
		public function select( $prepared_sql, $values){
			$this->query = $this->conn->prepare( $prepared_sql );
			$this->execQuery( $values);
			
			$this->rowCount = $this->query->rowCount();
			return $this->query->fetchAll();
		}
		
		public function execQuery( $values){
			$values ? $this->query->execute( $values ) : $this->query->execute();
		}

		public function delete($table, $values){
			try {
				$vals = array($values);
				$fieldnames = array_keys($vals[0]);

				$sql = "DELETE FROM ". $table;
		        $fields = implode($fieldnames)."=";
		        $bound = ":".implode(", :", $fieldnames);
		        $sql .= " WHERE " . $fields.$bound;
		        
				$this->query = $this->conn->prepare($sql);
				foreach ($vals as $val) {
					$this->query->execute( $val ) or die("Error executing query");
				}

			} catch (Exception $e) {
				print("Error: ". $e->getMessage());
			}
		}

		public function update( $prepared_sql, $values, $error_msg ){
			try {
				$this->query = $this->conn->prepare( $prepared_sql );
				$this->execQuery( $values , $error_msg );
				return $this->query;	
			} catch (PDOException $e) {
				echo "Error: ". $e->getMessage();
			}
			
		}

		public function counter( $table, $values ){
		
			try {
				$vals = array($values);
		        $fieldnames = array_keys($vals[0]);

		        $sql = "SELECT * FROM ". $table;
		        $fields = implode($fieldnames)."=";
		        $bound = ":".implode(", :", $fieldnames);
		        $sql .= " WHERE " . $fields.$bound;        
				foreach ($vals as $val) {
				    $query = $this->select( $sql, $val, "Error in counting data.");
				}		
				if($query){
					return $this->rowCount;
				}		
			} catch (Exception $e) {
				print("Error: ". $e->getMessage());
			}
	    	
		}
		
		public function getIfExist( $table, $values, $data ){
		    try {
			    $sql = "SELECT * FROM " . $table;
			    $operator = "AND";
			    $fields = implode(' ? '.$operator.' ', $values)." ?";
			    $sql .= " WHERE " . $fields;
			    // return $sql;
			    $stmt = $this->connect()->prepare( $sql );
			    $stmt->execute( $data );
			    $this->rowcount = $stmt->rowCount();
			    return $this->rowcount;
		    } catch (Exception $e) {
		    	print("Error: ". $e->getMessage());
		    }
		}

	}// class end


 ?>