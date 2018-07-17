<?php

if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!empty($id)) {
    //Verificar se há usuarios cadastro no nível de acesso
    $result_art = "SELECT id FROM sts_artigos WHERE sts_cats_artigo_id='$id' LIMIT 1";
    $resultado_art = mysqli_query($conn, $result_art);
    if (($resultado_art) AND ( $resultado_art->num_rows != 0)) {
        $_SESSION['msg'] = "<div class='alert alert-danger'>A categoria de artigo não pode ser apagada, há artigos cadastrados nesta categoria!</div>";
        $url_destino = pg . '/listar/sts_list_cat_artigo';
        header("Location: $url_destino");
    } else {//Não há nenhum artigo cadastro nessa categoria
        //Apagar a categoria de artigo
        $result_pg_del = "DELETE FROM sts_cats_artigos WHERE id='$id'";
        mysqli_query($conn, $result_pg_del);
        if (mysqli_affected_rows($conn)) {

            $_SESSION['msg'] = "<div class='alert alert-success'>Categoria de artigo apagado com sucesso!</div>";
            $url_destino = pg . '/listar/sts_list_cat_artigo';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Categoria de artigo não foi apagado!</div>";
            $url_destino = pg . '/listar/sts_list_cat_artigo';
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}

