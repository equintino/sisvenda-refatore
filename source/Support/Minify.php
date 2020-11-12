<?php

if(strpos(url(), "localhost")) {
    /**
     * css
     */
    $minCSS = new MatthiasMullie\Minify\CSS();
    ///$minCSS->add(__DIR__ . "/../../shared/styles/bootstrap.min.css.map");
    $minCSS->add(__DIR__ . "/../../shared/styles/datatables.css");
    $minCSS->add(__DIR__ . "/../../shared/styles/style-login.css");
    $minCSS->add(__DIR__ . "/../../shared/styles/style-security.css");

     /**
      * theme
      */
    $cssDir = scandir(__DIR__ . "/../../themes/" . CONF_VIEW_THEME . "/asset/css");
    foreach($cssDir as $css) {
        $cssFiles = __DIR__ . "/../../themes/" . CONF_VIEW_THEME . "/asset/css/{$css}";
        if(is_file($cssFiles) && pathinfo($cssFiles)["extension"] === "css") {
            $minCSS->add($cssFiles);
        }
    }

    /**
     * MinifyCss
     */
    $minCSS->minify(__DIR__ . "/../../themes/" . CONF_VIEW_THEME . "/asset/style.css");

    /**
     * js
     */
    $minJS = new MatthiasMullie\Minify\JS();
    $minJS->add(__DIR__ . "/../../shared/scripts/datatables.js");
    //$minJS->add(__DIR__ . "/../../shared/scripts/bootstrap.min.js.map");
    $minJS->add(__DIR__ . "/../../shared/scripts/datatables.js");
    $minJS->add(__DIR__ . "/../../shared/scripts/functions.js");
    $minJS->add(__DIR__ . "/../../shared/scripts/script.js");
    $minJS->add(__DIR__ . "/../../shared/scripts/bootbox.js");
    //$minJS->add(__DIR__ . "/../../shared/scripts/jquery.js");
    $minJS->add(__DIR__ . "/../../shared/scripts/script-login.js");
    $minJS->add(__DIR__ . "/../../shared/scripts/script-security.js");

    /**
     * theme
     */
    $jsDir = scandir(__DIR__ . "/../../themes/" . CONF_VIEW_THEME . "/asset/js");
    foreach($jsDir as $js) {
        $jsFiles = __DIR__ . "/../../themes/" . CONF_VIEW_THEME . "/asset/js/{$js}";
        if(is_file($jsFiles) && pathinfo($jsFiles)["extension"] === "js") {
            $minJS->add($jsFiles);
        }
    }

    /**
     * MinifyCss
     */
    $minJS->minify(__DIR__ . "/../../themes/" . CONF_VIEW_THEME . "/asset/scripts.js");
}
