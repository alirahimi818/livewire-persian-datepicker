<?php

namespace PersianDatepicker\app\Console;

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('vendor:publish', ['--tag' => 'livewire-persian-datepicker', '--force' => true]);
        $this->info("Livewire Persian Datepicker Component published successful. \n path => resources/views/components/persian-datepicker.blade.php");

    }
}
