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
        if(defined('IS_LOCAL')){
            config_path("../.local_config");
        }
        parent::__construct();
    } 

    public function boot()
    {
        SiValidator2::setLanguage(config('locale','ja'));
        if(defined('IS_LOCAL')){
            SpiralDB::setToken(config('spiral.token'),config('spiral.secret'));
        }
    }
}
