<?php

namespace alirahimi818\PersianDatepicker;

use Illuminate\Support\ServiceProvider;

class PersianDatepickerServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../resources/views/components/persian-datepicker.blade.php' => resource_path('views/components/persian-datepicker.blade.php'),
        ], 'persian-datepicker');
    }
}
