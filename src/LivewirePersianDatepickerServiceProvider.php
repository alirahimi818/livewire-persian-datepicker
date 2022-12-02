<?php

namespace Alirahimi\Livewire\Persian\Datepicker;

use alirahimi\LivewirePersianDatepicker\app\Console\PublishComponent;
use Illuminate\Support\ServiceProvider;

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
        $this->commands([
            PublishComponent::class,
        ]);

        $this->publishes([
            __DIR__ . '/../resources/views/components/persian-datepicker.blade.php' => resource_path('views/components/persian-datepicker.blade.php'),
            __DIR__ . '/../resources/js/livewire-datepicker-datepicker.js' => resource_path('js/livewire-datepicker-datepicker.js'),
        ], 'livewire-persian-datepicker');
    }
}