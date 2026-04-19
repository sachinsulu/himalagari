<?php
class Enquiry extends DatabaseObject {

	protected static $table_name = "tbl_enquiries";
	protected static $db_fields = array('id', 'type', 'source_url', 'full_name', 'email', 'phone', 'country', 'city', 'trip_name', 'trip_date', 'pax', 'message', 'ip_address', 'added_date', 'updated_date', 'status', 'is_deleted');
	
	public $id;
	public $type;
	public $source_url;
	public $full_name;
	public $email;
	public $phone;
	public $country;
	public $city;
	public $trip_name;
	public $trip_date;
	public $pax;
	public $message;
	public $ip_address;
	public $added_date;
	public $updated_date;
	public $status;
	public $is_deleted;
	
	const TYPE_CONTACT = 'Contact';
	const TYPE_ENQUIRY = 'Enquiry';
	const TYPE_PLAN    = 'Plan Trip';
	const TYPE_CUSTOMIZE = 'Customize';
	const TYPE_BOOKING = 'Booking';

	//Find all the active rows in the current database table.
	public static function find_all_active($type = '') {
		global $db;
        $cond = "";
        if(!empty($type)) {
            $cond = " AND type='".$db->escape_value($type)."'";
        }
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE is_deleted=0{$cond} ORDER BY added_date DESC");
	}

	//Find a single row in the database where id is provided and not deleted.
	public static function find_by_id($id=0){
		global $db;
		$result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id={$id} AND is_deleted=0 LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
	}

	//Find rows from the database provided the SQL statement.
	public static function find_by_sql($sql="") {
		global $db;
		$result_set = $db->query($sql);
		$object_array = array();
		while ($row = $db->fetch_array($result_set)) {
		  $object_array[] = self::instantiate($row);
		}
		return $object_array;
	}

	//Instantiate all the attributes of the Class.
	private static function instantiate($record) {
		$object  = new self;
		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		}
		return $object;
	}

	//Check if the attribute exists in the class.
	private function has_attribute($attribute) {
	  $object_vars = $this->attributes();
	  return array_key_exists($attribute, $object_vars);
	}

	//Return an array of attribute keys and thier values.
	protected function attributes() { 
	  $attributes = array();
	  foreach(self::$db_fields as $field):
	    if(property_exists($this, $field)) {
	      $attributes[$field] = $this->$field;
	    }
	  endforeach;
	  return $attributes;
	}

	//Prepare attributes for database.
	protected function sanitized_attributes() {
	  global $db;
	  $clean_attributes = array();
	  foreach($this->attributes() as $key => $value):
	    $clean_attributes[$key] = $db->escape_value($value);
	  endforeach;
	  return $clean_attributes;
	}

	//Save the changes.
	public function save() {
        if (!isset($this->id)) {
            $this->added_date = registered();
        } else {
            $this->updated_date = registered();
        }
	  return isset($this->id) ? $this->update() : $this->create();
	}

	//Add  New Row to the database
	public function create() {
		global $db;
		$attributes = $this->sanitized_attributes();
		$sql = "INSERT INTO ".self::$table_name."(";
		$sql .= join(", ", array_keys($attributes));
		$sql .= ") VALUES (";
		
		$values = array();
		foreach(array_values($attributes) as $val) {
			if(is_null($val) || $val === '') {
				$values[] = "NULL";
			} else {
				$values[] = "'".$val."'";
			}
		}
		$sql .= join(", ", $values);
		
		$sql .= ")";
		if($db->query($sql)) {
			$this->id = $db->insert_id();
			return true;
		} else {
			return false;
		}
	}

	//Update a row in the database.
	public function update() {
		global $db;
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		
		foreach($attributes as $key => $value):
			if(is_null($value) || $value === '') {
				$attribute_pairs[] = "{$key}=NULL";
			} else {
				$attribute_pairs[] = "{$key}='{$value}'";
			}
		endforeach;
		
		$sql = "UPDATE ".self::$table_name." SET ";
		$sql .= join(", ", array_values($attribute_pairs));
		$sql .= " WHERE id=". $db->escape_value($this->id);
		$db->query($sql);
		return ($db->affected_rows() == 1) ? true : false;
	}

}
?>
