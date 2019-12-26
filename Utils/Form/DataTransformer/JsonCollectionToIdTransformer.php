<?php

namespace App\Utils\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class JsonCollectionToIdTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var string Name spaced entity
     */
    private $class;

    /**
     * @param ObjectManager $objectManager
     * @param string $class
     */
    public function __construct(ObjectManager $objectManager, $class)
    {
        $this->objectManager = $objectManager;
        $this->class = $class;
    }

    public function transform($collection)
    {
        if (null === $collection) {
            return;
        }
        $ids = [];
        foreach ($collection as $entity) {
            $ids[] = $entity->getId();
        }
        return $ids;
    }

    public function reverseTransform($data)
    {

        $collection = new ArrayCollection();
        foreach ($data as $obj) {
            $id = isset($obj['id']) ? $obj['id'] : null;
            if ($id) {
                $entity = $this->objectManager->getRepository($this->class)->find($id);
                if (null === $entity) {
                    throw new TransformationFailedException();
                }
                $collection->add($entity);
            }
        }
        return $collection;
    }

    /**
     * @return ObjectManager
     */
    public function getObjectManager()
    {
        return $this->objectManager;
    }

    /**
     * @param ObjectManager $objectManager
     */
    public function setObjectManager($objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }
}
