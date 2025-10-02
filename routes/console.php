<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('customers:delete-trashed', ['--before="'.today()->subDays(7).'"'])->daily();
