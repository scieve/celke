<?php

if (!isset($seg)) {
    exit;
}
$SendEditCont = filter_input(INPUT_POST, 'SendEditCont', FILTER_SANITIZE_STRING);
if ($SendEditCont) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);
    
    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vaziotag.php';
    $dados_validos = vazioTag($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para editar a mensagem de contato!</div>";
    }     

    //Houve erro em algum campo será redirecionado para o login, não há erro no formulário tenta cadastrar no banco
    if ($erro) {
        $_SESSION['dados'] = $dados;
        $url_destino = pg . '/editar/sts_edit_contato?id='.$dados['id'];
        header("Location: $url_destino");
    } else {
        $result_perg_up = "UPDATE sts_contatos SET
                nome='" . $dados_validos['nome'] . "', 
                email='" . $dados_validos['email'] . "',  
                assunto='" . $dados_validos['assunto'] . "',
                mensagem='" . $dados_validos['mensagem'] . "',
                modified=NOW() 
                WHERE id='" . $dados_validos['id'] . "'";
        
        mysqli_query($conn, $result_perg_up);
             
        if (mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']); 
            $_SESSION['msg'] = "<div class='alert alert-success'>Mensagem de contato editado com sucesso!</div>";
            $url_destino = pg . '/listar/sts_list_contato';
            header("Location: $url_destino");
        } else {
            $_SESSION['dados'] = $dados;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Mensagem de contato não foi editado!</div>";
            $url_destino = pg . '/editar/sts_edit_contato?id='.$dados['id'];
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
