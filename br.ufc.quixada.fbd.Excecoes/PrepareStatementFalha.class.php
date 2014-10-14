<?php
	Class PrepareStatementFalha extends Exception{
		function __construct($mensagem){
			parent::__construct($mensagem);
		}
	}