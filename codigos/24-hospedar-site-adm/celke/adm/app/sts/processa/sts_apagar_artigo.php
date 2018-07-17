<?php

if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!empty($id)) {
    //Pesquisar no banco de dados o nome da imagem
    $result_art = "SELECT id, imagem FROM sts_artigos WHERE id='$id' LIMIT 1";
    $resultado_art = mysqli_query($conn, $result_art);

    //Apagar a artigo
    $result_pg_del = "DELETE FROM sts_artigos WHERE id='$id'";
    mysqli_query($conn, $result_pg_del);
    if (mysqli_affected_rows($conn)) {
        
        $row_art = mysqli_fetch_assoc($resultado_art);
        //Apagar imagem
        if (!empty($row_art['imagem'])) {
            include_once 'lib/lib_upload.php';
            $destino = "../assets/imagens/artigo/" . $row_art['id'] . "/";
            $destino_apagar = $destino . $row_art['imagem'];
            apagarFoto($destino_apagar);
            apagarDiretorio($destino);
        }

        $_SESSION['msg'] = "<div class='alert alert-success'>Artigo apagado com sucesso!</div>";
        $url_destino = pg . '/listar/sts_list_artigo';
        header("Location: $url_destino");
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O artigo não foi apagado!</div>";
        $url_destino = pg . '/listar/sts_list_artigo';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}

