<?php

if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!empty($id)) {
    
    //Apagar a contato
    $result_perg_del = "DELETE FROM sts_contatos WHERE id='$id'";
    mysqli_query($conn, $result_perg_del);
    if (mysqli_affected_rows($conn)) {

        $_SESSION['msg'] = "<div class='alert alert-success'>Mensagem de contato apagado com sucesso!</div>";
        $url_destino = pg . '/listar/sts_list_contato';
        header("Location: $url_destino");
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Mensagem de contato não foi apagado!</div>";
        $url_destino = pg . '/listar/sts_list_contato';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}

