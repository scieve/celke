<?php

if (!isset($seg)) {
    exit;
}
$SendEditCatArt = filter_input(INPUT_POST, 'SendEditCatArt', FILTER_SANITIZE_STRING);
if ($SendEditCatArt) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);
    
    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vaziotag.php';
    $dados_validos = vazioTag($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para editar a categoria de artigo!</div>";
    } 
    
    //Houve erro em algum campo será redirecionado para o login, não há erro no formulário tenta cadastrar no banco
    if ($erro) {
        $_SESSION['dados'] = $dados;
        $url_destino = pg . '/editar/sts_edit_cat_artigo?id='.$dados['id'];
        header("Location: $url_destino");
    } else {
        $result_pg_up = "UPDATE sts_cats_artigos SET 
                nome='" . $dados_validos['nome'] . "', 
                sts_situacoe_id='" . $dados_validos['sts_situacoe_id'] . "',
                modified=NOW() 
                WHERE id='" . $dados_validos['id'] . "'";
        
        mysqli_query($conn, $result_pg_up);
               
        if (mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);   
            $_SESSION['msg'] = "<div class='alert alert-success'>Categoria de artigo editado com sucesso!</div>";
            $url_destino = pg . '/listar/sts_list_cat_artigo';
            header("Location: $url_destino");
        } else {
            $_SESSION['dados'] = $dados;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Categoria de artigo não foi editado!</div>";
            $url_destino = pg . '/editar/sts_list_cat_artigo?id='.$dados['id'];
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
