<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [

            'auth' => function () use ($request) {
                return [
                    'user' => $request->user() ? [
                        'id' => $request->user()->id,
                        'email' => $request->user()->email,
                        'name' => $request->user()->name,
                        'ofic_name' =>  Auth::guard('admin')->check() ? $request->user()->ofic_name : null,
                        'rol_name' =>  Auth::guard('admin')->check() ? $request->user()->rol_name : null,
                        'ofic_id' =>  Auth::guard('admin')->check() ? $request->user()->ofic_id : null,
                        'pers_id' =>  Auth::guard('admin')->check() ? $request->user()->pers_id : null,
                    ] : null,
                ];
            },

            'flash' => [
                'message' => fn () => $request->session()->get('message'),
                'success' => fn () => $request->session()->get('success'),
                'data' => fn () => $request->session()->get('data'),
            ],
        ]);
    }
}
