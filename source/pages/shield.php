<link rel="stylesheet" href="<?= theme("asset/css/style-security.css") ?>" />
<script>var identificacao = 'ACESSO ÀS TELAS';</script>
<div class="container">
    <h5 class="mt-4" align="center">SEGURANÇA</h5>
    <div>
        <div class="group">
            <fieldset >
                <legend>Grupos</legend>
                <?php foreach($groups as $group): ?>
                    <p class="btnAction"><?= $group->name ?></p>
                <?php endforeach ?>
            </fieldset>
            <button class="button save" style="float: right">Adicionar Grupo</button>
            <button class="button cancel mr-1" style="float: right; cursor: pointer">Excluir Grupo</button>
        </div>
        <div class="middle">
        </div>
        <div class="screen">
            <fieldset>
                <legend>Telas<span></span></legend>
                <?php foreach($screens as $screen):
                    if($screen !== "home"): ?>
                    <p><i class="fa fa-times" style="color: red"></i> <?= $screen ?></p>
                    <?php endif; endforeach ?>
            </fieldset>
            <button class="button save" style="float: right" >Gravar</button>
        </div>
    </div>
</div><!-- container -->
<script type="text/javascript" src="<?= theme("asset/js/script-security.js") ?>"></script>
