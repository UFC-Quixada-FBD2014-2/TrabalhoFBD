<?php
	
	Class Conexao{
		function abrirConexao(){
			$host = "localhost";
			$dbname = "trabalhoFBD";
			$user = "postgres";
			$password = "postgres";
			
			try {
			   $conexao = new PDO("pgsql:host=$host dbname=$dbname user=$user password=$password");
			   return $conexao;
			} catch (PDOException  $e) {
			   echo $e->getMessage();
			   die();
			}
		}
	}
?>