<?php

namespace Customtest\App\Http\Controllers\Web;

use framework\Http\Request;
use framework\Http\Controller;
use framework\Http\View;
use framework\SpiralConnecter\SpiralDB;
use framework\Support\ServiceProvider;
use Spiral;

class WelcomeController extends Controller
{
    public function index(array $vars)
    {
        echo view("html/welcome")->render();
    }

    public function create(array $vars)
    {
        SpiralDB::title('member')->get();
    }

    public function store(array $vars)
    {
        //
    }

    public function show(array $vars)
    {
    }

    public function edit(array $vars)
    {
        //
    }

    public function update(array $vars)
    {
        //
    }

    public function destroy(array $vars)
    {
        //
    }
}
