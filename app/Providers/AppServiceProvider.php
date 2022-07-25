<?php

namespace App\Providers;

use App\Models\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(Schema::hasTable('configs')) {
            $config = Config::get();
            foreach ($config as $value) {
                $result[$value['config_title']] = $value['value'];
            }
            if(!empty($result)){
                View::share('setting', $result);
            }
            date_default_timezone_set("Asia/Dhaka");
        }
    }
}
