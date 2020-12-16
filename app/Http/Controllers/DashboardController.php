<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use App\Models\Prize;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        return view('dashboard.index',[
            'phones_count' => Phone::active()->count(),
            'prizes_count' => Prize::active()->count()
        ]);
    }
}
