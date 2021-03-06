<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Util\Utils;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('layouts.app');
    }

    /**
     * Get initial data for Vue.js application
     */
    public function vue()
    {
        $user = Auth::user();

        $homeItems = [
            [
                'name' => trans_choice('strings.users', 2),
                'icon' => 'fa-users',
                'link' => 'users',
            ],
        ];

        $settingsFile = Utils::getSettingsFile();

        $settings = array();

        if (file_exists($settingsFile)) {
            $settings = json_decode(file_get_contents($settingsFile));
        }

        $data = [
            'appName' => config('app.name', 'Laravel'),
            'user' => $user,
            'homePath' => $user->getHomePath(),
            'logo' => image('logo.png'),
            'homeItems' => $homeItems,
            'logoutUrl' => route('logout'),
            'settings' => $settings,
        ];

        return [
            'error' => false,
            'data' => $data
        ];
    }
}
