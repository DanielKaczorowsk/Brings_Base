<?php
	namespace DataBase\Base\MSSQL\ExceptionCustom;
	use Exception;
	use DataBase\Base\MSSQL\MSSQL as MSSQL;
		class MSSQL_Exception extends Exception
		{
			public function __construct(string $msg,int $code = SQLSRV::CODE)//Throwable $previous = SQLSRV::PREVIOUS)
			{
				parent::__construct($msg,$code);
			}
		};
?>