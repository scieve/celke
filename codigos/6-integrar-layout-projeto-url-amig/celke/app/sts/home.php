<?php
if (!isset($seguranca)) {
    exit;
}
include_once 'app/sts/header.php';
?>

<body>
    <?php
    include_once 'app/sts/menu.php';
    ?>
    <main role="main">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="first-slide img-fluid" src="imagens/imagem_um.jpg" alt="Primeiro conteúdo">
                    <div class="container">
                        <div class="carousel-caption text-left">
                            <h1 class="d-none d-md-block">Example headline.</h1>
                            <p class="d-none d-md-block">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                            <p class="d-none d-md-block"><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="second-slide img-fluid" src="imagens/imagem_dois.jpg" alt="Segundo conteúdo">
                    <div class="container">
                        <div class="carousel-caption">
                            <h1 class="d-none d-md-block">Another example headline.</h1>
                            <p class="d-none d-md-block">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                            <p class="d-none d-md-block"><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="third-slide img-fluid" src="imagens/imagem_tres.jpg" alt="Terceiro conteúdo">
                    <div class="container">
                        <div class="carousel-caption text-right">
                            <h1 class="d-none d-md-block">One more for good measure.</h1>
                            <p class="d-none d-md-block">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                            <p class="d-none d-md-block"><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <div class="jumbotron servicos">
            <div class="container">
                <h2 class="display-4 text-center" style="margin-bottom: 40px;">Serviços</h2>
                <div class="card-deck card-servicos">
                    <div class="card text-center">
                        <div class="icon-row tamanh-icone">
                            <span class="step size-96 text-primary">
                                <i class="icon ion-ios-camera-outline"></i>
                            </span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Serviço um</h5>
                            <p class="card-text lead">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>      
                        </div>
                    </div>
                    <div class="card text-center">
                        <div class="icon-row tamanh-icone">
                            <span class="step size-96 text-primary">
                                <i class="icon ion-ios-film-outline"></i>
                            </span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Serviços dois</h5>
                            <p class="card-text lead">This card has supporting text below as a natural lead-in to additional content.</p>
                        </div>
                    </div>
                    <div class="card text-center">
                        <div class="icon-row tamanh-icone ">
                            <span class="step size-96 text-primary">
                                <i class="icon ion-ios-videocam-outline"></i>
                            </span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Serviço tres</h5>
                            <p class="card-text lead">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="jumbotron depoimento">
            <div class="container">
                <h2 class="display-4 text-center" style="margin-bottom: 40px; color: #FFF;">Depoimentos</h2>
                <p class="lead text-center" style="margin-bottom: 40px; color: #FFF;">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
                <div class="card-deck">
                    <div class="card text-center dep-left">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/JfAgl6CGg2Q?rel=0" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="card text-center dep-center">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/4tBeeMcw2sM?rel=0" allowfullscreen></iframe>
                        </div>							
                    </div>
                    <div class="card text-center dep-right">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/i_R6sMRRQ0s?rel=0" allowfullscreen></iframe>
                        </div>							
                    </div>
                </div>
            </div>
        </div>

        <div class="jumbotron produto">
            <div class="container">
                <h2 class="display-4 text-center" style="margin-bottom: 40px;">Produto</h2>
                <div class="row featurette">
                    <div class="col-md-7 prod-text">
                        <h2 class="featurette-heading">First featurette heading.</h2>
                        <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
                    </div>
                    <div class="col-md-5 prod-img">
                        <img class="featurette-image img-fluid mx-auto" src="imagens/produto.jpg" alt="Generic placeholder image">
                    </div>
                </div>
            </div>
        </div>	

        <div class="jumbotron cadastro-email paralaxe-email" style="background-image:url(imagens/imagem_tres.jpg);">
            <div class="container">
                <div class="email-text">
                    <h2 class="display-4 text-center" style="margin-bottom: 40px">Receber novidades</h2>
                    <p class="lead text-center" style="margin-bottom: 40px;">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
                </div>
                <div class="email-form">
                    <form>
                        <div class="form-row justify-content-center">
                            <div class="col-sm-3 my-1">
                                <label class="sr-only">E-mail</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">@</div>
                                    </div>
                                    <input type="email" class="form-control" placeholder="Seu melhor e-mail">
                                </div>
                            </div>
                            <div class="col-auto my-1">
                                <button type="submit" class="btn btn-primary mb-2">Cadastrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>	



        <div class="jumbotron perg-resp">
            <div class="container">
                <h2 class="display-4 text-center perg-resp-text" style="margin-bottom: 40px">Perguntas e Respostas</h2>
                <div class="perg-resp-cont">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Pergunta 1
                                    </button>
                                </h5>
                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Pergunta 2
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                <div class="card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Pergunta 3
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                <div class="card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>	
    </main>
    <?php
    include_once 'app/sts/rodape.php';
    include_once 'app/sts/rodape_lib.php';
    ?>
</body>

