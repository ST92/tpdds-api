<?php

namespace App\Form;


use App\EntidadesAux\BusquedaCliente;
use App\Entity\EnumTipoDni;
use FOS\RestBundle\Form\Transformer\EntityToIdObjectTransformer;
use Symfony\Component\ExpressionLanguage\Tests\Node\Obj;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Serializer\Tests\Normalizer\Features\ObjectDummy;

class BusquedaClienteType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder
            ->add('id')
            ->add('dni')
            ->add('nombre')
            ->add('apellido')
            //->add($builder->create('enumTipoDni', TipoDniType::class, ['em' => $options['em']]))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BusquedaCliente::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true,
            'method' => 'GET'
        ]);
        $resolver->setRequired(array('em'));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return '';
    }
}
