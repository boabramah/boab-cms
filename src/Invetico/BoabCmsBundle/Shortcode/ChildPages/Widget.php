<?php

namespace Invetico\BoabCmsBundle\Shortcode\ChildPages;


class Widget
{
    private $parentPageId;

    private $recordLimit;

    private $listView;

    private $dateOrder;


    public function __construct($attr)
    {
        $this->parentPageId = $attr['parentid'];
        $this->recordLimit = $attr['records'];
        $this->listView = $attr['view'];
        $this->dateOrder = $attr['date_order'];
    }

    public function getParentPageId()
    {
        return $this->parentPageId;
    }

    public function getContentTypeId()
    {
        return 'page';
    }

    public function getRecordLimit()
    {
        return $this->recordLimit;
    }

    public function getListView()
    {
        return $this->listView;
    }

    public function getDateOrder()
    {
        return $this->dateOrder;
    }
}
