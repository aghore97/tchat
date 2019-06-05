<?php

Class CoreList implements ArrayAccess {

    protected $table = '';
    protected $query = '';
	
	protected $data = array(
		'select'           => '',
		
        'filters'          => array(),
        'conditions'       => array(),

        'group'            => '',
        'order'            => '',

        'records_per_page' => 20,
        'page'             => 0,

        'total_records'    => 0,

        'pages'            => array(),
        'total_pages'      => 0,
    );

    public function get_records() {
        $records = array();

		if($this->data['select']!='') {
            $query  = $this->data['select'];
            $query .= $this->_get_where();
        }
        else {
			$query  = "SELECT * FROM `".$this->table."` ";
			$query .= $this->_get_where();
		}
        if ($this->data['group']!='') {
            $query .= ' GROUP BY '.$this->data['group'].' ';
        }

        if ($this->data['order']!='') {
            $query .= ' ORDER BY '.$this->data['order'].' ';
        }

        $result = mysql_query($query);
        if (mysql_errno()) {
            $error_message = 'MySQL Error #'.mysql_errno()."\n".mysql_error();
            trigger_mysql_error(1,$error_message,$query,__FILE__,__LINE__);
            return $records;
        }
        $this->data['total_records'] = mysql_num_rows($result);

        if ($this->data['total_records']) {

            $raw_records = array();

            if ($this->data['page']) {

                if ($this->data['records_per_page']) {
                    $this->data['total_pages'] = ceil($this->data['total_records']/$this->data['records_per_page']);
                }

                $this->data['pages'] = array();

                if ($this->data['total_pages']<=5) {
                    $i_start = 1;
                    $i_end = $this->data['total_pages'];
                }
                elseif($this->data['page']==1 or $this->data['page']==2) {
                    $i_start = 1;
                    $i_end = 5;
                }
                elseif(in_array($this->data['page'],array($this->data['total_pages']-1,$this->data['total_pages']))) {
                    $i_start = $this->data['total_pages']-4;
                    $i_end = $this->data['total_pages'];
                }
                else {
                    $i_start = $this->data['page']-2;
                    $i_end = $this->data['page']+2;
                }
                for ($i=$i_start ; $i<=$i_end ; $i++) {
                    $this->data['pages'][] = $i;
                }

                if ($this->data['page']>1) {
                    mysql_data_seek($result, ($this->data['page']-1)*$this->data['records_per_page']);
                }
                for ($i=0;$i<$this->data['records_per_page'];$i++) {
                    if ($data = mysql_fetch_assoc($result)) {
                        $raw_records[] = $data;
                    }
                }
            }
            else {
                while ($data = mysql_fetch_assoc($result)) {
                    $raw_records[] = $data;
                }
            }

            foreach ($raw_records as $raw_record) {
                foreach ($raw_record as $field=>$value) {
                    $raw_record[$field] = clean_output($value);
                }
                $records[$raw_record['id']] = $raw_record;
            }

        }

        //_show(mysql_error());echo $query;

        $this->data['query'] = $query;
        mysql_free_result($result);
        return $records;
    }

	public function set_select($select) {
        $this->data['select'] = $select;
    }
	
    public function set_condition($condition) {
        if (!in_array($condition,$this->data['conditions'])) {
            $this->data['conditions'][] = $condition;
        }
    }

    public function set_filter($property,$value) {
        $this->data['filters'][$property] = $value;
    }

    public function set_order($order) {
        $this->data['order'] = $order;
    }
    public function set_group($group) {
        $this->data['group'] = $group;
    }

    public function set_page($page) {
        $this->data['page'] = $page;
    }
    public function set_records_per_page($num_records) {
        $this->data['records_per_page'] = $num_records;
    }

    private function _get_where(){
        $where = " WHERE 1 ";
        if (is_array($this->data['filters']) and count($this->data['filters'])) {
            foreach ($this->data['filters'] as $filter=>$value) {
				if ($value==='NULL') {
					$where .= " AND ".$filter." IS NULL ";
				}
				else {
					$where .= " AND ".$filter."='".clean_input($value)."' ";
				}
            }
        }

        if (is_array($this->data['conditions']) and count($this->data['conditions'])) {
            foreach ($this->data['conditions'] as $condition) {
                $where .= " AND (".$condition.") ";
            }
        }

        return $where;
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
    public function offsetSet($property,$new_value) {}
    public function offsetUnset($property) {}

}


?>
