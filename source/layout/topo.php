<nav id="topHeader" class="navbar navbar-expand-lg navbar-dark" >
    <a class="navbar-brand" href="http://www.emqdesenv.cf" target="_blank">
        <span><img src="../web/img/logo-menu.png" alt="logo" height="40" /></span></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse pl-4" id="navbarSupportedContent" style="">
        <ul class="nav navbar-nav mr-auto">
            <li>
                <a id="home" class="nav-link" href="../web/index.php?pagina=home" >Home<span class="sr-only">(current)</span></a>
            </li>
            <li class="dropdown" >
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false" >Cadastro</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a href="../web/index.php?pagina=register&act=cad_cliente" class="dropdown-item" >Cliente</a>
                </div>
            </li>
            <li class="dropdown" >
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false" >Gerenciamento</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php if (in_array('gerenciamento-orcamento', $paginas)): ?>
                    <a href="../web/index.php?pagina=gerenciamento-orcamento" class="dropdown-item" >Orçamento</a>
                    <?php endif ?>
                    <?php if (in_array('venda', $paginas)): ?>
                    <a href="../web/index.php?pagina=venda" class="dropdown-item" >Venda</a>
                    <?php endif; ?>
                    <?php if (in_array('gerEntrega', $paginas)): ?>
                    <a href="../web/index.php?pagina=gerEntrega" class="dropdown-item" >Entrega de Produtos</a>
                    <?php endif; ?>
                    <?php if (in_array('preco', $paginas)): ?>
                    <a href="../web/index.php?pagina=preco" class="dropdown-item" >Preço</a>
                    <?php endif; ?>
                </div>
            </li>
            <li style="text-align: center">
                <a class="nav-link" href="../web/index.php?pagina=orcamento" >Pedidos & Orçamentos</a></li>
        </ul>
        <div class="navbar navbar-right config">
            <ul class="nav navbar">
                <li><a id="login" class="nav-link icon-login" href="../web/index.php?pagina=login" ><i class="fa fa-id-card" title="Cadastro de Login"></i></a></li>
                <li><a id="shield" class="nav-link icon-shield" href="../web/index.php?pagina=shield" ><i class="fa fa-shield" title="Segurança" ></i></a></li>
                <li><a id="config" class="nav-link icon-config" href="../web/index.php?pagina=config" ><i class="fa fa-cog" title="Configuração" ></i></a></li>
                <li><a id="exit" class="nav-link icon-exit" href="../web/exit.php" ><i class="fa fa-sign-out" title="Sair" ></i></a></li>
            </ul>
        </div><!-- navbar rigth-->
    </div><!-- navbar-collapse -->
</nav>
<div class="identification"><i>Usuário:</i> <?= ucfirst($_SESSION["login"]->login) ?></div>
