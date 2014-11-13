<?php
	include_once 'br.ufc.quixada.fbd.sgbd/Conexao.class.php';
	
	Class Conexao{
		function abrirConexao(){
			try {
			   $conexao = new PDO("pgsql:host=localhost dbname=trabalhoFBD user=postgres password=postgres");
			   return $conexao;
			} catch (PDOException  $e) {
			   echo $e->getMessage();
			   die();
			}
		}
	}
?>