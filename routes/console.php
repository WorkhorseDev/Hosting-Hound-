<?php

use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
  WebsiteController::verifyRenewalDates();
})->everyMinute();

