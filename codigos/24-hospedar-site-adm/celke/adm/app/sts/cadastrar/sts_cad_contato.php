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
                        <h2 class="display-4 titulo">Cadastrar Mensagem de Contato</h2>
                    </div>
                    <div class="p-2">
                        <?php
                        $btn_list = carregar_btn('listar/sts_list_contato', $conn);
                        if ($btn_list) {
                            echo "<a href='" . pg . "/listar/sts_list_contato' class='btn btn-outline-info btn-sm'>Listar</a> ";
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
                <form method="POST" action="<?php echo pg; ?>/processa/proc_sts_cad_contato" enctype="multipart/form-data">  
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>
                                <span class="text-danger">*</span> Nome
                            </label>
                            <input name="nome" type="text" class="form-control" id="nome" placeholder="Nome do autor da pergunta" value="<?php
                            if (isset($_SESSION['dados']['nome'])) {
                                echo $_SESSION['dados']['nome'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>
                                <span class="text-danger">*</span> E-mail
                            </label>
                            <input name="email" type="text" class="form-control" id="nome" placeholder="E-mail do autor da pergunta" value="<?php
                            if (isset($_SESSION['dados']['email'])) {
                                echo $_SESSION['dados']['email'];
                            }
                            ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>
                                <span class="text-danger">*</span> Assunto
                            </label>
                            <input name="assunto" type="text" class="form-control" id="nome" placeholder="Assunto da mensagem" value="<?php
                            if (isset($_SESSION['dados']['assunto'])) {
                                echo $_SESSION['dados']['assunto'];
                            }
                            ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label><span class="text-danger">*</span> Mensagem</label>
                        <textarea name="mensagem" class="form-control" rows="5"><?php
                            if (isset($_SESSION['dados']['mensagem'])) {
                                echo $_SESSION['dados']['mensagem'];
                            }
                            ?>
                        </textarea>
                    </div>


                    <p>
                        <span class="text-danger">* </span>Campo obrigatório
                    </p>
                    <input name="SendCadCont" type="submit" class="btn btn-success" value="Cadastrar">
                </form>
            </div>    
        </div>
        <?php
        unset($_SESSION['dados']);
        include_once 'app/adms/include/rodape_lib.php';
        ?>         
    </div>
</body>


