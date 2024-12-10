<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\WebSetting;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;


class WebSettingController extends Controller
{
    use LogsActivity;
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {
        return view('dashboard.setting.index', [
            'user' => $request->user(),
            'title' => __('text-ui.controller.web-setting-index.title'),
            'setting' => WebSetting::first(),
            'roles' => Role::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'web_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'web_favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'web_title' => 'nullable',
            'web_description' => 'nullable',
            'web_keywords' => 'nullable',
            'web_address' => 'nullable',
            'web_author' => 'nullable',
            'web_phone' => 'nullable',
            'web_email' => 'nullable|email',
            'web_default_user_role' => 'required|exists:roles,id',
        ]);

        $setting = WebSetting::findOrFail($id);

        if ($request->hasFile('web_logo')) {
            $path = $request->file('web_logo')->store('web-setting', 'public');

            if ($setting->web_logo) {
                Storage::disk('public')->delete($setting->web_logo);
            }

            $validatedData['web_logo'] = $path;
        }

        if ($request->hasFile('web_favicon')) {
            $path = $request->file('web_favicon')->store('web-setting', 'public');

            if ($setting->web_favicon) {
                Storage::disk('public')->delete($setting->web_favicon);
            }

            $validatedData['web_favicon'] = $path;
        }

        $setting->update($validatedData);
        return Redirect::route('settings.index')->with('success', __('text-ui.controller.web-setting-update.success'));
    }

    /**
     * Delete the user's account.
     */
}
