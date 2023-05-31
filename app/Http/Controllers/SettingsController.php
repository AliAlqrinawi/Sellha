<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SettingsController extends Controller
{
    public function index()
    {
        if (!Gate::allows('setting-view')) {
            abort(500);
        }
        $settings=Setting::where('group','general')->orderBy('id')->get();
        return view('dashboard.views-dash.setting.index',compact('settings'));
    }

    public function social()
    {
        if (!Gate::allows('setting-view')) {
            abort(500);
        }
        $settings=Setting::where('group','social')->orderBy('id')->get();
        return view('dashboard.views-dash.setting.social',compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token' , '_method']);
        foreach ($data as $k => $v) {
            $this->update_setting([
                'key' => $k,
                'value' => $v
            ], $k);
        }
        return redirect()->back()->with('success', __('Updated successfully'));
    }

    public function update_setting($data,$key){
        return Setting::where('key',$key)->update($data);
    }
}
