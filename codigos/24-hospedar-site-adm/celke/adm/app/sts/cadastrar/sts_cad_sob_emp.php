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
                        <h2 class="display-4 titulo">Cadastrar Sobre Empresa</h2>
                    </div>
                    <div class="p-2">
                        <?php
                        $btn_list = carregar_btn('listar/sts_list_sob_emp', $conn);
                        if ($btn_list) {
                            echo "<a href='" . pg . "/listar/sts_list_sob_emp' class='btn btn-outline-info btn-sm'>Listar</a> ";
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
                <form method="POST" action="<?php echo pg; ?>/processa/proc_sts_cad_sob_emp" enctype="multipart/form-data">  
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>
                                <span class="text-danger">*</span> Titulo
                            </label>
                            <input name="titulo" type="text" class="form-control" id="nome" placeholder="Titulo do item sobre empresa" value="<?php
                            if (isset($_SESSION['dados']['titulo'])) {
                                echo $_SESSION['dados']['titulo'];
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

                    <div class="form-group">
                        <label><span class="text-danger">*</span> Descrição</label>
                        <textarea name="descricao" class="form-control" rows="5"><?php
                            if (isset($_SESSION['dados']['descricao'])) {
                                echo $_SESSION['dados']['descricao'];
                            } 
                            ?>
                        </textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label> Foto </label>
                            <input type="file" name="imagem" onchange="previewImagem();">
                        </div>  
                        <div class="form-group col-md-6">
                            <img src="<?php echo pgsite . '/assets/imagens/sob_emp/preview_img.png'; ?>" id="preview-user" class="img-thumbnail" style="width: 150px; height: 120px;">
                        </div>                       
                    </div>

                    <p>
                        <span class="text-danger">* </span>Campo obrigatório
                    </p>
                    <input name="SendCadSobEmp" type="submit" class="btn btn-success" value="Cadastrar">
                </form>
            </div>    
        </div>
        <?php
        unset($_SESSION['dados']);
        include_once 'app/adms/include/rodape_lib.php';
        ?>
        <script>
            function previewImagem() {
                var imagem = document.querySelector('input[name=imagem').files[0];
                var preview = document.querySelector('#preview-user');

                var reader = new FileReader();

                reader.onloadend = function () {
                    preview.src = reader.result;
                }

                if (imagem) {
                    reader.readAsDataURL(imagem);
                } else {
                    preview.src = "";
                }
            }
        </script>   
    </div>
</body>


