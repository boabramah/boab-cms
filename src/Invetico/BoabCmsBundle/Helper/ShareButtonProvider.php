<?php

namespace Bundle\PageBundle\Helper;

class ShareButtonProvider
{
    private $providers = array();

    public function __contsruct() {}

    public function addProvider($provider, $callback)
    {
        if (!isset($this->providers[$provider])) {
            $this->providers[$provider] = $callback;
        }
    }

    public function getProviders()
    {
        return $this->providers;
    }

}
