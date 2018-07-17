<?php

if (!isset($seg)) {
    exit;
}
$SendEditPergResp = filter_input(INPUT_POST, 'SendEditPergResp', FILTER_SANITIZE_STRING);
if ($SendEditPergResp) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);
    
    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vaziotag.php';
    $dados_validos = vazioTag($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para editar a pergunta e resposta!</div>";
    }     

    //Houve erro em algum campo será redirecionado para o login, não há erro no formulário tenta cadastrar no banco
    if ($erro) {
        $_SESSION['dados'] = $dados;
        $url_destino = pg . '/editar/sts_edit_perg_resp?id='.$dados['id'];
        header("Location: $url_destino");
    } else {
        $result_perg_up = "UPDATE sts_pergs_resps SET
                pergunta='" . $dados_validos['pergunta'] . "', 
                resposta='" . $dados_validos['resposta'] . "',  
                sts_situacoe_id='" . $dados_validos['sts_situacoe_id'] . "',
                modified=NOW() 
                WHERE id='" . $dados_validos['id'] . "'";
        
        mysqli_query($conn, $result_perg_up);
             
        if (mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']); 
            $_SESSION['msg'] = "<div class='alert alert-success'>Pergunta e resposta editado com sucesso!</div>";
            $url_destino = pg . '/listar/sts_list_perg_resp';
            header("Location: $url_destino");
        } else {
            $_SESSION['dados'] = $dados;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Pergunta e resposta não foi editado!</div>";
            $url_destino = pg . '/editar/sts_edit_perg_resp?id='.$dados['id'];
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
