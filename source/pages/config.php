<?php $config = $config(); ?>

<div class="container mt-4">
    <h1 class="subtitle">SELECIONE ABAIXO A FORMA DE CONEXÃO COM O BANCO:</h1>
    <table id="tabConf" class="my-table" width="100%" >
        <thead>
            <tr>
                <th>NOME</th>
                <th>TIPO</th>
                <th>ENDEREÇO</th>
                <th>NOME DO BANCO</th>
                <th>USUÁRIO</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $localSelected = $config->getConfConnection();
                foreach($config->getFile() as $local => $params):
                    $config->local = $local; 
                    $ativa = ($localSelected === $local ? "*" : null) ?>
            <tr>
                <td><?= $ativa.$local ?></td>
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
</div>
