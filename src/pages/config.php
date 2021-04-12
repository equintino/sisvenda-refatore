<div id="config">
    <div class="buttons">
        <button class="button btnAction">Adicionar</button>
    </div>
    <div class="table-conf">
    <fieldset class="fieldset pt-3" style="width: 100%">
        <legend>BANCO DE DADOS</legend>
        <table id="tabConf" class="my-table" width="100%" >
            <thead>
                <tr>
                    <th></th>
                    <th>NOME</th>
                    <th>TIPO</th>
                    <th>ENDEREÇO</th>
                    <th>NOME DO BANCO</th>
                    <th>USUÁRIO</th>
                    <th colspan="2"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $localSelected = $config->getConfConnection();
                    foreach($config->getFile() as $local => $params):
                        $active = null;
                        $background = null;
                        $arrow = null;
                        $config->local = $local;
                        if($localSelected === $local) {
                            $active = "*";
                            $arrow = "<i class='fa fa-arrow-right' aria-hidden='true' ></i>";
                            $background = "#c3d2dd";
                        } ?>
                <tr style="background: <?= $background ?>">
                    <td><?= (!empty($arrow) ? $arrow : null) ?></td>
                    <td><?= $active.$local ?></td>
                    <td><?= $config->type() ?></td>
                    <td><?= $config->address() ?></td>
                    <td><?= $config->database() ?></td>
                    <td><?= $config->user() ?></td>
                    <td class="icon-edition"><i class="fa fa-pencil edition"></i></td>
                    <td class="icon-edition"><i class="fa fa-trash delete"></i></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </fieldset>
    </div>
</div>
