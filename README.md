# Welcome in my own ORM Brings_Base
# Example Connection
$base = new DataBase;
$base->connect_PG();
$base->connect_MYSQLI();
$base->MSSQL();
$base->connect_PDO_PG();
$base->connect_PDO_MYSQL();
$base->connect_PDO_MSSQL();
# ORM HAVE EXAMPLE FIELD
connect_PG(string $host = 'localhost',string $user='postgres',string $pass='',string $encoding='UTF8',string $port='');
connect_MYSQLI(string $host = 'localhost',string $user='root',string $pass='',string $encoding='UTF8',string $port='');
connect_MMSQL(string $host = 'sqlexpress',string $user='sqlserv',string $pass='',string $encoding='UTF8',string $port='1433');
connect_PDO_PG(string $host = 'localhost',string $user='postgres',string $pass='',string $encoding='UTF8',string $port='');
connect_PDO_MYSQL(string $host = 'localhost',string $user='root',string $pass='',string $encoding='UTF8',string $port='');
connect_PDO_MSSQL(string $host = 'sqlexpress',string $user='sqlserv',string $pass='',string $encoding='UTF8',string $port='1433');
# CUSTOM FUNCTION PG
$base->customFunction('query','Select * From Dane');
# CUSTOM FUNCTION OTHER
$row = $base->customFunction('query','Select * From Dane');
$base->setObject($row);
$base->customFunction('fetch_all',MYSQLI_ASSOC);
# EXAMPLE SEARCH
Select(array $select = ['*'])
From(string $from)
Where(array $where)
OrWhere(array $where)
ON(array $on)
INNERJOIN(array $innerjoin,array $on)
# Example CROSSJOIN
$base = new DataBase;
	$base->connect_PG();
	$test = $base->Where(["table.ID = table.ID"])->From('table',true,'CROSSJOIN')->get();
	$data = new DataBase;
	$data->connect_PG();
	$object = $data->Select(["table.records",'table.records'])->CROSSJOIN($test)->From('table')->get();
# EXAMPLE UNION
$base->connect_PG();
	$test = $base->Where(["records = 'field'"])->From('table',true,'UNION')->get();
	$data = new DataBase;
	$data->connect_PG();
	$object = $data->Select(["*"])->UNION($test)->From('table')->get();
# EXAMPLE ADD
$base->Add(['Name DataBase'=>['KlientId'=>1,'Name'=>'Name'],['KlientId'=>2,'Name'=>'Name'],'Firma'=>['FirmID'=>1,'Name_Firm'=>'Firm']]);
# EXAMPLE UPDATE
$base->Update(['Name DataBase'=>['Where'=>['KlientId'=>1],'Name'=>'ChangeName'],['Where'=>['KlientId'=>9],'Name'=>'ChangeName']]);
