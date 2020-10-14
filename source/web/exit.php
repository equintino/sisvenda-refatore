<?php

require __DIR__ . "/../../vendor/autoload.php";

(new Core\Session())->destroy();

header("Location: ../../index.php");
