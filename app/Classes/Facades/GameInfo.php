<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 10/11/2015
 * Time: 10:47 AM
 */

namespace App\Classes\Facades;

use Illuminate\Support\Facades\Facade;

class GameInfo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'gameinfo';
    }
}