<?php

namespace Highco\HiddenEntityBundle\Type;

use Doctrine\Common\Persistence\ObjectManager;
use Highco\HiddenEntityBundle\DataTransformer\EntityToIdDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HiddenEntityType extends AbstractType
{
    protected $objectManager;

    /**
     * HiddenEntityType constructor.
     *
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new EntityToIdDataTransformer($this->objectManager, $options['class']);
        $builder->addModelTransformer($transformer);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired('class')
            ->setDefaults([
                'invalid_message' => 'The entity does not exist.',
            ]);
    }

    /*
     *
     */
    public function getParent()
    {
        return HiddenType::class;
    }

    /*
     *
     */
    public function getName()
    {
        return 'hidden_entity';
    }

}