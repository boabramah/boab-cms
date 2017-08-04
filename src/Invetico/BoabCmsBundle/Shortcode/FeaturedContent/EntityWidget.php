<?php

namespace Invetico\BoabCmsBundle\Shortcode\FeaturedContent;

class EntityWidget
{
    private $listView;
    private $contentTypeId;


    public function __construct($attr)
    {
        $this->listView = $attr['view'];
        $this->contentTypeId = $attr['contenttypeid'];
    }

    public function getContentTypeId()
    {
        return $this->contentTypeId;
    }

    public function getListView()
    {
        return $this->listView;
    }

}
