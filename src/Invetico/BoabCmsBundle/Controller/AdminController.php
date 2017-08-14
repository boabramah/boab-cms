<?php

namespace Invetico\BoabCmsBundle\Controller;

class AdminController extends BaseController
{
    public function delete($entity)
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();

        return;
    }
}
