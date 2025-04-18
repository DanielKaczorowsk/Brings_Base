<?php
	namespace DataBase\Trait;
		trait Custom_Function
		{
			public function customFunction(string $function,mixed $field1=null,mixed $field2=null,mixed $field3=null)
			{
				if(isset($this->object))
				{
					if (isset($field1)&&isset($field2)&&isset($field3))
					{
						$this->result = $this->object->{$function}($field1,$fields2,$field3);
					}
					else if(isset($field1)&&isset($field2))
					{
						$this->result = $this->object->{$function}($field1,$field2);
					}
					else if(isset($field1))
					{
						$this->result = $this->object->{$function}($field1);
					}
					else
					{
						$this->result = $this->object->{$function}();
					}
				}
				else
				{
					if (isset($field1)&&isset($field2)&&isset($field3))
					{
						$this->result = $this->connection->{$function}($field1,$fields2,$field3);
					}
					else if(isset($field1)&&isset($field2))
					{
						$this->result = $this->connection->{$function}($field1,$field2);
					}
					else if(isset($field1))
					{
						$this->result = $this->connection->{$function}($field1);
					}
					else
					{
						$this->result = $this->connection->{$function}();
					}
				}
				return $this->result;
			}
		}
?>