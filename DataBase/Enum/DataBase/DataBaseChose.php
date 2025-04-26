<?php
	namespace DataBase\Enum\DataBase;
		enum DataBaseChose
		{
			case PDO_PG;
			case PDO_MYSQL;
			case PDO_MSSQL;
			case PG;
			case MYSQLI;
			case MMSQL;
		}