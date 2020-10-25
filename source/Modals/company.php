<?php

require __DIR__ . "/../../vendor/autoload.php";

$companys = (new Models\Company())->all(); ?>

<select name="companyId">
    <option value=""></option>
<?php foreach($companys as $company): ?>
    <option value="<?= $company->ID ?>"><?= $company->NomeFantasia ?></option>
<?php endforeach; ?>
</select>
