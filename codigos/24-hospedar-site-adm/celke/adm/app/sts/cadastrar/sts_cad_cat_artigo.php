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
                        <h2 class="display-4 titulo">Cadastrar Categoria de Artigo</h2>
                    </div>
                    <div class="p-2">
                        <?php
                        $btn_list = carregar_btn('listar/sts_list_cat_artigo', $conn);
                        if ($btn_list) {
                            echo "<a href='" . pg . "/listar/sts_list_cat_artigo' class='btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        ?>
                    </div>
                </div><hr>
                <?php
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
                ?>
                <form method="POST" action="<?php echo pg; ?>/processa/proc_sts_cad_cat_artigo" enctype="multipart/form-data">  
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>
                                <span class="text-danger">*</span> Nome
                            </label>
                            <input name="nome" type="text" class="form-control" id="nome" placeholder="Nome da categoria de artigo" value="<?php
                            if (isset($_SESSION['dados']['nome'])) {
                                echo $_SESSION['dados']['nome'];
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
                    <input name="SendCadCatArt" type="submit" class="btn btn-success" value="Cadastrar">
                </form>
            </div>    
        </div>
        <?php
        unset($_SESSION['dados']);
        include_once 'app/adms/include/rodape_lib.php';
        ?>
    </div>
</body>


