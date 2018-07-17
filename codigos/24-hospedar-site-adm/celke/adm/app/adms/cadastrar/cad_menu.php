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
                        <h2 class="display-4 titulo">Cadastrar Menu</h2>
                    </div>
                    <div class="p-2">
                        <?php
                        $btn_list = carregar_btn('listar/list_menu', $conn);
                        if ($btn_list) {
                            echo "<a href='" . pg . "/listar/list_menu' class='btn btn-outline-info btn-sm'>Listar</a> ";
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
                <form method="POST" action="<?php echo pg; ?>/processa/proc_cad_menu">  
                    <div class="form-group">
                        <label>
                            <span tabindex="0" data-placement="top" data-toggle="tooltip" title="Nome do item de menu a ser apresentado no menu">
                                <i class="fas fa-question-circle"></i>
                            </span>
                            <span class="text-danger">*</span> Nome
                        </label>
                        <input name="nome" type="text" class="form-control" placeholder="Nome do item de menu" value="<?php
                        if (isset($_SESSION['dados']['nome'])) {
                            echo $_SESSION['dados']['nome'];
                        }
                        ?>">
                    </div>


                    <div class="form-group">
                        <label>
                            <span tabindex="0" data-placement="top" data-toggle="tooltip" data-html="true" title="Página de icone: <a href='https://fontawesome.com/icons?d=gallery' target='_blank'>fontawesome</a>. Somente inserir o nome, Ex: fas fa-volume-up">
                                <i class="fas fa-question-circle"></i>
                            </span>
                            <span class="text-danger">*</span> Ícone
                        </label>
                        <input name="icone" type="text" class="form-control" placeholder="Ícone da página" value="<?php
                        if (isset($_SESSION['dados']['icone'])) {
                            echo $_SESSION['dados']['icone'];
                        }
                        ?>">
                    </div>


                    <div class="form-group">
                        <?php
                        $result_sits = "SELECT id, nome FROM adms_sits ORDER BY nome ASC";
                        $resultado_sits = mysqli_query($conn, $result_sits);
                        ?>
                        <label>
                            <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Selecionar a situação do menu.">
                                <i class="fas fa-question-circle"></i>
                            </span>
                            <span class="text-danger">*</span> Situação
                        </label>
                        <select name="adms_sit_id" id="depend_pg" class="form-control">
                            <option value="">Selecione</option>
                            <?php
                            while ($row_sits = mysqli_fetch_assoc($resultado_sits)) {
                                if (isset($_SESSION['dados']['adms_sit_id']) AND ( $_SESSION['dados']['adms_sit_id'] == $row_sits['id'])) {
                                    echo "<option value='" . $row_sits['id'] . "' selected>" . $row_sits['nome'] . "</option>";
                                } else {
                                    echo "<option value='" . $row_sits['id'] . "'>" . $row_sits['nome'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <p>
                        <span class="text-danger">* </span>Campo obrigatório
                    </p>
                    <input name="SendCadMen" type="submit" class="btn btn-success" value="Cadastrar">
                </form>
            </div>    
        </div>
        <?php
        unset($_SESSION['dados']);
        include_once 'app/adms/include/rodape_lib.php';
        ?>

    </div>
</body>


