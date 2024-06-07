<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [
            'title' => 'Home',
            // 'urljsonalldatakeuangan' => base_url($this->urlclass) . '/jsonalldatakeuangan',
            // 'urljsoniddatakeuangan' => base_url($this->urlclass) . '/jsoniddatakeuangan',
            // 'urljsoncreatedatakeuangan' => base_url($this->urlclass) . '/createdatakeuangan',
            // 'urljsonupdatedatakeuangan' => base_url($this->urlclass) . '/updatedatakeuangan',
            // 'urljsondeletedatakeuangan' => base_url($this->urlclass) . '/deletedatakeuangan',
        ];
        // return view('home', $data);
        return view('homebaru', $data);
    }
}
