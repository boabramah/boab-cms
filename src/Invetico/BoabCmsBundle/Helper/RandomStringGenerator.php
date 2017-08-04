<?php

namespace Invetico\BoabCmsBundle\Helper;

trait RandomStringGenerator
{
    private function getActivationToken()
    {
        return md5(openssl_random_pseudo_bytes(32));
    }
}