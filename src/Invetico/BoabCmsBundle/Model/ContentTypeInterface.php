<?php

namespace Invetico\BoabCmsBundle\Model;

interface ContentTypeInterface
{
    public function getTypeId();

    public function getValidator();

    public function getDescription();
}
