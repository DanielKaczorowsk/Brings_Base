<?php
	namespace DataBase\Object;

		abstract class DataBaseAbstract
		{
			private $query,$sql,$JOIN;
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
			public function From(string $from,bool $join = false,$decidion = null)
			{
				$this->query->From = $from;
				$this->query->JOIN = $join;
				$this->query->Decidion = $decidion;
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
			public function CROSSJOIN(string $query)
			{
				$this->query->CROSSJOIN = ' CROSS JOIN '.$query;
				return $this;
			}
			public function UNION(string $query)
			{
				$this->query->UNION = ' UNION '.$query;
				return $this;
			}
			public function sql()
			{
				if($this->query->JOIN === true && $this->query->Decidion === 'CROSSJOIN')
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