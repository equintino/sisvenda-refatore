<style>
    .btn-list-clients {
        float: right;
        margin-top: 10px;
    }

    .btn-list-clients button {
        cursor: pointer;
    }

    #tabList .selected {
        font-weight: bolder;
        //color: white;
    }

    #tabList tbody tr {
        cursor: pointer;
    }
    /* .selected {
        background: blue;
    } */
</style>
<script>
    $(".btn-list-clients button").on("click", function() {
        if($(this).text() === "Cancelar") {
            $("#boxe2_main, #mask2_main").hide();
        }
    });
	$("#tabList tr").on("click", function() {
        $("#tabList tr").removeClass("selected");
	    $(this).addClass("selected");
	});
</script>
<h6>Selecione um nome:</h6>
<table id="tabList" class="table-striped compact display nowrap" width="100%" >
    <thead>
        <tr>
            <th>NOME</th>
            <th>CNPJ/CPF</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($datas as $data): ?>
        <tr>
            <input type="hidden" name="RasSocial" value="<?= ($data->RasSocial ?? null) ?>" />
            <input type="hidden" name="CNPJ" value="<?= ($data->CNPJ ?? null) ?>"/>
            <input type="hidden" name="Nome" value="<?= ($data->Nome ?? null) ?>"/>
            <input type="hidden" name="CPF" value="<?= ($data->CPF ?? null) ?>"/>
            <td><?= ($data->RasSocial ?? $data->Nome) ?></td>
            <td><?= ($data->CNPJ ?? $data->CPF) ?></td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
<div class="btn-list-clients">
    <button class="btn-mx btn-default" id="cancela">Cancelar</button>
    <button class="btn-mx btn-success ml-1" id="seleciona">Selecionar</button>
</div>
