<?php

Class User extends CoreItem {
	protected $table = _DB_TABLE_USER;
	
	public function __construct($init=0) {
		parent::__construct($init);
		
		if ( $this['id'] ) {
			$this->data['pass'] = aes_decrypt($this->data['pass']);
		}
	}
	
	public function generateUser() {
		$properties = array();
        $properties['login'] = $this->generateRandom('login');
		$properties['pass'] = $this->generateRandom('pass');
        parent::save($properties);
		if($this['id']){
			parent::save(['name' => 'User_'.$this['id']]);
		}
	}
   
	public function generateRandom($column='login', $len=8, $symbols='123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz'){
		$value = '';
		$user = new User();
		do{
			for ( $i = 1; $i <= $len; $i++ ) {
				$index = mt_rand(0,strlen($symbols)-1);
				$value .= $symbols[$index];
			}
			if($column=='pass'){
				$value = aes_encrypt($value);
			}
			$user = new User([$column => $value]);
		}while($user['id']);
		
		return $value;
	}
}

Class UserList extends CoreList {
	protected $table = _DB_TABLE_USER;

	public function getConnected(){
		$query = "
         SELECT
            u.*
         FROM
            `".$this->table."` u
         ";
		$this->set_select($query);
		$this->set_filter("u.connected", 1);
		$this->set_order("u.name ASC");
		$records = $this->get_records();
		return $records;
	}
}
?>