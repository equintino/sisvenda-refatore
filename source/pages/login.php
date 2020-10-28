<link rel="stylesheet" href="../web/css/style-login.css" />
<?php
    $companyId = filter_input(INPUT_GET, "companyId", FILTER_SANITIZE_STRIPPED);
    $companys = (new Source\Models\Company())->all();
    $users = (new Source\Models\User())->find(["IDEmpresa" => $companyId]);
    $groups = (new Source\Models\Group())->all();
    echo "<script>var companyId = '" . $companyId . "' </script>"; ?>
<div class="container">
    <div class="header">
        <div class="select-company">
            <label>EMPRESA:</lable>
            <select class="form-input" name="NomeFantasia">
                <option value=""></option>
                <?php foreach($companys as $company): ?>
                <option value="<?= $company->ID ?>" <?= ($company->ID === $companyId ? "selected" : null) ?> ><?= $company->NomeFantasia ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="buttons">
            <button class="button btnAction">Adicionar</button>
            <button class="button btnAction">Listar</button>
        </div>
        <div></div>
    </div>
    <!-- Edição -->
    <div id="exhibition" >
        <fieldset class="fieldset p-3" >
            <legend>LISTA DE USUÁRIOS</legend>
            <table id="tabList" class="my-table" width="100%" >
                <thead>
                    <tr>
                        <th>NOME</th>
                        <th>LOGIN</th>
                        <th>GRUPO</th>
                        <th>ATIVO</th>
                        <th>EDITAR</th>
                        <th>EXCLUIR</th>
                        <th>RESETAR SENHA</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(isset($users)):
                        foreach($users as $user): ?>
                            <tr>
                                <td><?= $user->Nome ?></td>
                                <td><?= $user->Logon ?></td>
                                <td><?= (!empty($user->getGroup()) ? $user->getGroup()->name : null) ?></td>
                                <td><?= $user->Visivel == 1 ? "SIM" : "NÃO"; ?></td>
                                <td title="Edita" data-id="<?= $user->id ?>" data="<?= $user->Logon ?>" ><i class="fa fa-pencil" ></i></td>
                                <td title="Exclui" data-id="<?= $user->id ?>" data="<?= $user->Logon ?>" ><i class="fa fa-times"></i></td>
                                <td title="Reseta" data-id="<?= $user->id ?>" data="<?= $user->Logon ?>" ><i class="fa fa-key "></i></td>
                            </tr>
                    <?php
                        endforeach;
                    endif ?>
                </tbody>
            </table>
        </fieldset>
    </div><!-- editar -->
</div><!-- cadLogin -->
<script type="text/javascript" src="../web/js/script-login.js"></script>
