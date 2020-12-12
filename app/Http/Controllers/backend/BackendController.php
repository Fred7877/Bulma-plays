<?php


namespace App\Http\Controllers\backend;


use Illuminate\Support\Facades\View;

class BackendController
{

    public function index()
    {
        return View::make('backend.main');
    }
}
