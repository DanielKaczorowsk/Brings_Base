<?php
	namespace DataBase\Enum\DataBase;
		enum DataBaseChose
		{
			case PDO_PG;
			case PDO_MYSQL;
			case PG;
			case MYSQLI;
		}