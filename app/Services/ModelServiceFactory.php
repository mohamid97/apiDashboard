<?php

namespace App\Services;


class ModelServiceFactory
{
    protected static array $map = [
        'user' => \App\Services\User\UserService::class,
        'lang' => \App\Services\Lang\LangService::class,
        'slider'=>\App\Services\Slider\SliderService::class,
        'category'=>\App\Services\Category\CategoryService::class,
        'about'=>\App\Services\About\AboutService::class,
        'contact'=>\App\Services\Contact\ContactService::class,
        'location'=>\App\Services\Location\LocationService::class,
        'maincontact'=>\App\Services\Maincontact\MaincontactService::class,
        'social'=>\App\Services\Social\SocialService::class,
        'permission'=>\App\Services\Permission\PermissionService::class,
        'role'=>\App\Services\Role\RoleService::class,
        'event'=>\App\Services\Event\EventService::class,
        'blog'=>\App\Services\Blog\BlogService::class,
        'client'=>\App\Services\Client\ClientService::class,
        'ourwork'=>\App\Services\Ourwork\OurworkService::class,
        'feedback'=> \App\Services\Feedback\FeedbackService::class,
        'achivement'=>\App\Services\Achivement\AchivementService::class,
        'service'=>\App\Services\Service\ServiceService::class,
        'coupon'=>\App\Services\Coupon\CouponService::class,
        'product'=>\App\Services\Product\ProductService::class,
        'branch'=>\App\Services\Branch\BranchService::class,
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