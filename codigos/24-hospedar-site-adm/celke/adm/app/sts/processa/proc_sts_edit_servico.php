<?php

if (!isset($seg)) {
    exit;
}
$SendEditSer = filter_input(INPUT_POST, 'SendEditSer', FILTER_SANITIZE_STRING);
if ($SendEditSer) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);
    
    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para editar os serviços!</div>";
    } 
    
    //Houve erro em algum campo será redirecionado para o login, não há erro no formulário tenta cadastrar no banco
    if ($erro) {
        $_SESSION['dados'] = $dados;
        $url_destino = pg . '/editar/sts_edit_servico';
        header("Location: $url_destino");
    } else {        
        $result_ser_up = "UPDATE sts_servicos SET
                titulo='" . $dados_validos['titulo'] . "', 
                icone_um='" . $dados_validos['icone_um'] . "', 
                nome_um='" . $dados_validos['nome_um'] . "', 
                descricao_um='" . $dados_validos['descricao_um'] . "', 
                icone_dois='" . $dados_validos['icone_dois'] . "', 
                nome_dois='" . $dados_validos['nome_dois'] . "',
                descricao_dois='" . $dados_validos['descricao_dois'] . "', 
                icone_tres='" . $dados_validos['icone_tres'] . "', 
                nome_tres='" . $dados_validos['nome_tres'] . "', 
                descricao_tres='" . $dados_validos['descricao_tres'] . "', 
                modified=NOW() 
                WHERE id='1'";
        
        mysqli_query($conn, $result_ser_up);
               
        if (mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);  
            $_SESSION['msg'] = "<div class='alert alert-success'>Serviços editados com sucesso!</div>";
            $url_destino = pg . '/editar/sts_edit_servico';
            header("Location: $url_destino");
        } else {
            $_SESSION['dados'] = $dados;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Serviços não foram editados!</div>";
            $url_destino = pg . '/editar/sts_edit_servico';
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
