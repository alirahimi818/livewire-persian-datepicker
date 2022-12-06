<?php

namespace AliRahimi\LivewirePersianDatepicker\Presets;

use Illuminate\Support\Arr;

class Tailwindcss
{

    /**
     * Install the preset.
     *
     * @return void
     */
    public static function install()
    {
        static::updatePackages();
        static::updateWebpackConfiguration();
        static::updateTailwindConfiguration();
        static::updateSass();
        static::updateBootstrapping();
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

    /**
     * Update the Webpack configuration.
     *
     * @return void
     */
    protected static function updateWebpackConfiguration()
    {
        copy(__DIR__ . '/tailwindcss-stubs/webpack.mix.js', base_path('webpack.mix.js'));
    }

    /**
     * Update the Tailwind configuration.
     *
     * @return void
     */
    protected static function updateTailwindConfiguration()
    {
        copy(__DIR__ . '/tailwindcss-stubs/tailwind.config.js', base_path('tailwind.config.js'));
    }

    /**
     * Update the Sass files for the application.
     *
     * @return void
     */
    protected static function updateSass()
    {
        copy(__DIR__ . '/tailwindcss-stubs/app.css', resource_path('css/app.css'));
    }

    /**
     * Update the bootstrapping files.
     *
     * @return void
     */
    protected static function updateBootstrapping()
    {
        copy(__DIR__ . '/tailwindcss-stubs/bootstrap.js', resource_path('js/bootstrap.js'));
    }

}
