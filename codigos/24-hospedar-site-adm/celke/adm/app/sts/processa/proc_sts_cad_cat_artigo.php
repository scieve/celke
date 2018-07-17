<?php

if (!isset($seg)) {
    exit;
}
$SendCadCatArt = filter_input(INPUT_POST, 'SendCadCatArt', FILTER_SANITIZE_STRING);
if ($SendCadCatArt) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);
    
    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vaziotag.php';
    $dados_validos = vazioTag($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para cadastrar a categoria de artigo!</div>";
    } 
    
    //Houve erro em algum campo será redirecionado para o login, não há erro no formulário tenta cadastrar no banco
    if ($erro) {
        $_SESSION['dados'] = $dados;
        $url_destino = pg . '/cadastrar/sts_cad_cat_artigo';
        header("Location: $url_destino");
    } else {
        
        $result_cad_sob_emp = "INSERT INTO sts_cats_artigos (nome, sts_situacoe_id, created) VALUES (
        '" . $dados_validos['nome'] . "',
        '" . $dados_validos['sts_situacoe_id'] . "',
        NOW())";
        
        mysqli_query($conn, $result_cad_sob_emp);
        if (mysqli_insert_id($conn)) {
            unset($_SESSION['dados']);             
            $_SESSION['msg'] = "<div class='alert alert-success'>Categoria de artigo cadastrado com sucesso!</div>";
            $url_destino = pg . '/listar/sts_list_cat_artigo';
            header("Location: $url_destino");
        } else {
            $dados['obs'] = trim($dados_obs);
            $_SESSION['dados'] = $dados;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Categoria de artigo não foi cadastrado!</div>";
            $url_destino = pg . '/cadastrar/sts_list_cat_artigo';
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
