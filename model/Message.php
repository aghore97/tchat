<?php

Class Message extends CoreItem {
	protected $table = _DB_TABLE_MESSAGE;
	
	public function __construct($init=0) {
		parent::__construct($init);
		
		if ( $this['id'] ) {
			
		}
	}
}

Class MessageList extends CoreList {
	protected $table = _DB_TABLE_MESSAGE;
	
	public function all_records(){
		$query = "
         SELECT
            m.id                    id,
            m.message				message,
            m.date_insert           date,
            u.name					user
         FROM
            `".$this->table."` m
            LEFT JOIN
               `"._DB_TABLE_USER."` u
			ON u.id = m.user_id
         ";
		$this->set_select($query);
		$this->set_order("date DESC");
		$records = $this->get_records();
		return $records;
	}
}

?>