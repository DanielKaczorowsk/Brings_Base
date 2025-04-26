# Welcome in my own ORM Brings_Base
# Example Connection
$base = new DataBase;</br>
$base->connect_PG();</br>
$base->connect_MYSQLI();</br>
$base->MSSQL();</br>
$base->connect_PDO_PG();</br>
$base->connect_PDO_MYSQL();</br>
$base->connect_PDO_MSSQL();
# ORM HAVE EXAMPLE FIELD
connect_PG(string $host = 'localhost',string $user='postgres',string $pass='',string $encoding='UTF8',string $port='');</br>
connect_MYSQLI(string $host = 'localhost',string $user='root',string $pass='',string $encoding='UTF8',string $port='');</br>
connect_MMSQL(string $host = 'sqlexpress',string $user='sqlserv',string $pass='',string $encoding='UTF8',string $port='1433');</br>
connect_PDO_PG(string $host = 'localhost',string $user='postgres',string $pass='',string $encoding='UTF8',string $port='');</br>
connect_PDO_MYSQL(string $host = 'localhost',string $user='root',string $pass='',string $encoding='UTF8',string $port='');</br>
connect_PDO_MSSQL(string $host = 'sqlexpress',string $user='sqlserv',string $pass='',string $encoding='UTF8',string $port='1433');
# CUSTOM FUNCTION PG
$base->customFunction('query','Select * From Dane');
# CUSTOM FUNCTION OTHER
$row = $base->customFunction('query','Select * From Dane');</br>
$base->setObject($row);</br>
$base->customFunction('fetch_all',MYSQLI_ASSOC);
# EXAMPLE SEARCH
Select(array $select = ['*'])</br>
From(string $from,bool $join = false,string $decidion = null)</br>
Where(array $where) Example Where(["row = 'field'","row2 = 'field2'"])</br>
OrWhere(array $where)</br>
ON(array $on)</br>
INNERJOIN(array $innerjoin,array $on)</br>
# Example CROSSJOIN
$base = new DataBase;</br>
	$base->connect_PG();</br>
	$test = $base->Where(["table.ID = table.ID"])->From('table',true,'CROSSJOIN')->get();</br>
	$data = new DataBase;</br>
	$data->connect_PG();</br>
	$object = $data->Select(["table.records",'table.records'])->CROSSJOIN($test)->From('table')->get();
# EXAMPLE UNION
$base->connect_PG();</br>
	$test = $base->Where(["row = 'field'"])->From('table',true,'UNION')->get();</br>
	$data = new DataBase;</br>
	$data->connect_PG();</br>
	$object = $data->Select(["*"])->UNION($test)->From('table')->get();
# EXAMPLE ADD
$base->Add(['Name DataBase'=>['KlientId'=>1,'Name'=>'Name'],['KlientId'=>2,'Name'=>'Name'],'Firma'=>['FirmID'=>1,'Name_Firm'=>'Firm']]);
# EXAMPLE UPDATE
$base->Update(['Name DataBase'=>['Where'=>['KlientId'=>1],'Name'=>'ChangeName'],['Where'=>['KlientId'=>9],'Name'=>'ChangeName']]);
