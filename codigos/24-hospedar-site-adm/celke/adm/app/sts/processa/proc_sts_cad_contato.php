<?php

if (!isset($seg)) {
    exit;
}
$SendCadCont = filter_input(INPUT_POST, 'SendCadCont', FILTER_SANITIZE_STRING);
if ($SendCadCont) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);
    
    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vaziotag.php';
    $dados_validos = vazioTag($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para cadastrar a mensagem de contato!</div>";
    } 
    
    //Houve erro em algum campo será redirecionado para o login, não há erro no formulário tenta cadastrar no banco
    if ($erro) {
        $dados['obs'] = trim($dados_obs);
        $_SESSION['dados'] = $dados;
        $url_destino = pg . '/cadastrar/sts_cad_contato';
        header("Location: $url_destino");
    } else {
        
        $result_cad_perg_resp = "INSERT INTO sts_contatos (nome, email, assunto, mensagem, created) VALUES (
        '" . $dados_validos['nome'] . "',
        '" . $dados_validos['email'] . "',
        '" . $dados_validos['assunto'] . "',
        '" . $dados_validos['mensagem'] . "',
        NOW())";
        
        mysqli_query($conn, $result_cad_perg_resp);
        if (mysqli_insert_id($conn)) {
            unset($_SESSION['dados']);            
            $_SESSION['msg'] = "<div class='alert alert-success'>Mensagem de contato cadastrado com sucesso!</div>";
            $url_destino = pg . '/listar/sts_list_contato';
            header("Location: $url_destino");
        } else {
            $dados['obs'] = trim($dados_obs);
            $_SESSION['dados'] = $dados;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Mensagem de contato não foi cadastrado!</div>";
            $url_destino = pg . '/cadastrar/sts_list_contato';
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
