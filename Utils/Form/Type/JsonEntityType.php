<?php


namespace App\Utils\Form\Type;

use App\Services\Form\DataTransformer\ArrayToIdTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class JsonEntityType extends AbstractType
{

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new ArrayToIdTransformer($this->objectManager, $options['class']);
        $builder->addModelTransformer($transformer);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'class' => null,
            'invalid_message' => 'The entity does not exist.',
        ));
    }


    /**
     * @return string
     */
    public function getParent()
    {
        return HiddenType::class;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'json_entity';
    }
}
