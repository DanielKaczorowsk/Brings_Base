<?php
namespace DataBase;
use DataBase\Factory\FactoryDataBase as Factory;
use DataBase\Enum\DataBase\DataBaseChose as DataBaseChose;
use DataBase\Enum\PG\PGFETCH as PGFETCH;
use pdo;
include "../"."SPL_autoload_register.php";
	class DataBase
	{
		private $factory,$query;
		public function reset():	void
			{
				$this->query = new \stdClass();
			}
			public function Select(array $select = ['*'])
			{
				$this->reset();
				$this->query->Select = $select;
				$this->query->type = 'select';
				return $this;
			}
			public function From(string $from,bool $join = false,string $decidion = null)
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
					$this->query->type = 'where';
				}
				$this->query->Where = $where;
				return $this;
			}
			public function OrWhere(array $where)
			{
				$this->query->OrWhere = $where;
				return $this;
			}
			public function ON(array $on)
			{
				$this->query->On = $on;
				return $this;
			}
			public function INNERJOIN(array $innerjoin,array $on)
			{
				$this->query->INNERJOIN = array('innerjoin'=>$innerjoin,'on'=>$on);
				return $this;
			}
			public function CROSSJOIN(string $query)
			{
				$this->query->CROSSJOIN = $query;
				return $this;
			}
			public function UNION(string $query)
			{
				$this->query->UNION = $query;
				return $this;
			}
			public function setObject(object $object)
			{
				$this->factory->setObject($object);
			}
			public function get()
			{
				return $this->factory->set($this->query);
			}
			public function customFunction(string $function,mixed $field1=null,mixed $field2=null,mixed $field3=null)
			{
				$factory = $this->factory->customFunction($function,$field1,$field2,$field3);
				return $factory;
			}
			public function Add(array $datas)
			{
				$this->factory->Add($datas);
			}
			public function Update(array $datas)
			{
				$this->factory->Update($datas);
			}
		public function connect_PDO_PG(string $host = 'localhost',string $user='postgres',string $pass='',string $encoding='UTF8',string $port='')
		{
			$this->factory = new Factory(DataBaseChose::PDO_PG);
			$this->factory->Connect($host,$user,$pass,$encoding,$port);
		}
		public function connect_PDO_MYSQL(string $host = 'localhost',string $user='root',string $pass='',string $encoding='UTF8',string $port='')
		{
			$this->factory = new Factory(DataBaseChose::PDO_MYSQL);
			$this->factory->Connect($host,$user,$pass,$encoding,$port);
		}
		public function connect_PDO_MSSQL(string $host = 'localhost',string $user='root',string $pass='',string $encoding='UTF8',string $port='1433')
		{
			$this->factory = new Factory(DataBaseChose::PDO_MMSQL);
			$this->factory->Connect($host,$user,$pass,$encoding,$port);
		}
		public function connect_PG(string $host = 'localhost',string $user='postgres',string $pass='',string $encoding='UTF8',string $port='')
		{
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
			error_reporting(E_ALL);
			$this->factory = new Factory(DataBaseChose::PG);
			$this->factory->connect($host,$user,$pass,$encoding,$port);
		}
		public function connect_MYSQLI(string $host = 'localhost',string $user='root',string $pass='',string $encoding='UTF8',string $port='')
		{
			$this->factory = new Factory(DataBaseChose::MYSQLI);
			$this->factory->connect($host,$user,$pass,$encoding,$port);
		}
		public function connect_MMSQL(string $host = 'sqlexpress',string $user='sqlserv',string $pass='',string $encoding='UTF8',string $port='1433')
		{
			$this->factory = new Factory(DataBaseChose::MMSQL);
			$this->factory->connect($host,$user,$pass,$encoding,$port);
		}
	}
	
?>
