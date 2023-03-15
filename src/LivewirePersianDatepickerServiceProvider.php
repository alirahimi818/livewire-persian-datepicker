<?php

namespace AliRahimi\LivewirePersianDatepicker;

use AliRahimi\LivewirePersianDatepicker\Commands\PublishComponent;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;

class LivewirePersianDatepickerServiceProvider extends ServiceProvider
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
        $this->publishes([
            __DIR__ . '/../resources/views/components/persian-datepicker.blade.php' => resource_path('views/components/persian-datepicker.blade.php'),
            __DIR__ . '/../resources/js/livewire-datepicker-datepicker.js' => resource_path('js/livewire-datepicker-datepicker.js'),
        ], 'livewire-persian-datepicker');

        $this->commands([
            PublishComponent::class,
        ]);
    }
}
