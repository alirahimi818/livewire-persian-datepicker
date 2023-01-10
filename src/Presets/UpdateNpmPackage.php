<?php

namespace AliRahimi\LivewirePersianDatepicker\Presets;

use Illuminate\Support\Arr;

class UpdateNpmPackage
{

    /**
     * Install the preset.
     *
     * @return void
     */
    public static function install()
    {
        static::updatePackages();
    }

    /**
     * Update the given package array.
     *
     * @param array $packages
     * @return array
     */
    protected static function updatePackageArray(array $packages)
    {
        return array_merge([
            '@tailwindcss/forms' => '^0.5.0',
            '@tailwindcss/typography' => '^0.5.0',
            'tailwindcss' => '^3.0.0',
            'alpinejs' => '^3.0.6',
            'jalali-moment' => '^3.3.11',
        ], Arr::except($packages, [
            'bootstrap',
            'popper.js',
            'jquery',
        ]));
    }

    /**
     * Update the "package.json" file.
     *
     * @param bool $dev
     * @return void
     */
    protected static function updatePackages($dev = true)
    {
        if (!file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = static::updatePackageArray(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);
        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }

}
