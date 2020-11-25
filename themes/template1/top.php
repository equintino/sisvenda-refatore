<nav id="topHeader" class="navbar navbar-expand-lg navbar-dark" >
    <a class="navbar-brand" href="http://www.emqdesenv.cf" target="_blank">
        <img src="<?= theme("assets/img/logo-menu.png") ?>" alt="logo" height="40" />
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse pl-4" id="navbarSupportedContent" style="">
        <ul class="nav navbar-nav mr-auto">
            <li>
                <a id="home" class="nav-link" href="<?= url("/") ?>" >
                    Home<span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="dropdown" >
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false" >Cadastro</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a href="cadastro" class="dropdown-item" >Cliente</a>
                </div>
            </li>
            <li class="dropdown" >
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false" >
                    Gerenciamento
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php if (!empty($access) && in_array(' gerenciamento-orcamento', $access)): ?>
                    <a href="<?= url("/orcamento") ?>" class="dropdown-item" >
                         Orçamento
                    </a>
                    <?php endif ?>
                    <?php if (!empty($access) && in_array(' venda', $access)): ?>
                    <a href="<?= url("/gerenciamento") ?>" class="dropdown-item" >
                        Venda
                    </a>
                    <?php endif; ?>
                    <?php if (!empty($access) && in_array(' gerEntrega', $access)): ?>
                    <a href="<?= url("/entrega") ?>" class="dropdown-item" >
                        Entrega de Produtos
                    </a>
                    <?php endif; ?>
                    <?php if (!empty($access) && in_array(' preco', $access)): ?>
                    <a href="<?= url("/preco") ?>" class="dropdown-item" >
                        Preço
                    </a>
                    <?php endif; ?>
                </div>
            </li>
            <li style="text-align: center">
                <a class="nav-link" href="pedido" >
                    Pedidos & Orçamentos
                </a>
            </li>
        </ul>
        <div class="navbar navbar-right config">
            <ul class="nav navbar">
                <?php if(!empty($access) && (in_array(" login", $access) || in_array(" *", $access))): ?>
                    <li>
                        <a id="login" class="nav-link icon-login" href="<?= url("login") ?>" >
                            <i class="fa fa-id-card" title="Cadastro de Login"></i>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if(!empty($access) && (in_array(" shield", $access) || in_array(" *", $access))): ?>
                    <li>
                        <a id="shield" class="nav-link icon-shield" href="<?= url("seguranca") ?>" >
                            <i class="fa fa-shield" title="Segurança" ></i>
                        </a>
                    </li>
                <?php endif ?>
                <?php if(!empty($access) && (in_array(" config", $access) || in_array(" *", $access))): ?>
                    <li>
                        <a id="config" class="nav-link icon-config" href="<?= url("configuracao") ?>">
                            <i class="fa fa-cog" title="Configuração" ></i>
                        </a>
                    </li>
                <?php endif ?>
                <li>
                    <a id="exit" class="nav-link icon-exit" href="<?= url("sair") ?>" >
                        <i class="fa fa-sign-out" title="Sair" ></i>
                    </a>
                </li>
            </ul>
        </div><!-- navbar rigth-->
    </div><!-- navbar-collapse -->
</nav>
<div class="identification"><i>Usuário:</i> <?= ucfirst($_SESSION["login"]->Logon) ?></div>
