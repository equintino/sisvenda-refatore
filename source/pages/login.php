    <header class="header mt-5">
        <div class="row">
            <div class="col select-company">
                <label>EMPRESA:</lable>
                <select class="form-input" name="NomeFantasia">
                    <option value=""></option>
                    <?php foreach($companys as $company): ?>
                    <option value="<?= $company->ID ?>" <?= ($company->ID === $companyId ? "selected" : null) ?> >
                        <?= $company->NomeFantasia ?>
                    </option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="col buttons">
                <button class="button btnAction">Adicionar</button>
                <button class="button btnAction">Listar</button>
            </div>
        </div>
    </header>
    <main id="exhibition" >
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
                    <?php if(isset($users)):
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
                    <?php endforeach;
                    endif ?>
                </tbody>
            </table>
        </fieldset>
    </main>
