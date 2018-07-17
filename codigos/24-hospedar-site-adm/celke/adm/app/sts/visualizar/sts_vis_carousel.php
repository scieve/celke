<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!empty($id)) {
    $result_pg_vis = "SELECT car.*,
                            sit.nome nome_sit,
                            sitcor.cor cor_sitcor,
                            cores.cor cor_cores
                            FROM sts_carousels car
                            INNER JOIN sts_situacoes sit ON sit.id=car.sts_situacoe_id
                            INNER JOIN sts_cors sitcor ON sitcor.id=sit.sts_cor_id
                            INNER JOIN sts_cors cores ON cores.id=sit.sts_cor_id 
                            WHERE car.id=$id
                            LIMIT 1";
    $resultado_pg_vis = mysqli_query($conn, $result_pg_vis);
    if (($resultado_pg_vis) AND ( $resultado_pg_vis->num_rows != 0)) {
        $row_pg_vis = mysqli_fetch_assoc($resultado_pg_vis);
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
                                <h2 class="display-4 titulo">Detalhes do Carousel</h2>
                            </div>
                            <div class="p-2">
                                <span class = "d-none d-md-block">
                                    <?php
                                    $btn_list = carregar_btn('listar/sts_list_carousel', $conn);
                                    if ($btn_list) {
                                        echo "<a href='" . pg . "/listar/sts_list_carousel' class='btn btn-outline-info btn-sm'>Listar</a> ";
                                    }
                                    $btn_edit = carregar_btn('editar/sts_edit_carousel', $conn);
                                    if ($btn_edit) {
                                        echo "<a href='" . pg . "/editar/sts_edit_carousel?id=" . $row_pg_vis['id'] . "' class='btn btn-outline-warning btn-sm'>Editar </a> ";
                                    }
                                    $btn_apagar = carregar_btn('processa/sts_apagar_carousel', $conn);
                                    if ($btn_apagar) {
                                        echo "<a href='" . pg . "/processa/sts_apagar_carousel?id=" . $row_pg_vis['id'] . "' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
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
                                            echo "<a class='dropdown-item' href='" . pg . "/listar/sts_list_carousel'>Listar</a>";
                                        }
                                        if ($btn_edit) {
                                            echo "<a class='dropdown-item' href='" . pg . "/editar/sts_edit_carousel?id=" . $row_pg_vis['id'] . "'>Editar</a>";
                                        }
                                        if ($btn_apagar) {
                                            echo "<a class='dropdown-item' href='" . pg . "/processa/sts_apagar_carousel?id=" . $row_pg_vis['id'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div><hr>
                        <dl class="row">
                            <dt class="col-sm-3">Imagem</dt>
                            <dd class="col-sm-9">
                                <?php
                                if (!empty($row_pg_vis['imagem'])) {
                                    echo "<img src='" . pgsite . "/assets/imagens/carousel/" . $row_pg_vis['id'] . "/" . $row_pg_vis['imagem'] . "' width='287' height='150'>";
                                }
                                ?>
                            </dd>
                            <dt class="col-sm-3">ID</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['id']; ?></dd>

                            <dt class="col-sm-3">Nome</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['nome']; ?></dd>

                            <dt class="col-sm-3">Titulo</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['titulo']; ?></dd>

                            <dt class="col-sm-3">Descrição</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['descricao']; ?></dd>

                            <dt class="col-sm-3">Posição do texto</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['posicao_text']; ?></dd>

                            <dt class="col-sm-3">Titulo do Botão</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['titulo_botao']; ?></dd>

                            <dt class="col-sm-3">Link do Botão</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['link']; ?></dd>

                            <dt class="col-sm-3">Cor do Botão</dt>
                            <dd class="col-sm-9">
                                <a href="<?php echo $row_pg_vis['link']; ?>" target="_black">
                                    <button type="button" class="btn btn-<?php echo $row_pg_vis['cor_cores']; ?> btn-sm"><?php echo $row_pg_vis['titulo_botao']; ?></button>    
                                </a>
                            </dd>

                            <dt class="col-sm-3">Ordem</dt>
                            <dd class="col-sm-9"><?php echo $row_pg_vis['ordem']; ?></dd>
                            
                            <dt class="col-sm-3">Situação</dt>
                            <dd class="col-sm-9"><?php
                                echo "<span class='badge badge-" . $row_pg_vis['cor_sitcor'] . "'>" . $row_pg_vis['nome_sit'] . "</span>";
                                ?>
                            </dd>

                            <dt class="col-sm-3 text-truncate">Data do Cadastro</dt>
                            <dd class="col-sm-9"><?php echo date('d/m/Y H:i:s', strtotime($row_pg_vis['created'])); ?></dd>

                            <dt class="col-sm-3 text-truncate">Data de Edição</dt>
                            <dd class="col-sm-9"><?php
                                if (!empty($row_pg_vis['modified'])) {
                                    echo date('d/m/Y H:i:s', strtotime($row_pg_vis['modified']));
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
        $_SESSION['msg'] = "<div class='alert alert-danger'>Carousel não encontrado!</div>";
        $url_destino = pg . '/listar/sts_list_carousel';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}