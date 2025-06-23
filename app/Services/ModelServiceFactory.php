<?php

namespace App\Services;


class ModelServiceFactory
{
    protected static array $map = [
        'user' => \App\Services\User\UserService::class,
    ];

    public static function make(string $modelName)
    {
        $modelName = strtolower($modelName);
        $serviceClass = self::$map[$modelName] ?? null;

        if (!$serviceClass || !class_exists($serviceClass)) {
            throw new \Exception("Service not found for model: $modelName");
        }

        return app($serviceClass);
    }


    
}