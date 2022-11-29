<?php

namespace App\Http\Controllers;

use App\Services\HomeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\StatusCode;

class HomeController extends Controller
{
    protected $homeService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $infoUser = 2;

        return view('home', [
            'infoUser' => $infoUser
        ]);
    }

    public function getUserInfo()
    {
        $infoUser =  2;

        return response([
            'infoUser' => $infoUser
        ], StatusCode::OK);
    }
}