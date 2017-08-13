<?php

namespace Invetico\BoabCmsBundle\Model;

use Invetico\BoabCmsBundle\Entity\Article;
use Symfony\Component\HttpFoundation\Request;
use Invetico\BoabCmsBundle\Model\AbstractContentType;

class ArticleType extends AbstractContentType
{
    public function getTypeId()
    {
        return 'article';
    }

    public function buildRouteParams(Article $content)
    {
        return ['slug' => $content->getSlug()];
    }

    public function getContentFromRoute(Request $request)
    {
        return $this->contentRepository->findContentBySlug($request->get('slug'));
    }

    public function getListView()
    {
        return 'BoabCmsBundle:Article:article_list';
    }

    public function getNodeView()
    {
        return 'BoabCmsBundle:Article:article_show';
    }

    public function getBlockTitle()
    {
        return 'The Blog';
    }

    public function getContentRouteParams($routeKey, $content)
    {
        switch ($routeKey) {
            case 'blog_show':
                return ['slug' => $content->getSlug()];
                break;

            default:
                return [];
                break;
        }
    }

    public function getContent(Request $request)
    {
        return $this->contentRepository->findContentBySlug($request->get('slug'));
    }

    public function getContentTypeLabel()
    {
        return 'Article';
    }
}
