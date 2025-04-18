<?php
	namespace DataBase\Object;

		abstract class DataBaseAbstract
		{
			private $query,$sql;
			public function reset():	void
			{
				$this->query = new \stdClass();
			}
			public function Select(array $select = ['*'])
			{
				$this->reset();
				$this->query->base = 'SELECT '. implode(',',$select);
				$this->query->type = 'select';
				return $this;
			}
			public function From(string $from)
			{
				$this->query->From = $from;
				return $this;
			}
			public function Where(array $where)
			{
				if(empty($this->query->type))
				{
					$this->reset();
					$this->query->type='where';
					$this->query->base='SELECT *';
					$this->query->Where = ' WHERE '. implode(' AND ',$where);
				}
				else
				{
					$this->query->Where = ' WHERE '. implode(' AND ',$where);
				}
				return $this;
			}
			public function OrWhere(array $where)
			{
				$this->query->OrWhere = ' OR '.implode(' OR ',$where);
				return $this;
			}
			public function ON(array $on)
			{
				$this->query->On = ' ON '.implode(' AND ',$on);
				return $this;
			}
			public function INNERJOIN(array $innerjoin,array $on)
			{
				foreach($innerjoin as $key => $val){
					$inneron[]=" INNER JOIN ".$innerjoin[$key]." ON ".$on[$key];
				}
				$this->query->INNERJOIN = implode(' ',$inneron);
				return $this;
			}
			public function CROSSJOIN(MyBase $query)
			{
				$query->sql();
				$this->query->CROSSJOIN = ' CROSSJOIN '.$query->sql;
			}
			public function JOIN($decidion)
			{
				$this->query->JOIN = $decidion;
			}
			public function UNION(MyBase $query)
			{
				$query->sql();
				$this->query->UNION = ' UNION '.$query->sql;
			}
			public function sql()
			{
				if(isset($this->query->JOIN))
				{
					$this->sql .= $this->query->From;
				}
				else
				{
					$this->sql = $this->query->base;
					if(isset($this->query->From))
					{
						$this->sql .= ' FROM '.$this->query->From;
					}
				}
				if (isset($this->query->INNERJOIN))
				{
					$this->sql .= $this->query->INNERJOIN;
				}
				if(isset($this->query->On))
				{
					$this->sql .= $this->query->On;
				}
				if(isset($this->query->Where))
				{
					$this->sql .= $this->query->Where;
				}
				if(isset($this->query->OrWhere))
				{
					$this->sql .= $this->query->OrWhere;
				}
				if(isset($this->query->UNION))
				{
					$this->sql .= ' '.$this->query->UNION;
				}
				if(isset($this->query->CROSSJOIN))
				{
					$this->sql .= ' '.$this->query->CROSSJOIN;
				}
				return $this->sql;
			}
			public abstract function get();
		}
?>