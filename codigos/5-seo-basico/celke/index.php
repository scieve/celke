<?php
session_start();
ob_start();

$seguranca = true;

//Biblioteca auxiliares
include_once 'config/config.php';
include_once 'config/conexao.php';
include_once 'lib/lib_valida.php';

$url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_STRING);

$url_limpa = limparurl($url);
$endereco = explode('/', $url_limpa);

$result_pagina = "SELECT * FROM sts_paginas WHERE endereco='".$endereco[0]."' AND sts_situacaos_pg_id=1 LIMIT 1";
$resultado_pagina = mysqli_query($conn, $result_pagina);
?>
<!DOCTYPE html>
<html lang="pt-br">
    <?php
    if(($resultado_pagina) AND ($resultado_pagina->num_rows != 0)){
        $row_pagina = mysqli_fetch_assoc($resultado_pagina);
        $file = 'app/'.$row_pagina['tp_pagina'].'/'.$endereco[0].'.php';
        if(file_exists($file)){
            include $file;
        }else{
            $url_destino = pg."/home";
            header("Location: $url_destino");
        }
    }else{        
        $url_destino = pg . "/home";
        header("Location: $url_destino");
    }
    ?>
</html>
