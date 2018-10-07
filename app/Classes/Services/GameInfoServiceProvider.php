<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 10/11/2015
 * Time: 10:52 AM
 */

namespace App\Classes\Services;

use App\Classes\GameInfo;
use Illuminate\Support\ServiceProvider;

class GameInfoServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('gameinfo', function ($app) {
            return new GameInfo();
        });
    }
}