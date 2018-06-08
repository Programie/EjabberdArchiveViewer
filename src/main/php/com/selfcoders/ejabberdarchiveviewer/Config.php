<?php
namespace com\selfcoders\ejabberdarchiveviewer;

use com\selfcoders\pini\Pini;

class Config extends Pini
{
    /**
     * @var Config
     */
    private static $instance;

    /**
     * @return Config
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self(RESOURCES_ROOT . "/config.ini");
        }

        return self::$instance;
    }

    /**
     * @param string $section
     * @param string $property
     * @param mixed|null $defaultValue
     * @return mixed|null
     */
    public static function getValue(string $section, string $property, $defaultValue = null)
    {
        $sectionInstance = self::getInstance()->getSection($section);

        if ($sectionInstance === null) {
            return $defaultValue;
        }

        return $sectionInstance->getPropertyValue($property, $defaultValue);
    }
}