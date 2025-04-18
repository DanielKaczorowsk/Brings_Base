<?php
	namespace DataBase\Model;
	use DataBase\Trait\Custom_Function as Custom;
	use DataBase\Object\DataBaseAbstract as BaseAbstract;
	use DataBase\Base\MYSQLI\MYSQL as mysqli;
	class MyBaseMysqli extends BaseAbstract implements interface_connect
	{
		Private $connection, $stmt, $result,$base,$isString,$object;
		public function Connect(string $host = 'localhost',string $user='root',string $pass='',string $encoding='UTF8',string $port=''):	void
		{
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
			error_reporting(E_ALL);
			try 
			{
				$this->connection = new mysqli($host, $user, $pass, "DataBaseProject");
			} 
			catch (mysqli_sql_exception $e) 
			{
				echo $e->getMessage();
			}
			mysqli_set_charset($this->connection, $encoding);
		}
		use Custom;
		public function setObject(object $object)
		{
			$this->object = $object;
			return $this;
		}
		public function get()
		{
			$this->stmt = SELF::sql();
			$this->result = $this->connection->query($this->stmt);
			$this->result = $this->result->fetch_all(MYSQLI_ASSOC);
			return $this->result;
		}
		public function update(array $datas)
		{
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
			error_reporting(E_ALL);
			$this->connection->begin_transaction();
			foreach($datas as $key => $data)
			{
				if(is_string($key))
				{
					$this->isString = $key;
				}
				$sql = "UPDATE ".$this->isString." SET {{update}}";
				$names = implode('}{',array_slice(array_keys($data),1));
				$sql = preg_replace(array('/{update}/'),$names,$sql);
				foreach($data as $key2 => $field)
				{
					if(array_key_first($data)!=$key2)
					{
						$name = $key2;
						if(array_key_last($data)!=$key2)
						{
							$bind = $key2.', ';
						}
						else
						{
							$bind = $key2.' ';
						}
						$sql = preg_replace(array('/{'.$key2.'}/'),$name.' = :'.$bind,$sql);
					}
					else
					{
						foreach($field as $where_key => $where)
						{
							$sql .= '  Where '.$where_key.' = '.$where;
						}
					}
				}
				$this->stmt = $this->connection->set_query($sql);
				foreach($data as $bind_Key => $bind_Field)
				{
					if(array_key_first($data)!=$bind_Key)
					{
						$this->stmt->bind(":$bind_Key", $bind_Field);
					}
				}
				$this->connection->query($this->stmt->get_query());
			}
			$this->connection->commit();
		}
		public function Add(array $datas)
		{	
			$this->connection->begin_transaction();
			foreach($datas as $key => $data)
			{
				if(is_string($key))
				{
					$this->isString = $key;
				}
				$sql = "INSERT INTO ".$this->isString." ({names})VALUES(:{binds})";
				$names = implode(' ,',array_keys($data));
				$binds = implode(' ,:',array_keys($data));
				$array = ['names'=>$names,'binds'=>$binds];
			
				foreach($array as $key => $template){
					$sql = preg_replace('/{'.$key.'}/s', $template, $sql);
				}
				$this->stmt = $this->connection->set_query($sql);
				foreach ($data as $index => $value) {
					$this->stmt->bind(":$index", $value);
				}
				$this->connection->query($this->stmt->get_query());
			}
			
			$this->connection->commit();
		}
	};
?>
