<?php

namespace AliRahimi\LivewirePersianDatepicker\Presets;

class Tailwindcss
{

    /**
     * Install the preset.
     *
     * @return void
     */
    public static function install()
    {
        static::updateWebpackConfiguration();
        static::updateTailwindConfiguration();
        static::updateSass();
        static::updateBootstrapping();
    }

    /**
     * Update the Webpack configuration.
     *
     * @return void
     */
    protected static function updateWebpackConfiguration()
    {
        copy(__DIR__.'/tailwindcss-stubs/webpack.mix.js', base_path('webpack.mix.js'));
    }

    /**
     * Update the Tailwind configuration.
     *
     * @return void
     */
    protected static function updateTailwindConfiguration()
    {
        copy(__DIR__.'/tailwindcss-stubs/tailwind.config.js', base_path('tailwind.config.js'));
    }

    /**
     * Update the Sass files for the application.
     *
     * @return void
     */
    protected static function updateSass()
    {
        copy(__DIR__.'/tailwindcss-stubs/app.scss', resource_path('sass/app.scss'));
    }

    /**
     * Update the bootstrapping files.
     *
     * @return void
     */
    protected static function updateBootstrapping()
    {
        copy(__DIR__.'/tailwindcss-stubs/bootstrap.js', resource_path('js/bootstrap.js'));
    }

}
