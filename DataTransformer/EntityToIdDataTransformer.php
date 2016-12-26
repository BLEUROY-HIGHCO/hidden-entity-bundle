<?php

namespace Highco\HiddenEntityBundle\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class EntityToIdDataTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    protected $class;

    /**
     * EntityToIdDataTransformer constructor.
     *
     * @param ObjectManager $objectManager
     * @param string        $class
     */
    public function __construct(ObjectManager $objectManager, $class)
    {
        $this->objectManager = $objectManager;
        $this->class         = $class;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($entity)
    {
        if (null === $entity) {
            return;
        }

        return $entity->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($id)
    {
        if (!$id) {
            return null;
        }
        $entity = $this->objectManager
            ->getRepository($this->class)
            ->find($id);
        if (null === $entity) {
            throw new TransformationFailedException();
        }

        return $entity;
    }
}