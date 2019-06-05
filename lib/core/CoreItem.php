<?php

Class CoreItem implements ArrayAccess {
	
	protected $table = '';
	protected $data=array();
	
	public function __construct($init=0) {
		$this['id'] = 0;

		if ($init and $this->table!='') {
			if (is_array($init) and count($init)) {
				$sets = array();
				foreach ($init as $field=>$value) {
					$sets[] = "`".$field."`='".clean_input($value)."'";
				}
				$query = "SELECT * FROM `".$this->table."` WHERE ".implode(' AND ',$sets)." LIMIT 1";
			}
			else {
				$query = "SELECT * FROM `".$this->table."` WHERE id=".(int)$init;
			}
			
			$result = mysql_query($query);
			if (mysql_errno()) {
				$error_message = 'MySQL Error #'.mysql_errno()."\n".mysql_error();
				trigger_mysql_error(1,$error_message,$query,__FILE__,__LINE__);
			}
			elseif (mysql_num_rows($result)) {
				$data = mysql_fetch_assoc($result);
				foreach ($data as $field=>$value) {
					$this->data[$field] = clean_output($value);
				}
			}
		}
	}
	
	public function save($properties='') {
		if (is_array($properties) and count($properties)) {
			$params = array();
			foreach ($properties as $field=>$value) {
				if ($field!='id') {
					if ($value==="NULL") {
						$params[] = "`".$field."`=NULL";
					}
					elseif ( in_array($value,array('NOW()')) ) {
						$params[] = "`".$field."`=".$value;
					}
					elseif (is_float($value)) {
						$params[] = "`".$field."`='".str_replace(',','.',''.$value)."'";
					}
					else {
						$params[] = "`".$field."`='".clean_input($value)."'";
					}
				}
			}
			
			if (count($params)) {
                $set = implode(' , ',$params);
                if ($this['id']) {
                    $query = "
							UPDATE `".$this->table."`
							SET ".$set."
							WHERE id = '".$this['id']."'";
                    $result = mysql_query($query);
                    if (mysql_errno()) {
                        $error_message = 'MySQL Error #'.mysql_errno()."\n".mysql_error();
                        trigger_mysql_error(2,$error_message,$query,__FILE__,__LINE__);
                    }
                }
                else {
                    $query = "
                            INSERT INTO `".$this->table."`
                            SET ".$set." ";
                    $result = mysql_query($query);
                    if (mysql_errno()) {
                        $error_message = 'MySQL Error #'.mysql_errno()."\n".mysql_error();
                        trigger_mysql_error(2,$error_message,$query,__FILE__,__LINE__);
                    }
                    elseif (mysql_affected_rows()) {
                        $this['id'] = mysql_insert_id();
                    }
                }
                $this->__construct($this['id']);
            }
		}
		elseif (!$this['id']) {
			$query = "INSERT INTO `".$this->table."`(id) VALUES(NULL) ";
			$result = mysql_query($query);
			if (mysql_errno()) {
				$error_message = 'MySQL Error #'.mysql_errno()."\n".mysql_error();
				trigger_mysql_error(2,$error_message,$query,__FILE__,__LINE__);
			}
			elseif (mysql_affected_rows()) {
				$this['id'] = mysql_insert_id();
			}
        }
	}
	
	public function offsetExists($property) {
        return isset($this->data[$property]);
    }

    public function offsetGet($property) {
        if ($this->offsetExists($property)) {
			return $this->data[$property];
        }
        else {
			return false;
        }
    }

    public function offsetSet($property,$new_value) {
		$this->data[$property] = $new_value;
		$this->modified[$property] = 1;
    }

    public function offsetUnset($property) {
        if ($this->offsetExists($property)) {
			unset($this->data[$property]);
			unset($this->modified[$property]);
        }
    }

}

?>