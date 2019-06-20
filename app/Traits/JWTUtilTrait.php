<?php
namespace App\Traits;

use JWTAuth;

trait JWTUtilTrait
{
    public static function getToken()
    {
        return JWTAuth::decode(JWTAuth::getToken())->toArray();
    }

    public static function getUserId()
    {
        return static::getToken()['user']->id;
    }

    public static function getSub()
    {
        return static::getToken()['sub'];
    }

    public static function isUserAdmin()
    {
        return static::getSub() === 'admin';
    }
}
