<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Http\Resources\Auth\ShowAuthResource;
use App\Http\Resources\User\MenuResource;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'app_name' => config('app.name'),
            'flash' => session('flash'),
            ...$request->user() ? [
                'auth' => new ShowAuthResource($request->user()),
                'menu' => new MenuResource($request->user()),
                'is_impersonated' => (bool) session('impersonated_by'),
            ] : [],
        ];
    }
}
