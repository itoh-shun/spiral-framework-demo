<?php

namespace Customtest;

use framework\Application;

class CustomtestApplication extends Application
{
    public function __construct()
    {
        config_path("Customtest/config/app");
        parent::__construct();
    }

    public function boot()
    {
    }
}
