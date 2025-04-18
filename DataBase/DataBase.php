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
				return $this;
			}
			public function From(string $from)
			{
				$this->query->From = $from;
				return $this;
			}
			public function Where(array $where)
			{
				if(isset($this->query->Select))
				{
					$this->reset();
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
			public function JOIN()
			{
				$this->query->JOIN = true;
				return $this;
			}
			public function CROSSJOIN(MyBase $query)
			{
				
			}
			public function setObject(object $object)
			{
				$this->factory->setObject($object);
			}
			public function get()
			{
				$this->factory->get($this->query);
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
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
			error_reporting(E_ALL);
			$this->factory = new Factory(DataBaseChose::MYSQLI);
			$this->factory->connect($host,$user,$pass,$encoding,$port);
		}
	}
	//$base = new DataBase;
	//phpinfo();
	//$base->connect_PG();
	//$base->customFunction('query','Select * From Dane');
	//$base->customFunction('fetch',PGFETCH::PG_ALL);
	/*
	$row = $base->customFunction('query','Select * From Dane');
	$base->setObject($row);
	$base->customFunction('fetch_all',MYSQLI_ASSOC);
	*/
	/*$row = $base->customFunction('prepare','Select * From Dane');
	$base->setObject($row);
	$row2 = $base->customFunction('execute');
	$base->setObject($row2);
	$base->customFunction('fetchAll',PDO::FETCH_ASSOC);
	var_dump($base);*/
	//$row = $base->customFunction('fetchAll',PDO::FETCH_ASSOC);
	/*$base->Add(['Dane'=>['KlientId'=>18,'Imie'=>'Wacek','Nazwisko'=>'Walaszek','Phone'=>694582321],
		['KlientId'=>19,'Imie'=>'Wiktor','Nazwisko'=>'Macierewicz','Phone'=>694582321],
		'Firma'=>['FirmaId'=>4,'Nazwa'=>'Firmoteka','Kierownik'=>'Mariusz','Phone'=>694582321]]);*/
	//var_dump($base);
	//$base->Select()->From('Dane')->get();
			//$test = $base->Where(["KlientId = '15'"])->From('Dane')->get();
		//var_dump($test);
		//$sql = $base->Where(["imie = 'Wiktor'","nazwisko = 'Zyla'"])->OrWhere(["imie = 'Piotr'"])->From('Dane')->get();
		//var_dump($sql);
		//$base->customFunction('query_bind','Select * From Dane Where imie = :Andrzej AND imie = :Bogdan');
		//$base->customFunction('query','Select * From Dane Where KlientId = 15');
		//$base->customFunction('fetch',PGFETCH::PG_ALL);
		//$base->customFunction('bind',':Maciek','Marcin');*/
		/*$base->Add(['Dane'=>['KlientId'=>16,'Imie'=>'Wacek','Nazwisko'=>'Walaszek','Phone'=>694582321],
		['KlientId'=>17,'Imie'=>'Wiktor','Nazwisko'=>'Macierewicz','Phone'=>694582321],
		'Firma'=>['FirmaId'=>3,'Nazwa'=>'Firmoteka','Kierownik'=>'Mariusz','Phone'=>694582321]]);*/
		//var_dump($base);
	//$base->Update(['Dane'=>['Where'=>['KlientId'=>8],'Imie'=>'Marcin','Nazwisko'=>'Macierewicz','Phone'=>123321],['Where'=>['KlientId'=>9],'Imie'=>'Wladek','Nazwisko'=>'Stary','Phone'=>123321]]);

?>