<?php

namespace AliRahimi\LivewirePersianDatepicker\Commands;

use AliRahimi\LivewirePersianDatepicker\Presets\UpdateNpmPackage;
use Illuminate\Console\Command;

class PublishComponent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'livewire:persian-datepicker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish livewire persian datepicker';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        UpdateNpmPackage::install();

        $this->call('vendor:publish', [
                '--provider' => "AliRahimi\LivewirePersianDatepicker\LivewirePersianDatepickerServiceProvider",
                '--tag' => 'livewire-persian-datepicker',
                '--force' => true]
        );

        exec('npm install');

        $this->info("Livewire Persian Datepicker Component published successful.\npath => resources/views/components/persian-datepicker.blade.php");

    }
}
