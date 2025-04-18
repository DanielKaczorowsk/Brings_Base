<?php
	namespace DataBase\Enum\PDO;
		enum MyBase
		{
			case PGSQL;
			case MYSQL;
			case SQLSRV;
		}