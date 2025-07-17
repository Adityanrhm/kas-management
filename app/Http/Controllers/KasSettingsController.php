<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KasSettingsController extends Controller
{
    public function index()
    {

        return view('modules.kas-settings.kas_settings_view');
    }
}
