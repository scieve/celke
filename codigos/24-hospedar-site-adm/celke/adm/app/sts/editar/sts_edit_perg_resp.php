<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
//verificar a existencia do id na URL
if (!empty($id)) {
    $result_edit_perg = "SELECT * FROM sts_pergs_resps WHERE id='$id' LIMIT 1";
    $resultado_edit_perg = mysqli_query($conn, $result_edit_perg);
    //Verificar se encontrou a página no banco de dados
    if (($resultado_edit_perg) AND ( $resultado_edit_perg->num_rows != 0)) {
        $row_edit_perg = mysqli_fetch_assoc($resultado_edit_perg);
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
                                <h2 class="display-4 titulo">Editar Pergunta e Resposta</h2>
                            </div>
                            <div class="p-2">
                                <span class = "d-none d-md-block">
                                    <?php
                                    $btn_list = carregar_btn('listar/sts_list_perg_resp', $conn);
                                    if ($btn_list) {
                                        echo "<a href='" . pg . "/listar/sts_list_perg_resp' class='btn btn-outline-info btn-sm'>Listar</a> ";
                                    }
                                    $btn_vis = carregar_btn('visualizar/sts_vis_perg_resp', $conn);
                                    if ($btn_vis) {
                                        echo "<a href='" . pg . "/visualizar/sts_vis_perg_resp?id=" . $row_edit_perg['id'] . "' class='btn btn-outline-primary btn-sm'>Visualizar </a> ";
                                    }
                                    $btn_apagar = carregar_btn('processa/sts_apagar_perg_resp', $conn);
                                    if ($btn_apagar) {
                                        echo "<a href='" . pg . "/processa/sts_apagar_perg_resp?id=" . $row_edit_perg['id'] . "' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
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
                                            echo "<a class='dropdown-item' href='" . pg . "/listar/sts_list_perg_resp'>Listar</a>";
                                        }
                                        if ($btn_vis) {
                                            echo "<a class='dropdown-item' href='" . pg . "/visualizar/sts_vis_perg_resp?id=" . $row_edit_perg['id'] . "'>Visualizar</a>";
                                        }
                                        if ($btn_apagar) {
                                            echo "<a class='dropdown-item' href='" . pg . "/processa/sts_apagar_perg_resp?id=" . $row_edit_perg['id'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
                        <form method="POST" action="<?php echo pg; ?>/processa/proc_sts_edit_perg_resp" enctype="multipart/form-data">  
                            <input type="hidden" name="id" value="<?php
                            if (isset($row_edit_perg['id'])) {
                                echo $row_edit_perg['id'];
                            }
                            ?>">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>
                                        <span class="text-danger">*</span> Pergunta
                                    </label>
                                    <input name="pergunta" type="text" class="form-control" id="nome" placeholder="Titulo da Pergunta" value="<?php
                                    if (isset($_SESSION['dados']['pergunta'])) {
                                        echo $_SESSION['dados']['pergunta'];
                                    } elseif (isset($row_edit_perg['pergunta'])) {
                                        echo $row_edit_perg['pergunta'];
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
                                            } elseif (!isset($_SESSION['dados']['sts_situacoe_id']) AND ( isset($row_edit_perg['sts_situacoe_id']) AND ( $row_edit_perg['sts_situacoe_id'] == $row_sits['id']))) {
                                                echo "<option value='" . $row_sits['id'] . "' selected>" . $row_sits['nome'] . "</option>";
                                            } else {
                                                echo "<option value='" . $row_sits['id'] . "'>" . $row_sits['nome'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label><span class="text-danger">*</span> Resposta</label>
                                <textarea name="resposta" class="form-control" rows="5"><?php
                                    if (isset($_SESSION['dados']['resposta'])) {
                                        echo $_SESSION['dados']['resposta'];
                                    } elseif (isset($row_edit_perg['resposta'])) {
                                        echo $row_edit_perg['resposta'];
                                    }
                                    ?></textarea>
                            </div>

                            <p>
                                <span class="text-danger">* </span>Campo obrigatório
                            </p>
                            <input name="SendEditPergResp" type="submit" class="btn btn-warning" value="Salvar">
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
        $_SESSION['msg'] = "<div class='alert alert-danger'>Pergunta e resposta não encontrado!</div>";
        $url_destino = pg . '/listar/sts_list_perg_resp';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}