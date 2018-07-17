<?php

if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!empty($id)) {
    
    //Pesquisar no banco de dados o nome da imagem
    $result_art = "SELECT id, imagem FROM sts_paginas WHERE id='$id' LIMIT 1";
    $resultado_art = mysqli_query($conn, $result_art);
    
    //Pesquisar no banco de dados se há páginas com ordem acima do qual será apagada
    $result_men_ver = "SELECT id, ordem AS ordem_result FROM sts_paginas WHERE ordem > (SELECT ordem FROM sts_paginas WHERE id='$id') ORDER BY ordem ASC";
    $resultado_men_ver = mysqli_query($conn, $result_men_ver);

    //Apagar a página
    $result_pg_del = "DELETE FROM sts_paginas WHERE id='$id'";
    mysqli_query($conn, $result_pg_del);
    if (mysqli_affected_rows($conn)) {        
        
        $row_art = mysqli_fetch_assoc($resultado_art);
        //Apagar imagem
        if (!empty($row_art['imagem'])) {
            include_once 'lib/lib_upload.php';
            $destino = "../assets/imagens/paginas/" . $row_art['id'] . "/";
            $destino_apagar = $destino . $row_art['imagem'];
            apagarFoto($destino_apagar);
            apagarDiretorio($destino);
        }

        //Alterar a sequencia da ordem para não deixar nenhum número da ordem vazio
        if (($resultado_men_ver) AND ( $resultado_men_ver->num_rows != 0)) {
            while ($row_men_ver = mysqli_fetch_assoc($resultado_men_ver)) {
                $row_men_ver['ordem_result'] = $row_men_ver['ordem_result'] - 1;
                $result_men_or = "UPDATE sts_paginas SET
                   ordem='" . $row_men_ver['ordem_result'] . "', 
                   modified=NOW()
                   WHERE id='" . $row_men_ver['id'] . "'";
                mysqli_query($conn, $result_men_or);
            }
        }

        $_SESSION['msg'] = "<div class='alert alert-success'>Página apagada com sucesso!</div>";
        $url_destino = pg . '/listar/sts_list_pagina';
        header("Location: $url_destino");
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A página não foi apagada!</div>";
        $url_destino = pg . '/listar/sts_list_pagina';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}

