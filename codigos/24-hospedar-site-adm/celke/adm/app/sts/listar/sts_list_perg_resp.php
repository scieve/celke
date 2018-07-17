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
                        <h2 class="display-4 titulo">Listar Perguntas e Respostas</h2>
                    </div>
                    <div class="p-2">
                        <?php
                        $btn_cad = carregar_btn('cadastrar/sts_cad_perg_resp', $conn);
                        if ($btn_cad) {
                            echo "<a href='" . pg . "/cadastrar/sts_cad_perg_resp' class='btn btn-outline-success btn-sm'>Cadastrar</a>";
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
                $qnt_result_pg = 40;

                //Calcular o inicio visualização
                $inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;


                $resul_perg = "SELECT perg.id, perg.pergunta, perg.ordem,
                            sit.nome nome_sit,
                            cores.cor cor_cores
                            FROM sts_pergs_resps perg
                            INNER JOIN sts_situacoes sit ON sit.id=perg.sts_situacoe_id
                            INNER JOIN sts_cors cores ON cores.id=sit.sts_cor_id
                            ORDER BY perg.ordem ASC LIMIT $inicio, $qnt_result_pg";

                $resultado_perg = mysqli_query($conn, $resul_perg);
                if (($resultado_perg) AND ( $resultado_perg->num_rows != 0)) {
                    ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Pergunta</th>
                                    <th>Ordem</th>
                                    <th class="d-none d-sm-table-cell">Situação</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $qnt_linhas_exe = 1;
                                while ($row_perg = mysqli_fetch_assoc($resultado_perg)) {
                                    ?>
                                    <tr>
                                        <th><?php echo $row_perg['id']; ?></th>
                                        <td><?php echo $row_perg['pergunta']; ?></td>
                                        <td><?php echo $row_perg['ordem']; ?></td>
                                        <td class="d-none d-sm-table-cell">
                                            <?php
                                            echo "<span class='badge badge-pill badge-" . $row_perg['cor_cores'] . "'>" . $row_perg['nome_sit'] . "</span>";
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="d-none d-md-block">
                                                <?php
                                                $btn_vis = carregar_btn('visualizar/sts_vis_perg_resp', $conn);
                                                if ($btn_vis) {
                                                    echo "<a href='" . pg . "/visualizar/sts_vis_perg_resp?id=" . $row_perg['id'] . "' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                                                }
                                                $btn_edit = carregar_btn('editar/sts_edit_perg_resp', $conn);
                                                if ($btn_edit) {
                                                    echo "<a href='" . pg . "/editar/sts_edit_perg_resp?id=" . $row_perg['id'] . "' class='btn btn-outline-warning btn-sm'>Editar </a> ";
                                                }
                                                $btn_apagar = carregar_btn('processa/sts_apagar_perg_resp', $conn);
                                                if ($btn_apagar) {
                                                    echo "<a href='" . pg . "/processa/sts_apagar_perg_resp?id=" . $row_perg['id'] . "' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                                                }
                                                $btn_ordem_menu = carregar_btn('processa/proc_sts_ordem_perg', $conn);
                                                if ($btn_ordem_menu) {
                                                    if ($qnt_linhas_exe == 1) {
                                                        echo "<button type='button' class='btn btn-sm btn-info disabled'>";
                                                        echo "<i class='fas fa-angle-double-up'></i>";
                                                        echo "</button> ";
                                                    } else {
                                                        echo "<a href='" . pg . "/processa/proc_sts_ordem_perg?id=" . $row_perg['id'] . "'><button type='button' class='btn btn-sm btn-info'>";
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
                                                        echo "<a class='dropdown-item' href='" . pg . "/visualizar/sts_vis_perg_resp?id=" . $row_perg['id'] . "'>Visualizar</a>";
                                                    }
                                                    if ($btn_edit) {
                                                        echo "<a class='dropdown-item' href='" . pg . "/editar/sts_edit_perg_resp?id=" . $row_perg['id'] . "'>Editar</a>";
                                                    }
                                                    if ($btn_apagar) {
                                                        echo "<a class='dropdown-item' href='" . pg . "/processa/sts_apagar_perg_resp?id=" . $row_perg['id'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
                        $result_pg = "SELECT COUNT(id) AS num_result FROM sts_pergs_resps";
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
                        echo "<a class='page-link' href='" . pg . "/listar/sts_list_perg_resp?pagina=1' tabindex='-1'>Primeira</a>";
                        echo "</li>";

                        for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
                            if ($pag_ant >= 1) {
                                echo "<li class='page-item'><a class='page-link' href='" . pg . "/listar/sts_list_perg_resp?pagina=$pag_ant'>$pag_ant</a></li>";
                            }
                        }

                        echo "<li class='page-item active'>";
                        echo "<a class='page-link' href='#'>$pagina</a>";
                        echo "</li>";

                        for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
                            if ($pag_dep <= $quantidade_pg) {
                                echo "<li class='page-item'><a class='page-link' href='" . pg . "/listar/sts_list_perg_resp?pagina=$pag_dep'>$pag_dep</a></li>";
                            }
                        }

                        echo "<li class='page-item'>";
                        echo "<a class='page-link' href='" . pg . "/listar/sts_list_perg_resp?pagina=$quantidade_pg'>Última</a>";
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


