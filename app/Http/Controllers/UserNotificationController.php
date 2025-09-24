<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserNotification\UserNotificationIndexResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;

class UserNotificationController extends Controller
{
    public function index(Request $request): Response
    {

        $notifications = UserNotificationIndexResource::collection(
            Auth::user()->notifications()
                ->search($request->search, ['message'])
                ->orderByDesc('id')
                ->cursorPaginate((int) ($request->per_page ?: 100))
        );

        return inertia('UserNotifications/Index', [
            'search' => $request->search,
            'notifications' => inertia()->deepMerge($notifications)->matchOn('data.id'),
        ]);

    }
}
