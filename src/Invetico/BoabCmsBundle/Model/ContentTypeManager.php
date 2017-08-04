<?php
namespace Invetico\BoabCmsBundle\Model;

class ContentTypeManager implements ContentTypeManagerInterface
{
    private $entities = [];
    private $contentTypes = [];

    public function __construct()
    {
        //$this->entities = $this->getEntities();
    }

    public function getType($key)
    {
        foreach ($this->getContentTypes() as $type) {
            if ($key === $type->getContentTypeId()) {
                return $type;
            }
        }
      
        throw new \InvalidArgumentException(sprintf("Invalid content type identifier ( %s )", $key));
    }

    public function getTypeByClass($class)
    {
        foreach ($this->getContentTypes() as $type) {
            if ($class === $type->getEntityClass()) {
                return $type;
            }
        }

        throw new \InvalidArgumentException(sprintf("Invalid content type class ( %s )", $class));
    }

    public function addContentType(ContentTypeInterface $contentType)
    {
        $this->contentTypes[] = $contentType;
    }

    public function getContentTypes()
    {
        return $this->contentTypes;
    }

    public function getContentTypesAsOptionList($selectedType)
    {
        $option = '';
        foreach ($this->getContentTypes() as $type) {
            $option .= '<option value="' . $type->getContentTypeId() . '"';
            if ($selectedType == $type->getContentTypeId()) {
                $option .= ' selected = "selected"';
            }
            $option .= '>' . ucFirst($type->getContentTypeId()) . '</option>';
        }

        return $option;
    }
}
