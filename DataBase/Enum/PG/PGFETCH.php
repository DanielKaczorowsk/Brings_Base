<?php
	namespace DataBase\Enum\PG;
		enum PGFETCH
		{
			case PG_ALL;
			case PG_ALLCOLUMN;
			case PG_ARRAY;
			case PG_ASSOC;
			case PG_ROW;
		}
?>