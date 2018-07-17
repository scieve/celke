<?php
if (!isset($seg)) {
    exit;
}

$result_edit_ser = "SELECT * FROM sts_servicos WHERE id='1' LIMIT 1";
$resultado_edit_ser = mysqli_query($conn, $result_edit_ser);
//Verificar se encontrou a página no banco de dados
if (($resultado_edit_ser) AND ( $resultado_edit_ser->num_rows != 0)) {
    $row_edit_ser = mysqli_fetch_assoc($resultado_edit_ser);
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
                            <h2 class="display-4 titulo">Editar Serviços</h2>
                        </div>                        
                    </div><hr>
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                    ?>
                    <form method="POST" action="<?php echo pg; ?>/processa/proc_sts_edit_servico" enctype="multipart/form-data">                          
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>
                                    <span class="text-danger">*</span> Titulo
                                </label>
                                <input name="titulo" type="text" class="form-control" placeholder="Titulo da área de serviços" value="<?php
                                if (isset($_SESSION['dados']['titulo'])) {
                                    echo $_SESSION['dados']['titulo'];
                                } elseif (isset($row_edit_ser['titulo'])) {
                                    echo $row_edit_ser['titulo'];
                                }
                                ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>
                                    <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Página de icone: <a href='http://ionicons.com/v2/' target='_blank'>ionicons</a>. Somente inserir o nome, Ex: ion-ios-camera-outline">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                    <span class="text-danger">*</span> Ícone do Serviço 1
                                </label>
                                <input name="icone_um" type="text" class="form-control" placeholder="Ícone do serviço" value="<?php
                                if (isset($_SESSION['dados']['icone_um'])) {
                                    echo $_SESSION['dados']['icone_um'];
                                } elseif (isset($row_edit_ser['icone_um'])) {
                                    echo $row_edit_ser['icone_um'];
                                }
                                ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label><span class="text-danger">*</span> Nome do Serviço 1</label>
                                <input name="nome_um" type="text" class="form-control" placeholder="Nome do serviço um" value="<?php
                                if (isset($_SESSION['dados']['nome_um'])) {
                                    echo $_SESSION['dados']['nome_um'];
                                } elseif (isset($row_edit_ser['nome_um'])) {
                                    echo $row_edit_ser['nome_um'];
                                }
                                ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label> 
                                    <span class="text-danger">*</span> Descrição do Serviço 1
                                </label>
                                <input name="descricao_um" type="text" class="form-control" placeholder="Descrição do serviço um" value="<?php
                                if (isset($_SESSION['dados']['descricao_um'])) {
                                    echo $_SESSION['dados']['descricao_um'];
                                } elseif (isset($row_edit_ser['descricao_um'])) {
                                    echo $row_edit_ser['descricao_um'];
                                }
                                ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>
                                    <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Página de icone: <a href='http://ionicons.com/v2/' target='_blank'>ionicons</a>. Somente inserir o nome, Ex: ion-ios-camera-outline">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                    <span class="text-danger">*</span> Ícone do Serviço 2
                                </label>
                                <input name="icone_dois" type="text" class="form-control" placeholder="Ícone do serviço dois" value="<?php
                                if (isset($_SESSION['dados']['icone_dois'])) {
                                    echo $_SESSION['dados']['icone_dois'];
                                } elseif (isset($row_edit_ser['icone_dois'])) {
                                    echo $row_edit_ser['icone_dois'];
                                }
                                ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label><span class="text-danger">*</span> Nome do Serviço 2</label>
                                <input name="nome_dois" type="text" class="form-control" placeholder="Nome do serviço dois" value="<?php
                                if (isset($_SESSION['dados']['nome_dois'])) {
                                    echo $_SESSION['dados']['nome_dois'];
                                } elseif (isset($row_edit_ser['nome_dois'])) {
                                    echo $row_edit_ser['nome_dois'];
                                }
                                ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label> 
                                    <span class="text-danger">*</span> Descrição do Serviço 2
                                </label>
                                <input name="descricao_dois" type="text" class="form-control" placeholder="Descrição do serviço dois" value="<?php
                                if (isset($_SESSION['dados']['descricao_dois'])) {
                                    echo $_SESSION['dados']['descricao_dois'];
                                } elseif (isset($row_edit_ser['descricao_dois'])) {
                                    echo $row_edit_ser['descricao_dois'];
                                }
                                ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>
                                    <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Página de icone: <a href='http://ionicons.com/v2/' target='_blank'>ionicons</a>. Somente inserir o nome, Ex: ion-ios-camera-outline">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                    <span class="text-danger">*</span> Ícone do Serviço 3
                                </label>
                                <input name="icone_tres" type="text" class="form-control" placeholder="Ícone do serviço três" value="<?php
                                if (isset($_SESSION['dados']['icone_tres'])) {
                                    echo $_SESSION['dados']['icone_tres'];
                                } elseif (isset($row_edit_ser['icone_tres'])) {
                                    echo $row_edit_ser['icone_tres'];
                                }
                                ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label><span class="text-danger">*</span> Nome do Serviço 3</label>
                                <input name="nome_tres" type="text" class="form-control" placeholder="Nome do serviço três" value="<?php
                                if (isset($_SESSION['dados']['nome_tres'])) {
                                    echo $_SESSION['dados']['nome_tres'];
                                } elseif (isset($row_edit_ser['nome_tres'])) {
                                    echo $row_edit_ser['nome_tres'];
                                }
                                ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label> 
                                    <span class="text-danger">*</span> Descrição do Serviço 3
                                </label>
                                <input name="descricao_tres" type="text" class="form-control" placeholder="Descrição do serviço três" value="<?php
                                if (isset($_SESSION['dados']['descricao_tres'])) {
                                    echo $_SESSION['dados']['descricao_tres'];
                                } elseif (isset($row_edit_ser['descricao_tres'])) {
                                    echo $row_edit_ser['descricao_tres'];
                                }
                                ?>">
                            </div>
                        </div>
                        <p>
                            <span class="text-danger">* </span>Campo obrigatório
                        </p>
                        <input name="SendEditSer" type="submit" class="btn btn-warning" value="Salvar">
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
    $_SESSION['msg'] = "<div class='alert alert-danger'>Serviços não encontrado!</div>";
    $url_destino = pg . '/visualizar/home';
    header("Location: $url_destino");
}
