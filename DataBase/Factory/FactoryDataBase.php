<?php
namespace DataBase\Factory;
use DataBase\Enum\PDO\MyBase as MyBase;
use DataBase\Enum\DataBase\DataBaseChose as DataBaseChose;
use DataBase\Model\MyBasePDO as MyBasePDO;
use DataBase\Model\MyBasePG as MyBasePG;
use DataBase\Model\MyBaseMysqli as MyBaseMysqli;
	class FactoryDataBase
	{
		private $connect;
		public function __construct(DataBaseChose $method)
		{
			match($method)
			{
				DataBaseChose::PDO_PG => $this->connect = new MyBasePDO(MyBase::PGSQL),
				DataBaseChose::PDO_MYSQL => $this->connect = new MyBasePDO(MyBase::PGSQL),
				DataBaseChose::PG => $this->connect = new MyBasePG,
				DataBaseChose::MYSQLI => $this->connect = new MyBaseMysqli,
			};
		}
		public function connect(string $host,string $user,string $pass,string $encoding,string $port)
		{
			$this->connect->Connect($host,$user,$pass,$encoding,$port);
		}
		public function Update(array $datas)
		{
			$this->connect->Update($datas);
		}
		public function Add(array $datas)
		{
			$this->connect->Add($datas);
		}
		public function setObject(object $object)
		{
			$this->connect->setObject($object);
		}
		public function customFunction(string $function,mixed $field1=null,mixed $field2=null,mixed $field3=null)
		{
			$factory = $this->connect->customFunction($function,$field1,$field2,$field3);
			return $factory;
		}
		public function get($query)
		{
			if(isset($query->Select))
			{
				$this->connect->Select($query->Select);
			}
			if(isset($query->From))
			{
				$this->connect->From($query->From);
			}
			if(isset($query->Where))
			{
				$this->connect->Where($query->Where);
			}
			if(isset($query->OrWhere))
			{
				$this->connect->OrWhere($query->OrWhere);
			}
			if(isset($query->ON))
			{
				$this->connect->ON($query->ON);
			}
			if(isset($query->INNERJOIN))
			{
				$this->connect->INNERJOIN($query->INNERJOIN);
			}
			if(isset($query->JOIN))
			{
				$this->connect->JOIN($query->JOIN);
			}
			$this->connect->get();
		}
	}
?>