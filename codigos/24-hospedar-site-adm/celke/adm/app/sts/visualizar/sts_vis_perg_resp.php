<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!empty($id)) {
    $result_perg_vis = "SELECT per.*,
                            sit.nome nome_sit,
                            sitcor.cor cor_sitcor
                            FROM sts_pergs_resps per
                            INNER JOIN sts_situacoes sit ON sit.id=per.sts_situacoe_id
                            INNER JOIN sts_cors sitcor ON sitcor.id=sit.sts_cor_id
                            WHERE per.id=$id
                            LIMIT 1";
    $resultado_perg_vis = mysqli_query($conn, $result_perg_vis);
    if (($resultado_perg_vis) AND ( $resultado_perg_vis->num_rows != 0)) {
        $row_perg_vis = mysqli_fetch_assoc($resultado_perg_vis);
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
                                <h2 class="display-4 titulo">Detalhes da Pergunta e Resposta</h2>
                            </div>
                            <div class="p-2">
                                <span class = "d-none d-md-block">
                                    <?php
                                    $btn_list = carregar_btn('listar/sts_list_perg_resp', $conn);
                                    if ($btn_list) {
                                        echo "<a href='" . pg . "/listar/sts_list_perg_resp' class='btn btn-outline-info btn-sm'>Listar</a> ";
                                    }
                                    $btn_edit = carregar_btn('editar/sts_edit_perg_resp', $conn);
                                    if ($btn_edit) {
                                        echo "<a href='" . pg . "/editar/sts_edit_perg_resp?id=" . $row_perg_vis['id'] . "' class='btn btn-outline-warning btn-sm'>Editar </a> ";
                                    }
                                    $btn_apagar = carregar_btn('processa/sts_apagar_perg_resp', $conn);
                                    if ($btn_apagar) {
                                        echo "<a href='" . pg . "/processa/sts_apagar_perg_resp?id=" . $row_perg_vis['id'] . "' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
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
                                        if ($btn_edit) {
                                            echo "<a class='dropdown-item' href='" . pg . "/editar/sts_edit_perg_resp?id=" . $row_perg_vis['id'] . "'>Editar</a>";
                                        }
                                        if ($btn_apagar) {
                                            echo "<a class='dropdown-item' href='" . pg . "/processa/sts_apagar_perg_resp?id=" . $row_perg_vis['id'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div><hr>
                        <dl class="row">
                            <dt class="col-sm-3">ID</dt>
                            <dd class="col-sm-9"><?php echo $row_perg_vis['id']; ?></dd>

                            <dt class="col-sm-3">Pergunta</dt>
                            <dd class="col-sm-9"><?php echo $row_perg_vis['pergunta']; ?></dd>

                            <dt class="col-sm-3">Resposta</dt>
                            <dd class="col-sm-9"><?php echo $row_perg_vis['resposta']; ?></dd>

                            <dt class="col-sm-3">Ordem</dt>
                            <dd class="col-sm-9"><?php echo $row_perg_vis['ordem']; ?></dd>
                            
                            <dt class="col-sm-3">Situação</dt>
                            <dd class="col-sm-9"><?php
                                echo "<span class='badge badge-" . $row_perg_vis['cor_sitcor'] . "'>" . $row_perg_vis['nome_sit'] . "</span>";
                                ?>
                            </dd>

                            <dt class="col-sm-3 text-truncate">Data do Cadastro</dt>
                            <dd class="col-sm-9"><?php echo date('d/m/Y H:i:s', strtotime($row_perg_vis['created'])); ?></dd>

                            <dt class="col-sm-3 text-truncate">Data de Edição</dt>
                            <dd class="col-sm-9"><?php
                                if (!empty($row_perg_vis['modified'])) {
                                    echo date('d/m/Y H:i:s', strtotime($row_perg_vis['modified']));
                                }
                                ?></dd>

                        </dl>
                    </div>
                </div>
                <?php
                include_once 'app/adms/include/rodape_lib.php';
                ?>

            </div>
        </body>
        <?php
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Pergunta e Resposta não encontrado!</div>";
        $url_destino = pg . '/listar/sts_list_perg_resp';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}