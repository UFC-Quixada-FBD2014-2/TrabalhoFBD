<?php 
class ValidacaoDosCampos{
 
    public function estaLogado() {

        if (isset($_SESSION['usuario']) && (!empty($_SESSION['usuario']))) {
            return true;
        }
        else {
            return false;
        }
 
    }
 
    public function logar($email, $senha) {
 
        if ($email == 'email@gmail.com' && $senha == 'senha') {
            $usuario = new Usuario();
            $usuario->setEmail($email);
            $usuario->setNome('Nome do usu�rio');
            $usuario->setSenha($senha);
 
            $_SESSION['usuario'] = $usuario;
            return true;
        }
        else {
            return false;
        }
 
    }
 
    public function pegar_usuario() {
 
        if ($this->estaLogado()) {
            $usuario = $_SESSION['usuario'];
            return $usuario;
        }
        else {
            return false;
        }
 
    }
 
    public function Expulsar() {
        header('location: controle.php?acao=sair');
    }
 
}