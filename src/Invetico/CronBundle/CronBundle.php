<?php

namespace Invetico\CronBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CronBundle extends Bundle
{
    public function boot(){}

    public function getAlias()
    {
        return 'cron_bundle';
    }

    public static function getServiceConfiguration()
    {
        return [__DIR__.'/Resources/config/services.xml'];
    }

    public static function getRouteConfiguration()
    {
        return [__DIR__.'/Resources/config/routing/routes.xml'];
    }

}
