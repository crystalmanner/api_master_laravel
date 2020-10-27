<?php
namespace FreshinUp\ActivityApi;

class ActivityApi
{
    public static $packagePath = 'vendor/freshinup/activity-api';

    /**
     * The version.
     */
    public static function getVersion()
    {
        $package = self::readPackageJSON(self::$packagePath . '/composer.json');
        return $package['version'];
    }

    /**
     * Util for converting composer.json into a PHP Array
     * @param $path string The path to the composer.json file
     * @return mixed
     */
    public static function readPackageJSON(string $path)
    {
        $jsonString = file_get_contents(base_path($path));
        return json_decode($jsonString, true);
    }
}
