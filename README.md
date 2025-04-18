# ORM_PG_MYSQLI_SQLSERV
$base = new DataBase;
$base->connect_PG();
$base->connect_PDO_PG();
$base->connect_PDO_MYSQL();
$base->connect_MYSQLI();
# ORM HAVE EXAMPLE FIELD
connect_PG(string $host = 'localhost',string $user='postgres',string $pass='',string $encoding='UTF8',string $port='');
connect_PDO_PG(string $host = 'localhost',string $user='postgres',string $pass='',string $encoding='UTF8',string $port='');
connect_PDO_MYSQL(string $host = 'localhost',string $user='root',string $pass='',string $encoding='UTF8',string $port='');
connect_MYSQLI(string $host = 'localhost',string $user='root',string $pass='',string $encoding='UTF8',string $port='');
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
# currently creating this function
CROSSJOIN(MyBase $query)
JOIN($decidion)
UNION(MyBase $query)
# EXAMPLE ADD
$base->Add(['Name DataBase'=>['KlientId'=>1,'Name'=>'Name'],['KlientId'=>2,'Name'=>'Name'],'Firma'=>['FirmID'=>1,'Name_Firm'=>'Firm']]);
# EXAMPLE UPDATE
$base->Update(['Name DataBase'=>['Where'=>['KlientId'=>1],'Name'=>'ChangeName'],['Where'=>['KlientId'=>9],'Name'=>'ChangeName']]);
#  currently creating sqlserv
