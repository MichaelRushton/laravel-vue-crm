<?php

use App\Jobs\ForceDeleteCustomers;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new ForceDeleteCustomers)->daily();
