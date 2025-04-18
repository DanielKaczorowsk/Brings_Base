<?php
	namespace DataBase\Base\MYSQLI;
	use mysqli;
	
		class MYSQL extends mysqli
		{
			private $query;
			public function bind(string $example,string $value)
			{
				$this->query = preg_replace(array('/'.$example.'/'), array("'$value'"), $this->query);
				return $this;
			}
			public function set_query($query)
			{
				$this->query = $query;
				return $this;
			}
			public function get_query()
			{
				return $this->query;
			}
		}