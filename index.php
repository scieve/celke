<?php

//Biblioteca auxiliares
include 'config/config.php';

$seguranca = true;
$url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_STRING);
?>
<!DOCTYPE html>
<html lang="pt-br">
    <?php
    $file = 'app/sts/'.$url.'.php';
    if(file_exists($file)){
        include $file;
    }else{
        $url_destino = pg."/home";
        header("Location: $url_destino");
    }
    
    ?>
</html>
