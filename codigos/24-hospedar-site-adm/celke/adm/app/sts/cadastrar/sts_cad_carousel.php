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
                        <h2 class="display-4 titulo">Cadastrar Carousel</h2>
                    </div>
                    <div class="p-2">
                        <?php
                        $btn_list = carregar_btn('listar/sts_list_carousel', $conn);
                        if ($btn_list) {
                            echo "<a href='" . pg . "/listar/sts_list_carousel' class='btn btn-outline-info btn-sm'>Listar</a> ";
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
                <form method="POST" action="<?php echo pg; ?>/processa/proc_sts_cad_carousel" enctype="multipart/form-data">  
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>
                                <span class="text-danger">*</span> Nome
                            </label>
                            <input name="nome" type="text" class="form-control" id="nome" placeholder="Nome do carousel" value="<?php
                            if (isset($_SESSION['dados']['nome'])) {
                                echo $_SESSION['dados']['nome'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label><span class="text-danger">*</span> Titulo</label>
                            <input name="titulo" type="text" class="form-control" id="email" placeholder="Titulo a ser apresentado no carousel" value="<?php
                            if (isset($_SESSION['dados']['titulo'])) {
                                echo $_SESSION['dados']['titulo'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label> 
                                <span class="text-danger">*</span> Descrição
                            </label>
                            <input name="descricao" type="text" class="form-control" id="email" placeholder="Descrição apresentada sobre a imagem do carousel" value="<?php
                            if (isset($_SESSION['dados']['descricao'])) {
                                echo $_SESSION['dados']['descricao'];
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>                        
                                <span class="text-danger">*</span> Texto do Botão
                            </label>
                            <input name="titulo_botao" type="text" class="form-control" id="nome" placeholder="Texto a ser apresentado sobre o botão" value="<?php
                            if (isset($_SESSION['dados']['titulo_botao'])) {
                                echo $_SESSION['dados']['titulo_botao'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label>
                                <span class="text-danger">*</span> Link do Botão
                            </label>
                            <input name="link" type="text" class="form-control" id="email" placeholder="Link do botão" value="<?php
                            if (isset($_SESSION['dados']['link'])) {
                                echo $_SESSION['dados']['link'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <?php
                            $result_cors = "SELECT id, nome FROM sts_cors";
                            $resultado_cors = mysqli_query($conn, $result_cors);
                            ?>
                            <label>
                                <span class="text-danger">*</span> Cor do Botão
                            </label>
                            <select name="sts_cor_id" id="sts_cor_id" class="form-control">
                                <option value="">Selecione</option>
                                <?php
                                while ($row_cors = mysqli_fetch_assoc($resultado_cors)) {
                                    if (isset($_SESSION['dados']['sts_cor_id']) AND ( $_SESSION['dados']['sts_cor_id'] == $row_cors['id'])) {
                                        echo "<option value='" . $row_cors['id'] . "' selected>" . $row_cors['nome'] . "</option>";
                                    } else {
                                        echo "<option value='" . $row_cors['id'] . "'>" . $row_cors['nome'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>
                                <span class="text-danger">*</span> Posição do Texto
                            </label>
                            <select name="posicao_text" id="posicao_text" class="form-control">
                                <?php
                                if (isset($_SESSION['dados']['posicao_text']) AND ( $_SESSION['dados']['posicao_text'] == 'text-left')) {
                                    echo "<option value=''>Selecione</option>";
                                    echo "<option value='text-left' selected>Esquerdo</option>";
                                    echo "<option value='text-right'>Direito</option>";
                                    echo "<option value='text-center'>Centralizado</option>";
                                } elseif (isset($_SESSION['dados']['posicao_text']) AND ( $_SESSION['dados']['posicao_text'] == 'text-right')) {
                                    echo "<option value=''>Selecione</option>";
                                    echo "<option value='text-left'>Esquerdo</option>";
                                    echo "<option value='text-right' selected>Direito</option>";
                                    echo "<option value='text-center'>Centralizado</option>";
                                } elseif (isset($_SESSION['dados']['posicao_text']) AND ( $_SESSION['dados']['posicao_text'] == 'text-center')) {
                                    echo "<option value=''>Selecione</option>";
                                    echo "<option value='text-left'>Esquerdo</option>";
                                    echo "<option value='text-right'>Direito</option>";
                                    echo "<option value='text-center' selected>Centralizado</option>";
                                }else {
                                    echo "<option value='' selected>Selecione</option>";
                                    echo "<option value='text-left'>Esquerdo</option>";
                                    echo "<option value='text-right'>Direito</option>";
                                    echo "<option value='text-center'>Centralizado</option>";
                                }
                                ?>

                            </select>
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

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label> Foto </label>
                            <input type="file" name="imagem" onchange="previewImagem();">
                        </div>  
                        <div class="form-group col-md-6">
                            <img src="<?php echo pgsite . '/assets/imagens/carousel/preview_img.jpg'; ?>" id="preview-user" class="img-thumbnail" style="width: 287px; height: 150px;">
                        </div>                       
                    </div>

                    <p>
                        <span class="text-danger">* </span>Campo obrigatório
                    </p>
                    <input name="SendCadCar" type="submit" class="btn btn-success" value="Cadastrar">
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


