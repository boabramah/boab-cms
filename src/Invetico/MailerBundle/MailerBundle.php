<?php

namespace Invetico\MailerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Invetico\MailerBundle\DependencyInjection\Compiler\AppMailerDependenciesPass;

class MailerBundle extends Bundle
{

    public function boot(){}

    public function getAlias()
    {
        return 'arrow_mailer_bundle';
    }

    public static function getServiceConfiguration()
    {
        return [__DIR__.'/Resources/config/services.xml'];
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new AppMailerDependenciesPass());
    }

}
