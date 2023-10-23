<?php

namespace Customtest;

use framework\Application;
use framework\SpiralConnecter\SpiralDB;
use SiValidator2\SiValidator2;

class CustomtestApplication extends Application
{
    public function __construct()
    {
        config_path("Customtest/config/app");
        parent::__construct();
    } 

    public function boot()
    {
        SiValidator2::setLanguage(config('locale','ja'));
    }
}
