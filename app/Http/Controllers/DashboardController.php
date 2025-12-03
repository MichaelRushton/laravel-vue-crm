<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Inertia\Response;

class DashboardController extends Controller
{
    public function show(): Response
    {
        return inertia('Dashboard/Show');
    }
}
