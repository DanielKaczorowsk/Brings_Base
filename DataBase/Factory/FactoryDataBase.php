<?php
namespace DataBase\Factory;
use DataBase\Enum\PDO\MyBase as MyBase;
use DataBase\Enum\DataBase\DataBaseChose as DataBaseChose;
use DataBase\Model\MyBasePDO as MyBasePDO;
use DataBase\Model\MyBasePG as MyBasePG;
use DataBase\Model\MyBaseMysqli as MyBaseMysqli;
use DataBase\Model\MyBaseSQLSRV as MyBaseSQLSRV;
	class FactoryDataBase
	{
		private $connect;
		public function __construct(DataBaseChose $method)
		{
			match($method)
			{
				DataBaseChose::PDO_PG => $this->connect = new MyBasePDO(MyBase::PGSQL),
				DataBaseChose::PDO_MYSQL => $this->connect = new MyBasePDO(MyBase::PGSQL),
				DataBaseChose::PDO_MSSQL => $this->connect = new MyBasePDO(MyBase::MSSQL),
				DataBaseChose::PG => $this->connect = new MyBasePG,
				DataBaseChose::MYSQLI => $this->connect = new MyBaseMysqli,
				DataBaseChose::MSSQL => $this->connect = new MyBaseSQLSRV,
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
		public function set($query)
		{
			if(isset($query->Select))
			{
				$this->connect->Select($query->Select);
			}
			if(isset($query->Where))
			{
				$this->connect->Where($query->Where);
			}
			if(isset($query->From))
			{
				$this->connect->From($query->From, $query->JOIN ?? false,$query->Decidion);
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
			if(isset($query->CROSSJOIN))
			{
				$this->connect->CROSSJOIN($query->CROSSJOIN);
			}
			if(isset($query->UNION))
			{
				$this->connect->UNION($query->UNION);
			}
			if($query->JOIN === true)
			{
				return $this->connect->sql();
			}
			else
			{
				return $this->connect->get();
			}
		}
	}
?>