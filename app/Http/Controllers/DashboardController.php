<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserNotification\UserNotificationIndexResource;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;

class DashboardController extends Controller
{
    public function show(): Response
    {

        return inertia('Dashboard/Show', [
            'notifications' => UserNotificationIndexResource::collection(
                Auth::user()->notifications()
                    ->orderByDesc('id')
                    ->limit(10)
                    ->get()
            ),
        ]);

    }
}
