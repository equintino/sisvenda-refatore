<!-- <script>var identificacao = 'ACESSO ÀS TELAS';</script> -->
<div class="shield">
    <h5 class="mt-4" align="center">SEGURANÇA</h5>
    <div>
        <div class="group">
            <fieldset class="fieldset">
                <legend>Grupos</legend>
                <?php foreach($groups as $group):
                    $active = ($group->id === $groupId ? "active" : null); ?>
                    <p class="btnAction <?= $active ?>"><?= $group->name ?></p>
                <?php endforeach ?>
            </fieldset>
            <button class="button save" style="float: right">Adicionar Grupo</button>
            <button class="button cancel mr-1" style="float: right; cursor: pointer">Excluir Grupo</button>
        </div>
        <div class="middle">
        </div>
        <div class="screen">
            <fieldset class="fieldset">
                <legend>Telas<span></span></legend>
                <?php foreach($screens as $screen): ?>
                    <span class="mr-2"><i class="fa fa-times" style="color: red"></i> <?= $screen ?></span>
                    <?php endforeach ?>
            </fieldset>
            <button class="button save" style="float: right" >Gravar</button>
        </div>
    </div>
</div>
