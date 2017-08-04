<?php

namespace Invetico\BoabCmsBundle\Entity;

interface PageInterface
{
    public function setParentId($parentId);

    public function getParentId();
}
