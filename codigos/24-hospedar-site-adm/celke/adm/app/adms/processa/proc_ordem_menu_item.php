<?php

if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!empty($id)) {
    //Pesquisar a ordem do menu atual a ser movido para cima
    $result_men_atual = "SELECT id, ordem FROM adms_menus WHERE id='$id' LIMIT 1";
    $resultado_men_atual = mysqli_query($conn, $result_men_atual);
    if (($resultado_men_atual) AND ( $resultado_men_atual->num_rows != 0)) {
        $row_men_atual = mysqli_fetch_assoc($resultado_men_atual);
        $ordem = $row_men_atual['ordem'];
        
        //Pesquisar o ID do menu a ser movido para baixo
        $ordem_super = $ordem - 1;
        $result_men_super = "SELECT id, ordem FROM adms_menus  WHERE ordem='$ordem_super' LIMIT 1";
        $resultado_men_super = mysqli_query($conn, $result_men_super);
        $row_men_super = mysqli_fetch_assoc($resultado_men_super);
        //Alterar a ordem para o número ser maior
        $result_men_mv_baixo = "UPDATE adms_menus SET
            ordem='$ordem',
            modified=NOW()
            WHERE id='" . $row_men_super['id'] . "'";
        mysqli_query($conn, $result_men_mv_baixo);

        //Alterar a ordem para o número ser maior
        $result_men_mv_super = "UPDATE adms_menus SET
            ordem='$ordem_super',
            modified=NOW()
            WHERE id='" . $row_men_atual['id'] . "'";
        mysqli_query($conn, $result_men_mv_super);

        //Redirecionar conforme a situação do alterar: sucesso ou erro
        if (mysqli_affected_rows($conn)) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Ordem do menu editado com sucesso!</div>";
            $url_destino = pg . '/listar/list_menu';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao editar a ordem do menu!</div>";
            $url_destino = pg . '/listar/list_menu';
            header("Location: $url_destino");
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Menu não encontrado!</div>";
        $url_destino = pg . '/listar/list_menu';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}