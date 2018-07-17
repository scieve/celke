<?php

if (!isset($seg)) {
    exit;
}
$SendEditBlogSob = filter_input(INPUT_POST, 'SendEditBlogSob', FILTER_SANITIZE_STRING);
if ($SendEditBlogSob) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);

    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vaziotag.php';
    $dados_validos = vazioTag($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para editar sobre autor no blog!</div>";
    }

    //Houve erro em algum campo será redirecionado para o login, não há erro no formulário tenta cadastrar no banco
    if ($erro) {
        $_SESSION['dados'] = $dados;
        $url_destino = pg . '/editar/sts_edit_blog_sobre';
        header("Location: $url_destino");
    } else {
        $result_ser_up = "UPDATE sts_blogs_sobres SET
                titulo='" . $dados_validos['titulo'] . "',  
                descricao='" . $dados_validos['descricao'] . "',
                sts_situacoe_id='" . $dados_validos['sts_situacoe_id'] . "',
                modified=NOW() 
                WHERE id='1'";

        mysqli_query($conn, $result_ser_up);

        if (mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);
            $_SESSION['msg'] = "<div class='alert alert-success'>Sobre autor no blog editado com sucesso!</div>";
            $url_destino = pg . '/editar/sts_edit_blog_sobre';
            header("Location: $url_destino");
        } else {
            $_SESSION['dados'] = $dados;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Sobre autor no blog não foi editado!</div>";
            $url_destino = pg . '/editar/sts_edit_blog_sobre';
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
