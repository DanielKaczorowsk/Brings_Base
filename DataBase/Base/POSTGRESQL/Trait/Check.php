<?php
	namespace DataBase\Base\POSTGRESQL\Trait;
	use DataBase\Base\POSTGRESQL\ExceptionCustom\PG_Exception as PG_Exception;
		trait Check
		{
			public function check(): void
			{
				if($this->result===FALSE)
				{
					$error = pg_last_error($this->connect);
					throw new PG_Exception('Your error : '.$error.' And SQL: '.$this->query);
					exit;
				}
				else
				{
					if (file_exists(SELF::FILENAME)) 
					{
						pg_untrace($this->connect);
					}
				}
			}
		}