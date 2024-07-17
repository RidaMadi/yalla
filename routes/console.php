<?php

//use App\Console\Commands\ExampleCommand;
//use App\Jobs\ExampleJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    dd('hey');
})->daily();

//Schedule::command(ExampleCommand::class)->daily();

//Schedule::command('app:example-command')->daily();

//Schedule::job(ExampleJob::class)->daily();
