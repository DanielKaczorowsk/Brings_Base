<?php
	namespace DataBase\Base\MSSQL;
	use DataBase\Base\MSSQL\ExceptionCustom\MSSQL_Exception as MSSQL_Exception;
		class MSSQL
			{
				private $connect,$result,$query,$sqlName,$escaped;
				public const CODE = 0;
				public const PREVIOUS = null;
				public function __construct(string $host = 'sqlexpress',string $user='sqlserv',string $pass='',string $encoding='UTF8',string $port='1433')
				{
					$serverName = "serverName\\".$host", ".$port;
					$connectionInfo = array("Database"=>"dbName", "UID"=>$user, "PWD"=>$pass,'CharacterSet' => $encoding);
					$this->connect = sqlsrv_connect( $serverName, $connectionInfo);
					if($this->connect === FALSE)
					{
						throw new SQLSERV_Exception("Can't connect to database server");
						exit;
					}
				}
				public function check(): void
				{
					if($this->result===FALSE)
					{
						$error = sqlsrv_errors();
						throw new MSSQL_Exception('Your error : '.$error.' And SQL: '.$this->query);
						exit;
					}
				}
				public function bind(string $example,string $value)
				{
					$this->query = preg_replace(array('/'.$example.'/'), array("'$value'"), $this->query);
				}
				public function query_bind($query)
				{
					$this->query .= $query;
				}
				public function query(string $query = null,array $params = null,array $options = null)
				{
					if(isset($query))
					{
						$this->query = $query;
					}
					$this->result = empty($params) ? sqlsrv_query($this->connect,$this->query) : sqlsrv_query($this->connect,$this->query,$params,$options);
					$this->check();
				}
				public function prepare(string $query = null,array $params = null,array $options = null)
				{
					if(isset($query))
					{
						$this->query = $query;
					}
					$this->result = empty($params) ? sqlsrv_prepare($this->connect,$this->query) : sqlsrv_prepare($this->connect,$this->query,$params,$options);
					$this->check();
				}
				public function execution(string $query = '')
				{
					if(isset($query))
					{
						SELF::prepare($query);
					}
					$this->result = sqlsrv_execute($this->connect,$this->result);
				}

				public function fetch(?int $row = null, ?int $offset = null): mixed
				{
					if( sqlsrv_fetch( $stmt ) === false) {
						die(throw new MSSQL_Exception('Your error : '.sqlsrv_errors().' And SQL: '.$this->query));
					}
				}
				public function fetch_array(int $fetchType = SQLSRV_FETCH_ASSOC,?int $row = null,?int $offset = null): array
				{
					$this->result = sqlsrv_fetch_array($this->result,$fetchType,$row,$offset);
				}
				public function fetch_object(string $className = null,array $ctorParams = null,?int $row = null,?int $offset = null): mixed
				{
					$this->result = sqlsrv_fetch_object($this->result,$className,$ctorParams,$row,$offset);
				}
				public function free_result():bool
				{
					sqlsrv_free_stmt($this->result);
				}
				public function hasRows()
				{
					$this->checking = sqlsrv_has_rows($this->connect);
					return $this->check;
				}
				public function get_field(int $fieldIndex = 0,?int $getAsType = null):mixed
				{
					$this->result = sqlsrv_get_field($this->result,$fieldIndex,$getAsType);
					return $this->result;
				}
				public function BEGIN_TRANSACTION()
				{
					if (sqlsrv_begin_transaction($this->connect)===false)
					{
						throw new MSSQL_Exception('Your error : '.sqlsrv_errors().' And SQL: '.$this->query);
					}
				}
				public function COMMIT_TRANSACTION()
				{
					if($this->result)
					{
						sqlsrv_commit($this->connect);
					}
					else
					{
						SELF::ROLLBACK_TRANSACTION();
						throw new MSSQL_Exception('Your error : '.sqlsrv_errors().' And SQL: '.$this->query);
					}
				}
				public function ROLLBACK_TRANSACTION()
				{
					sqlsrv_rollback($this->connect);
				}
			}
?>