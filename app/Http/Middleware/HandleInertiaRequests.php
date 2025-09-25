<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;
use Illuminate\Http\Request;
use App\Actions\Tec\AlertsData;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function share(Request $request)
    {
        $settings = get_public_settings();
        $langFiles = json_decode(file_get_contents(lang_path('languages.json')));

        return array_merge(parent::share($request), [
            'demo'      => demo(),
            'settings'  => $settings,
            'language'  => app()->getLocale(),
            'alerts'    => AlertsData::items(),
            'languages' => $langFiles->available,
            'logo'      => $settings && ($settings['logo'] ?? null) ? $settings['logo'] : asset('storage/logo.svg'),
            'flash'     => [
                'error'   => session('error'),
                'message' => session('message'),
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }

    public function version(Request $request)
    {
        return parent::version($request);
    }
}
