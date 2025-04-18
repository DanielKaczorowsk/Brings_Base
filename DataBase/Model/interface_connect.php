<?php
namespace DataBase\Model;
	Interface interface_connect
	{
		public function Connect(string $host,string $user,string $pass,string $encoding,string $port):	void;
	}
?>