<?php
	namespace DataBase\Base\POSTGRESQL;
	use DataBase\Base\POSTGRESQL\Trait\Check as Check;
	use DataBase\Base\POSTGRESQL\ExceptionCustom\PG_Exception as PG_Exception;
	use DataBase\Enum\PG\PGFETCH as PGFETCH;
		class PG
			{
				private $connect,$result,$query,$sqlName,$escaped;
				public const CODE = 0;
				public const PREVIOUS = null;
				public const FILENAME = '/html/trace.log';
				use Check;
				public function __construct(string $host = 'localhost',string $user='postgres',string $pass='samsung1234',string $encoding='UTF8',string $port='5432')
				{
					$this->connect = @pg_connect("host=localhost port=5432 dbname=mybase "." user=".$user." password=".$pass.
							" options='--client_encoding=$encoding'");
					if($this->connect === FALSE)
					{
						throw new PG_Exception("Can't connect to database server");
						exit;
					}
					else
					{
						if (file_exists(SELF::FILENAME)) 
						{
							pg_trace(SELF::FILENAME, 'w', $this->connect);
						}
					}
				}
				public function bind(string $example,string $value)
				{
					$this->query = preg_replace(array('/'.$example.'/'), array("'$value'"), $this->query);
					//echo $this->query;
					//$this->query = preg_replace('/'.$example.'/s',$value,$this->query);
					//Self::query($this->query,);
				}
				public function query_bind($query)
				{
					$this->query .= $query;
				}
				public function query(string $query = null,array $params = [])
				{
					if(isset($query))
					{
						$this->query = $query;
					}
					$this->result = empty($params) ? pg_query($this->connect,$this->query) : pg_query_params($this->connect,$this->query,$params);
					$this->check();
				}
				public function prepare(string $sqlName, string $query)
				{
					$this->sqlName = $sqlName;
					$this->query = $query;
					$this->result = pg_prepare($this->connect,$this->sqlName,$this->query);
					$this->check();
				}
				public function execution(array $params = [],string $sqlName = null)
				{
					$this->result = pg_execute($this->connect, $sqlName ?? $this->sqlName, $params ?? $this->bind);
				}

				public function fetch(PGFETCH $fetch ,?int $param1=null,?int $param2 = null): array | false
				{
					match($fetch)
					{
						PGFETCH::PG_ALL => $this->result = pg_fetch_all($this->result, $param1 ?? PGSQL_ASSOC),
						PGFETCH::PG_ALLCOLUMN => $this->result = pg_fetch_all_columns($this->result,$param1 ?? 0),
						PGFETCH::PG_ARRAY => $this->result = pg_fetch_array($this->result,$param1,$param2 ?? PGSQL_BOTH),
						PGFETCH::PG_ASSOC => $this->result = pg_fetch_assoc($this->result, $param1),
						PGFETCH::PG_ROW => $this->result = pg_fetch_row($this->result, $param1,$param2 ?? PGSQL_NUM),
					
					};
					return $this->result;
				}
				public function fetch_result(string|false|null $row, mixed $field): string|false|null 
				{
					$this->result = pg_fetch_result($this->result,$row,$field);
				}
				public function fetch_object(?int $row = null,string $class = "stdClass",array $constructor_args = []): object|false
				{
					$this->result = pg_fetch_object($this->result,$row,$class,$constructor_args);
				}
				public function escapeByEA(string $data): string
				{
					$this->escaped = pg_escape_bytea($this->connect);
				}
				public function BEGIN_TRANSACTION()
				{
					$this->query .= 'BEGIN TRANSACTION; ';
				}
				public function COMMIT_TRANSACTION()
				{
					$this->query .= 'COMMIT TRANSACTION;';
				}
				public function ROLLBACK_TRANSACTION()
				{
					$this->query .= 'ROLLBACK TRANSACTION';
				}
			}
?>