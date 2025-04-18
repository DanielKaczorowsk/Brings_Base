<?php
	namespace DataBase\Model;
	use DataBase\Base\MSSQL\ExceptionCustom\MSSQL_Exception as MSSQL_Exception;
	use DataBase\Base\MSSQL\MSSQL as MSSQL;
	use DataBase\Trait\Custom_Function as Custom;
	use DataBase\Object\DataBaseAbstract as BaseAbstract;
	include "../"."../"."SPL_autoload_register.php";
		class MyBaseSQLSRV extends BaseAbstract implements interface_connect
		{
			Private $connection, $stmt, $result,$isString,$object;
			public function Connect(string $host = 'localhost',string $user='sqlserv',string $pass='samsung1234',string $encoding='UTF8',string $port='1433'): void
			{
				ini_set('display_errors', 1);
				ini_set('display_startup_errors', 1);
				error_reporting(E_ALL);
				try 
				{
					$this->connection = new MSSQL($host,$user,$pass,$encoding,$port);
				}
				catch (MSSQL_Exception $e) 
				{
					Echo $e->getMessage();
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
				$this->stmt = SELF::SQL();
				$this->connection->query($this->stmt);
				$this->result = $this->connection->fetch_array();
				return $this->result;
			}
			public function Add(array $datas)
			{
				$this->connection->BEGIN_TRANSACTION();
				foreach($datas as $key => $data)
				{
					if(is_string($key))
					{
						$this->isString = $key;
					}
					$sql = "INSERT INTO ".$this->isString."({names})VALUES(:{binds}); ";
					$names = implode(' ,',array_keys($data));
					$binds = implode(' ,:',array_keys($data));
					$array = ['names'=>$names,'binds'=>$binds];
			
					foreach($array as $key => $template)
					{
						$sql = preg_replace('/{'.$key.'}/s', $template, $sql);
					}
					$this->connection->query_bind($sql);
					foreach ($data as $index => $value) 
					{
						$this->connection->bind(":$index", $value);
					}
					$this->connection->query();
				}
				$this->connection->COMMIT_TRANSACTION();
				
			}
		}
		$base = new MyBaseSQLSRV;
		$base->Connect();
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

?>