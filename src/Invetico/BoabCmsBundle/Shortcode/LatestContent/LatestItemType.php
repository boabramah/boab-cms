<?php

namespace Invetico\BoabCmsBundle\Shortcode\LatestContent;

class LatestItemType
{
    private $listView;
    private $contentTypeId;
    private $widgetTitle;
    private $records;


    public function __construct($attr)
    {
        $this->listView = $attr['view'];
        $this->contentTypeId = $attr['contenttypeid'];
        $this->widgetTitle = $attr['title'];
        $this->records = $attr['records'];
    }

    public function getContentTypeId()
    {
        return $this->contentTypeId;
    }

    public function getRecordLimit()
    {
        return $this->records;
    }

    public function getListView()
    {
        return $this->listView;
    }

    public function getTitle()
    {
        return $this->widgetTitle;
    }

}
