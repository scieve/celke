<?php
if (!isset($seg)) {
    exit;
}
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
                        <h2 class="display-4 titulo">Listar Carousel</h2>
                    </div>
                    <div class="p-2">
                        <?php
                        $btn_cad = carregar_btn('cadastrar/sts_cad_carousel', $conn);
                        if ($btn_cad) {
                            echo "<a href='" . pg . "/cadastrar/sts_cad_carousel' class='btn btn-outline-success btn-sm'>Cadastrar</a>";
                        }
                        ?>
                    </div>
                </div>
                <?php
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }

                //Receber o número da página
                $pagina_atual = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_NUMBER_INT);
                $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

                //Setar a quantidade de itens por pagina
                $qnt_result_pg = 10;

                //Calcular o inicio visualização
                $inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;


                $resul_carousel = "SELECT car.id, car.nome, car.imagem, car.ordem,
                            sit.nome nome_sit,
                            cores.cor cor_cores
                            FROM sts_carousels car
                            INNER JOIN sts_situacoes sit ON sit.id=car.sts_situacoe_id
                            INNER JOIN sts_cors cores ON cores.id=sit.sts_cor_id
                            ORDER BY car.ordem ASC LIMIT $inicio, $qnt_result_pg";

                $resultado_carousel = mysqli_query($conn, $resul_carousel);
                if (($resultado_carousel) AND ( $resultado_carousel->num_rows != 0)) {
                    ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Ordem</th>
                                    <th class="d-none d-sm-table-cell">Imagem</th>
                                    <th class="d-none d-sm-table-cell">Situação</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $qnt_linhas_exe = 1;
                                while ($row_carousel = mysqli_fetch_assoc($resultado_carousel)) {
                                    ?>
                                    <tr>
                                        <th><?php echo $row_carousel['id']; ?></th>
                                        <td><?php echo $row_carousel['nome']; ?></td>
                                        <td><?php echo $row_carousel['ordem']; ?></td>
                                        <td class="d-none d-sm-table-cell">
                                            <img src="<?php echo pgsite . '/assets/imagens/carousel/' . $row_carousel['id'] . '/' . $row_carousel['imagem']; ?>" width="226" height="100">
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            <?php
                                            echo "<span class='badge badge-pill badge-" . $row_carousel['cor_cores'] . "'>" . $row_carousel['nome_sit'] . "</span>";
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="d-none d-md-block">
                                                <?php
                                                $btn_vis = carregar_btn('visualizar/sts_vis_carousel', $conn);
                                                if ($btn_vis) {
                                                    echo "<a href='" . pg . "/visualizar/sts_vis_carousel?id=" . $row_carousel['id'] . "' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                                                }
                                                $btn_edit = carregar_btn('editar/sts_edit_carousel', $conn);
                                                if ($btn_edit) {
                                                    echo "<a href='" . pg . "/editar/sts_edit_carousel?id=" . $row_carousel['id'] . "' class='btn btn-outline-warning btn-sm'>Editar </a> ";
                                                }
                                                $btn_apagar = carregar_btn('processa/sts_apagar_carousel', $conn);
                                                if ($btn_apagar) {
                                                    echo "<a href='" . pg . "/processa/sts_apagar_carousel?id=" . $row_carousel['id'] . "' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                                                }
                                                $btn_ordem_menu = carregar_btn('processa/proc_sts_ordem_car', $conn);
                                                if ($btn_ordem_menu) {
                                                    if ($qnt_linhas_exe == 1) {
                                                        echo "<button type='button' class='btn btn-sm btn-info disabled'>";
                                                        echo "<i class='fas fa-angle-double-up'></i>";
                                                        echo "</button> ";
                                                    } else {
                                                        echo "<a href='" . pg . "/processa/proc_sts_ordem_car?id=" . $row_carousel['id'] . "'><button type='button' class='btn btn-sm btn-info'>";
                                                        echo "<i class='fas fa-angle-double-up'></i>";
                                                        echo "</button></a> ";
                                                    }
                                                    $qnt_linhas_exe++;
                                                }
                                                ?>
                                            </span>
                                            <div class="dropdown d-block d-md-none">
                                                <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Ações
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                                    <?php
                                                    if ($btn_vis) {
                                                        echo "<a class='dropdown-item' href='" . pg . "/visualizar/sts_vis_carousel?id=" . $row_carousel['id'] . "'>Visualizar</a>";
                                                    }
                                                    if ($btn_edit) {
                                                        echo "<a class='dropdown-item' href='" . pg . "/editar/sts_edit_carousel?id=" . $row_carousel['id'] . "'>Editar</a>";
                                                    }
                                                    if ($btn_apagar) {
                                                        echo "<a class='dropdown-item' href='" . pg . "/processa/sts_apagar_carousel?id=" . $row_carousel['id'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        $result_pg = "SELECT COUNT(id) AS num_result FROM sts_carousels";
                        $resultado_pg = mysqli_query($conn, $result_pg);
                        $row_pg = mysqli_fetch_assoc($resultado_pg);
                        //echo $row_pg['num_result'];
                        //Quantidade de pagina 
                        $quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);
                        //Limitar os link antes depois
                        $max_links = 2;
                        echo "<nav aria-label='paginacao-blog'>";
                        echo "<ul class='pagination pagination-sm justify-content-center'>";
                        echo "<li class='page-item'>";
                        echo "<a class='page-link' href='" . pg . "/listar/sts_list_carousel?pagina=1' tabindex='-1'>Primeira</a>";
                        echo "</li>";

                        for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
                            if ($pag_ant >= 1) {
                                echo "<li class='page-item'><a class='page-link' href='" . pg . "/listar/sts_list_carousel?pagina=$pag_ant'>$pag_ant</a></li>";
                            }
                        }

                        echo "<li class='page-item active'>";
                        echo "<a class='page-link' href='#'>$pagina</a>";
                        echo "</li>";

                        for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
                            if ($pag_dep <= $quantidade_pg) {
                                echo "<li class='page-item'><a class='page-link' href='" . pg . "/listar/sts_list_carousel?pagina=$pag_dep'>$pag_dep</a></li>";
                            }
                        }

                        echo "<li class='page-item'>";
                        echo "<a class='page-link' href='" . pg . "/listar/sts_list_carousel?pagina=$quantidade_pg'>Última</a>";
                        echo "</li>";
                        echo "</ul>";
                        echo "</nav>";
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
        include_once 'app/adms/include/rodape_lib.php';
        ?>

    </div>
</body>


