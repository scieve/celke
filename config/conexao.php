<?php
if(!isset($seguranca)){
    exit;
}
$servidor = "localhost";
$usuario = "root";
$senha = "@dm#ja25*Loc@l";
$dbname = "celke";

//Criar a conexao
$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);

if(!$conn){
    die("Falha na conexao: " . mysqli_connect_error());
}else{
    //echo "Conexao realizada com sucesso";
}