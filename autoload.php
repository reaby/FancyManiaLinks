<?php

/**
 * FancyManiaLinks - ManiaLink Generator Framework
 *
 * @author    steeffeen <mail@steeffeen.com>
 * @version   2.1.0-dev
 * @link      http://github.com/steeffeen/FancyManiaLinks
 * @copyright FancyManiaLinks Copyright © 2017 Steffen Schröder
 * @license   http://www.gnu.org/licenses/ GNU General Public License, Version 3
 */

if (!defined('FML_PATH')) {
    /**
     * @const FML_PATH Installation directory of FancyManiaLinks
     */
    define('FML_PATH', __DIR__ . DIRECTORY_SEPARATOR);
}
if (!defined('FML_VERSION')) {
    /**
     * @const FML_VERSION Installed version of FancyManiaLinks
     */
    define('FML_VERSION', '2.1.0-dev');
}

/*
 * Autoload function that loads FML class files on demand
 */
if (!defined('FML_AUTOLOAD_DEFINED')) {
    define('FML_AUTOLOAD_DEFINED', true);
    spl_autoload_register(function ($className) {
        $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        $filePath  = FML_PATH . $classPath . '.php';
        if (file_exists($filePath)) {
            require_once $filePath;
        }
    });
}
