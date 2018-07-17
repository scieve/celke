<?php

if (!isset($seg)) {
    exit;
}
$SendEditVideo = filter_input(INPUT_POST, 'SendEditVideo', FILTER_SANITIZE_STRING);
if ($SendEditVideo) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);

    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vaziotag.php';
    $dados_validos = vazioTag($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para editar os vídeo!</div>";
    }

    //Houve erro em algum campo será redirecionado para o login, não há erro no formulário tenta cadastrar no banco
    if ($erro) {
        $_SESSION['dados'] = $dados;
        $url_destino = pg . '/editar/sts_edit_video';
        header("Location: $url_destino");
    } else {
        $result_vid_up = "UPDATE sts_videos SET
                titulo='" . $dados_validos['titulo'] . "', 
                descricao='" . $dados_validos['descricao'] . "', 
                video_um='" . $dados_validos['video_um'] . "', 
                video_dois='" . $dados_validos['video_dois'] . "', 
                video_tres='" . $dados_validos['video_tres'] . "',  
                modified=NOW() 
                WHERE id='1'";

        mysqli_query($conn, $result_vid_up);

        if (mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);
            $_SESSION['msg'] = "<div class='alert alert-success'>Vídeos editados com sucesso!</div>";
            $url_destino = pg . '/editar/sts_edit_video';
            header("Location: $url_destino");
        } else {
            $_SESSION['dados'] = $dados;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Vídeos não foram editados!</div>";
            $url_destino = pg . '/editar/sts_edit_video';
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
