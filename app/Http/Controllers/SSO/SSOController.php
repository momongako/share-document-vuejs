<?php

namespace App\Http\Controllers\SSO;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class SSOController extends Controller
{
    public function getLogin(Request $request)
    {
        $api_key = config('auth.api_key');
        $api_key_private = config('auth.api_key_private');
        $secret = Hash('sha256', $api_key.$api_key_private.time()) . '_' . time();

        return redirect(config('auth.redirect_url_login') . $api_key .'&secret='.$secret);
    }

    public function connectUser(Request $request)
    {
        $result = Http::withHeaders([
            "Accept" => "application/json",
            "Authorization" => "Bearer " . $request->access_token
        ])->get(config('auth.base_redirect_url'));

        $response = $result->json();
        $systems = $response['systems'];
        $url = config('auth.base_url');
        $userCompany = !empty($response['customer']) ? $response['customer']['name'] : '';
        $userDepartment = '';
        foreach ($systems as $k => $v) {
            if (!empty($v['url']) && $v['url'] == $url) {
                $user = User::where('email', $response['email'])->first();
                if (!$user) {
                    $user = User::create([
                        'name' => $response['full_name'],
                        'email' => $response['email'],
                        'image' => $response['avatar'] ?? '',
                        'is_admin' => NOT_ADMIN,
                        'user_company' => $userCompany,
                        'user_department' => $userDepartment
                    ]);
                }
                Auth::login($user);
                return redirect(route("home"));
            }
        }
    }
}
