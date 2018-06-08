<?php
namespace com\selfcoders\ejabberdarchiveviewer;

use Twig_Environment;
use Twig_Error_Loader;
use Twig_Error_Runtime;
use Twig_Error_Syntax;
use Twig_Loader_Filesystem;

class Twig
{
    /**
     * @var Twig_Environment
     */
    private static $twig;

    public static function init()
    {
        if (self::$twig !== null) {
            return;
        }

        self::$twig = new Twig_Environment(new Twig_Loader_Filesystem(RESOURCES_ROOT . "/views"));
    }

    /**
     * @param string $name
     * @param array $context
     * @return string
     * @throws Twig_Error_Loader
     * @throws Twig_Error_Runtime
     * @throws Twig_Error_Syntax
     */
    public static function render(string $name, array $context = array())
    {
        self::init();

        return self::$twig->render($name, $context);
    }
}