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
                        <h2 class="display-4 titulo">Cadastrar Página</h2>
                    </div>
                    <div class="p-2">
                        <?php
                        $btn_list = carregar_btn('listar/list_pagina', $conn);
                        if ($btn_list) {
                            echo "<a href='" . pg . "/listar/list_pagina' class='btn btn-outline-info btn-sm'>Listar</a> ";
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
                <form method="POST" action="<?php echo pg; ?>/processa/proc_cad_pagina">  
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" title="Nome da página a ser apresentado no menu ou no listar páginas">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="text-danger">*</span> Nome
                            </label>
                            <input name="nome_pagina" type="text" class="form-control" id="nome" placeholder="Nome da Página" value="<?php
                            if (isset($_SESSION['dados']['nome_pagina'])) {
                                echo $_SESSION['dados']['nome_pagina'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label><span class="text-danger">*</span> Endereço</label>
                            <input name="endereco" type="text" class="form-control" id="email" placeholder="Endereço da página, ex: listar/list_pagina" value="<?php
                            if (isset($_SESSION['dados']['endereco'])) {
                                echo $_SESSION['dados']['endereco'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label> 
                                 <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Página de icone: <a href='https://fontawesome.com/icons?d=gallery' target='_blank'>fontawesome</a>. Somente inserir o nome, Ex: fas fa-volume-up">
                                    <i class="fas fa-question-circle"></i>
                                </span> Ícone
                            </label>
                            <input name="icone" type="text" class="form-control" id="email" placeholder="Ícone da página" value="<?php
                            if (isset($_SESSION['dados']['icone'])) {
                                echo $_SESSION['dados']['icone'];
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label> Observação</label>
                        <textarea name="obs" class="form-control"><?php
                            if (isset($_SESSION['dados']['obs'])) {
                                echo $_SESSION['dados']['obs'];
                            }
                            ?></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label>
                                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Principais palavras que indicam a função da página, por exemplo na página login: pagina de login, login. Máximo 180 letras.">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="text-danger">*</span> Palavra chave
                            </label>
                            <input name="keywords" type="text" class="form-control" id="nome" placeholder="Palavra chave" value="<?php
                            if (isset($_SESSION['dados']['keywords'])) {
                                echo $_SESSION['dados']['keywords'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label>
                                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Resumo do principal objetivo da página, máximo 180 letras.">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="text-danger">*</span> Descrição
                            </label>
                            <input name="description" type="text" class="form-control" id="email" placeholder="Descrição da página" value="<?php
                            if (isset($_SESSION['dados']['description'])) {
                                echo $_SESSION['dados']['description'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label>
                                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Desenvolvedor responsável pela criação página.">
                                    <i class="fas fa-question-circle"></i>
                                </span><span class="text-danger">*</span> Autor
                            </label>
                            <input name="author" type="text" class="form-control" id="email" placeholder="Desenvolvedor" value="<?php
                            if (isset($_SESSION['dados']['author'])) {
                                echo $_SESSION['dados']['author'];
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <?php
                            $result_robots = "SELECT id, nome FROM adms_robots";
                            $resultado_robots = mysqli_query($conn, $result_robots);
                            ?>
                            <label>
                                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="A página deve ser indexada pelos buscadores.">
                                    <i class="fas fa-question-circle"></i>
                                </span><span class="text-danger">*</span> Indexar
                            </label>
                            <select name="adms_robot_id" id="adms_robot_id" class="form-control">
                                <option value="">Selecione</option>
                                <?php
                                while ($row_robots = mysqli_fetch_assoc($resultado_robots)) {
                                    if (isset($_SESSION['dados']['adms_robot_id']) AND ( $_SESSION['dados']['adms_robot_id'] == $row_robots['id'])) {
                                        echo "<option value='" . $row_robots['id'] . "' selected>" . $row_robots['nome'] . "</option>";
                                    } else {
                                        echo "<option value='" . $row_robots['id'] . "'>" . $row_robots['nome'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>
                                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Página pública significa que para acessar a página não é necessário fazer login ou estar logado no administrativo">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="text-danger">*</span> Página Pública
                            </label>
                            <select name="lib_pub" id="lib_pub" class="form-control">
                                <?php
                                if (isset($_SESSION['dados']['lib_pub']) AND ( $_SESSION['dados']['lib_pub'] == 1)) {
                                    echo "<option value=''>Selecione</option>";
                                    echo "<option value='1' selected>Sim</option>";
                                    echo "<option value='2'>Não</option>";
                                } elseif (isset($_SESSION['dados']['lib_pub']) AND ( $_SESSION['dados']['lib_pub'] == 2)) {
                                    echo "<option value=''>Selecione</option>";
                                    echo "<option value='1'>Sim</option>";
                                    echo "<option value='2' selected>Não</option>";
                                } else {
                                    echo "<option value='' selected>Selecione</option>";
                                    echo "<option value='1'>Sim</option>";
                                    echo "<option value='2'>Não</option>";
                                }
                                ?>

                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <?php
                            $result_paginas = "SELECT id, nome_pagina FROM adms_paginas ORDER BY nome_pagina ASC";
                            $resultado_paginas = mysqli_query($conn, $result_paginas);
                            ?>
                            <label>
                                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Quando a página é dependente, por exemplo 'processa/proc_cad_usuario' é dependente da página 'cadastrar/cad_usuario', ao liberar a página 'cadastrar/cad_usuario' é liberado automaticamente a página 'processa/proc_cad_usuario'.">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="text-danger">*</span> Página Dependente
                            </label>
                            <select name="depend_pg" id="depend_pg" class="form-control">
                                <option value="">Selecione</option>
                                <?php
                                if (isset($_SESSION['dados']['depend_pg']) AND ( $_SESSION['dados']['depend_pg'] == 0)) {
                                    echo "<option value='0' selected>Não depende de outra página</option>";
                                } else {
                                    echo "<option value='0'>Não depende de outra página</option>";
                                }
                                while ($row_pagina = mysqli_fetch_assoc($resultado_paginas)) {
                                    if (isset($_SESSION['dados']['depend_pg']) AND ( $_SESSION['dados']['depend_pg'] == $row_pagina['id'])) {
                                        echo "<option value='" . $row_pagina['id'] . "' selected>" . $row_pagina['nome_pagina'] . "</option>";
                                    } else {
                                        echo "<option value='" . $row_pagina['id'] . "'>" . $row_pagina['nome_pagina'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">                            
                            <?php
                            $result_grps_pgs = "SELECT id, nome FROM adms_grps_pgs ORDER BY nome ASC";
                            $resultado_grps_pgs = mysqli_query($conn, $result_grps_pgs);
                            ?>
                            <label>
                                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Selecionar a qual grupo a página pertence.">
                                    <i class="fas fa-question-circle"></i>
                                </span><span class="text-danger">*</span> Grupo
                            </label>
                            <select name="adms_grps_pg_id" id="adms_grps_pg_id" class="form-control">
                                <option value="">Selecione</option>
                                <?php
                                while ($row_grps_pg = mysqli_fetch_assoc($resultado_grps_pgs)) {
                                    if (isset($_SESSION['dados']['adms_grps_pg_id']) AND ( $_SESSION['dados']['adms_grps_pg_id'] == $row_grps_pg['id'])) {
                                        echo "<option value='" . $row_grps_pg['id'] . "' selected>" . $row_grps_pg['nome'] . "</option>";
                                    } else {
                                        echo "<option value='" . $row_grps_pg['id'] . "'>" . $row_grps_pg['nome'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <?php
                            $result_tps_pgs = "SELECT id, tipo, nome FROM adms_tps_pgs ORDER BY nome ASC";
                            $resultado_tps_pgs = mysqli_query($conn, $result_tps_pgs);
                            ?>
                             <label>
                                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Selecionar o tipo de arquivo, ao qual diretório pertence no projeto.">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="text-danger">*</span> Tipo
                            </label>
                            <select name="adms_tps_pg_id" id="adms_tps_pg_id" class="form-control">
                                <option value="">Selecione</option>
                                <?php
                                while ($row_tps_pgs = mysqli_fetch_assoc($resultado_tps_pgs)) {
                                    if (isset($_SESSION['dados']['adms_tps_pg_id']) AND ( $_SESSION['dados']['adms_tps_pg_id'] == $row_tps_pgs['id'])) {
                                        echo "<option value='" . $row_tps_pgs['id'] . "' selected>" . $row_tps_pgs['tipo'] . " - " . $row_tps_pgs['nome'] . "</option>";
                                    } else {
                                        echo "<option value='" . $row_tps_pgs['id'] . "'>" . $row_tps_pgs['tipo'] . " - " . $row_tps_pgs['nome'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <?php
                            $result_sits_pgs = "SELECT id, nome FROM adms_sits_pgs ORDER BY nome ASC";
                            $resultado_sits_pgs = mysqli_query($conn, $result_sits_pgs);
                            ?>
                            <label>
                                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Selecionar a situação da página no projeto.">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="text-danger">*</span> Situação
                            </label>
                            <select name="adms_sits_pg_id" id="depend_pg" class="form-control">
                                <option value="">Selecione</option>
                                <?php
                                while ($row_sits_pgs = mysqli_fetch_assoc($resultado_sits_pgs)) {
                                    if (isset($_SESSION['dados']['adms_sits_pg_id']) AND ( $_SESSION['dados']['adms_sits_pg_id'] == $row_sits_pgs['id'])) {
                                        echo "<option value='" . $row_sits_pgs['id'] . "' selected>" . $row_sits_pgs['nome'] . "</option>";
                                    } else {
                                        echo "<option value='" . $row_sits_pgs['id'] . "'>" . $row_sits_pgs['nome'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <p>
                        <span class="text-danger">* </span>Campo obrigatório
                    </p>
                    <input name="SendCadPg" type="submit" class="btn btn-success" value="Cadastrar">
                </form>
            </div>    
        </div>
        <?php
        unset($_SESSION['dados']);
        include_once 'app/adms/include/rodape_lib.php';
        ?>

    </div>
</body>


