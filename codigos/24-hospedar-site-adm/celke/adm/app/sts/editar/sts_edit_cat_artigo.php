<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
//verificar a existencia do id na URL
if (!empty($id)) {
    $result_edit_emp = "SELECT * FROM sts_cats_artigos WHERE id='$id' LIMIT 1";
    $resultado_edit_emp = mysqli_query($conn, $result_edit_emp);
    //Verificar se encontrou a página no banco de dados
    if (($resultado_edit_emp) AND ( $resultado_edit_emp->num_rows != 0)) {
        $row_edit_emp = mysqli_fetch_assoc($resultado_edit_emp);
        include_once 'app/adms/include/head.php';
        ?>
        <body>
            <?php
            include_once 'app/adms/include/header.php';
            ?>
            <div class="d-flex">
                <?php
                include_once 'app/adms/include/menu.php';
                ?>

                <div class="content p-1">
                    <div class="list-group-item">
                        <div class="d-flex">
                            <div class="mr-auto p-2">
                                <h2 class="display-4 titulo">Editar Categoria de Artigo</h2>
                            </div>
                            <div class="p-2">
                                <span class = "d-none d-md-block">
                                    <?php
                                    $btn_list = carregar_btn('listar/sts_list_cat_artigo', $conn);
                                    if ($btn_list) {
                                        echo "<a href='" . pg . "/listar/sts_list_cat_artigo' class='btn btn-outline-info btn-sm'>Listar</a> ";
                                    }
                                    $btn_vis = carregar_btn('visualizar/sts_vis_cat_artigo', $conn);
                                    if ($btn_vis) {
                                        echo "<a href='" . pg . "/visualizar/sts_vis_cat_artigo?id=" . $row_edit_emp['id'] . "' class='btn btn-outline-primary btn-sm'>Visualizar </a> ";
                                    }
                                    $btn_apagar = carregar_btn('processa/sts_apagar_cat_artigo', $conn);
                                    if ($btn_apagar) {
                                        echo "<a href='" . pg . "/processa/sts_apagar_cat_artigo?id=" . $row_edit_emp['id'] . "' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($btn_list) {
                                            echo "<a class='dropdown-item' href='" . pg . "/listar/sts_list_cat_artigo'>Listar</a>";
                                        }
                                        if ($btn_vis) {
                                            echo "<a class='dropdown-item' href='" . pg . "/visualizar/sts_vis_cat_artigo?id=" . $row_edit_emp['id'] . "'>Visualizar</a>";
                                        }
                                        if ($btn_apagar) {
                                            echo "<a class='dropdown-item' href='" . pg . "/processa/sts_apagar_cat_artigo?id=" . $row_edit_emp['id'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div><hr>
                        <?php
                        if (isset($_SESSION['msg'])) {
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                        ?>
                        <form method="POST" action="<?php echo pg; ?>/processa/proc_sts_edit_cat_artigo" enctype="multipart/form-data">  
                            <input type="hidden" name="id" value="<?php
                            if (isset($row_edit_emp['id'])) {
                                echo $row_edit_emp['id'];
                            }
                            ?>">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>
                                        <span class="text-danger">*</span> Nome
                                    </label>
                                    <input name="nome" type="text" class="form-control" id="nome" placeholder="Nome da categoria de artigo" value="<?php
                                    if (isset($_SESSION['dados']['nome'])) {
                                        echo $_SESSION['dados']['nome'];
                                    } elseif (isset($row_edit_emp['nome'])) {
                                        echo $row_edit_emp['nome'];
                                    }
                                    ?>">
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <?php
                                    $result_sits = "SELECT id, nome FROM sts_situacoes ORDER BY nome ASC";
                                    $resultado_sits = mysqli_query($conn, $result_sits);
                                    ?>
                                    <label>
                                        <span class="text-danger">*</span> Situação
                                    </label>
                                    <select name="sts_situacoe_id" id="sts_situacaos_pg_id" class="form-control">
                                        <option value="">Selecione</option>
                                        <?php
                                        while ($row_sits = mysqli_fetch_assoc($resultado_sits)) {
                                            if (isset($_SESSION['dados']['sts_situacoe_id']) AND ( $_SESSION['dados']['sts_situacoe_id'] == $row_sits['id'])) {
                                                echo "<option value='" . $row_sits['id'] . "' selected>" . $row_sits['nome'] . "</option>";
                                                //Preencher com informações do banco de dados caso não tenha nenhum valor salvo na sessão $_SESSION['dados']
                                            } elseif (!isset($_SESSION['dados']['sts_situacoe_id']) AND ( isset($row_edit_emp['sts_situacoe_id']) AND ( $row_edit_emp['sts_situacoe_id'] == $row_sits['id']))) {
                                                echo "<option value='" . $row_sits['id'] . "' selected>" . $row_sits['nome'] . "</option>";
                                            } else {
                                                echo "<option value='" . $row_sits['id'] . "'>" . $row_sits['nome'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <p>
                                <span class="text-danger">* </span>Campo obrigatório
                            </p>
                            <input name="SendEditCatArt" type="submit" class="btn btn-warning" value="Salvar">
                        </form>
                    </div>    
                </div>

                <?php
                include_once 'app/adms/include/rodape_lib.php';
                ?>
            </div>
        </body>
        <?php
        unset($_SESSION['dados']);
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Categoria de artigo não encontrado!</div>";
        $url_destino = pg . '/listar/sts_list_cat_artigo';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}