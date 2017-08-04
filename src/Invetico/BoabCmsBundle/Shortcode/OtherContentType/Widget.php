<?php

namespace Invetico\BoabCmsBundle\Shortcode\OtherContentType;


class Widget
{
    private $contentType;

    private $recordLimit;

    private $excludeIds;

    private $view;


    public function __construct($attr)
    {
        $this->contentType = $attr['contenttype'];
        $this->recordLimit = $attr['records'];
        $this->view = $attr['view'];
        $this->excludeIds = $attr['excludeids'];
    }

    public function getContentTypeId()
    {
        return $this->contentType;
    }

    public function getRecordLimit()
    {
        return $this->recordLimit;
    }

    public function getView()
    {
        return $this->view;
    }

    public function getExcludeIds()
    {
        return explode(',',$this->excludeIds);
    }
}
