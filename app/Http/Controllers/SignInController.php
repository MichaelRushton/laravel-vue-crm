<?php

namespace App\Http\Controllers;

use App\Http\Resources\SignIn\SignInIndexResource;
use App\Models\SignIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Response;

class SignInController extends Controller
{
    public function index(Request $request): Response
    {

        Gate::authorize('viewAny', SignIn::class);

        $sign_ins = SignInIndexResource::collection(
            SignIn::select('sign_ins.*', 'users.first_name', 'users.last_name')
                ->leftJoin('users', 'sign_ins.user_id', 'users.id')
                ->search($request->search, ['sign_ins.email', 'users.first_name', 'users.last_name', 'users.email'])
                ->orderByDesc('sign_ins.created_at')
                ->orderByDesc('sign_ins.id')
                ->cursorPaginate((int) ($request->per_page ?: 100))
        );

        return inertia('SignIns/Index', [
            'search' => $request->search,
            'sign_ins' => inertia()->deepMerge($sign_ins)->matchOn('data.id'),
        ]);

    }
}
