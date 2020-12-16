<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Setting\SettingRepository;

class SettingController extends Controller
{
    public function __construct(SettingRepository $repository){
        $this->middleware('permission:Setting Read');
        $this->middleware('permission:Setting Edit', ['only' => ['store']]);
        
        $this->repository = $repository;
    }

    public function index()
    {
        return view('setting.index');
    }

    public function store(Request $request)
    {
        if ($this->repository->createOrUpdate($request->except('_token'))) {
            return redirect()->route('settings.index')
                            ->withSuccess('You have just updated the setting successfully');
        }
        return $this->redirectBackWithErrors();
    }
}
