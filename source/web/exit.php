<?php

require __DIR__ . "/../../vendor/autoload.php";

(new Source\Core\Session())->destroy();

header("Location: ../../index.php");
