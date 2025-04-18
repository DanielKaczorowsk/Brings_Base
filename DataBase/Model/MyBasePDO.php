<?php
	namespace DataBase\Model;
	use pdo;
	use DataBase\Enum\PDO\MyBase as MyBase;
	use DataBase\Trait\Custom_Function as Custom;
	use DataBase\Object\DataBaseAbstract as BaseAbstract;
	class MyBasePDO extends BaseAbstract implements interface_connect
	{
		Private $connection, $stmt, $result,$base,$isString,$object;
		public function __construct(MyBase $method)
		{
			match($method)
			{
				MyBase::PGSQL => $this->base='pgsql:host' ,MyBase::MYSQL => $this->base='mysql:host',MyBase::SQLSRV => $this->base = 'sqlsrv:server',
			};
		}
		public function Connect(string $host = 'localhost',string $user='postgres',string $pass='',string $encoding='UTF8',string $port=''):	void
		{
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
			error_reporting(E_ALL);
			try {
				$this->connection = new PDO($this->base."=localhost;dbname=mybase",$user,$pass,
				array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '$encoding'"));
				$this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			}catch(PDOException $e){
				 echo $e->getMessage();
			}
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
			$this->result = $this->connection->prepare($this->stmt);
			$this->result->execute();
			$this->result = $this->result->fetchAll(PDO::FETCH_ASSOC);
			return $this->result;
		}
		public function update(array $datas)
		{
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
			error_reporting(E_ALL);
			$this->connection->beginTransaction();
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
				$this->stmt = $this->connection->prepare($sql);
				foreach($data as $bind_Key => $bind_Field)
				{
					if(array_key_first($data)!=$bind_Key)
					{
						$this->stmt->bindValue(":$bind_Key", $bind_Field);
					}
				}
				$this->stmt->execute();
			}
			$this->connection->commit();
		}
		public function Add(array $datas,int $id)
		{	
			$this->connection->beginTransaction();
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
			
				foreach($array as $key => $template)
				{
					$sql = preg_replace('/{'.$key.'}/s', $template, $sql);
				}
				$this->stmt = $this->connection->prepare($sql);
				foreach ($data as $index => $value) 
				{
					$this->stmt->bindValue(":$index", $value);
				}
				$this->stmt->execute();
			}
			$this->connection->commit();
		}
	};

?>
