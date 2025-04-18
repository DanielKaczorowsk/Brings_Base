<?php
	namespace DataBase\Base\POSTGRESQL\ExceptionCustom;
	use Exception;
	use DataBase\Base\POSTGRESQL\PG as PG;
		class PG_Exception extends Exception
		{
			public function __construct(string $msg,int $code = PG::CODE)//Throwable $previous = PG::PREVIOUS)
			{
				parent::__construct($msg,$code);
			}
		};
?>