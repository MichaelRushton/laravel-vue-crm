<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('users:delete-revisions')->daily();
Schedule::command('users:delete-impersonations')->daily();
Schedule::command('sign-ins:delete')->daily();
Schedule::command('password-resets:delete')->daily();
