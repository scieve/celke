<?php
session_start();
ob_start();

$seguranca = true;

//Biblioteca auxiliares
include_once 'config/config.php';
include_once 'lib/lib_valida.php';

$url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_STRING);

$url_limpa = limparurl($url);
$endereco = explode('/', $url_limpa);
?>
<!DOCTYPE html>
<html lang="pt-br">
    <?php
    $file = 'app/sts/'.$endereco[0].'.php';
    if(file_exists($file)){
        include $file;
    }else{
        $url_destino = pg."/home";
        header("Location: $url_destino");
    }
    
    ?>
</html>
