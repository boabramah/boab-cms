<?php
namespace Invetico\BoabCmsBundle\Model;

use Invetico\BoabCmsBundle\Repository\ContentRepositoryInterface;

class ContentTypeManager implements ContentTypeManagerInterface
{
    protected $contentRepository;
    private $contentTypes = [];
    private $configs;

    public function __construct(ContentRepositoryInterface $contentRepository, $configs)
    {
        $this->contentRepository = $contentRepository;
        if (!is_array($configs)) {
            throw new \InvalidArgumentException('At least one content content types must be configured to continue');
        }
        $this->configs = $configs;
    }

    public function getType($key)
    {
        foreach ($this->getContentTypes() as $type) {
            if ($key === $type->getTypeId()) {
                $this->setDependencies($type);

                return $type;
            }
        }

        throw new \InvalidArgumentException(sprintf("Invalid content type identifier ( %s )", $key));
    }

    public function getTypeByClass($class)
    {
        foreach ($this->getContentTypes() as $type) {
            if ($class === $type->getEntityClass()) {
                $this->setDependencies($type);

                return $type;
            }
        }
        throw new \InvalidArgumentException(sprintf("Invalid content type class ( %s )", $class));
    }

    public function getTypeByObject($object)
    {
        return $this->getTypeByClass(get_class($object));
    }

    public function addContentType(ContentTypeInterface $contentType)
    {
        $this->contentTypes[] = $contentType;
    }

    public function getContentTypes()
    {
        foreach ($this->contentTypes as $contentType) {
            $this->setDependencies($contentType);
        }

        return $this->contentTypes;
    }

    public function getContentTypesAsOptionList($selectedType)
    {
        $option = '';
        foreach ($this->getContentTypes() as $type) {
            $option .= '<option value="'.$type->getContentTypeId().'"';
            if ($selectedType === $type->getContentTypeId()) {
                $option .= ' selected = "selected"';
            }
            $option .= '>'.ucfirst($type->getContentTypeId()).'</option>';
        }

        return $option;
    }

    private function setDependencies($contentType)
    {
        $contentType->setContenRepository($this->contentRepository);
        if (!isset($this->configs[$contentType->getTypeId()])) {
            throw new \InvalidArgumentException(sprintf('You must configure an entity for %s content type', get_class($contentType)));
        }
        $configs = $this->configs[$contentType->getTypeId()];
        $contentType->setConfiguration($configs);
    }
}
