<?php


namespace App\Form;


use App\Entity\MedidasSeguridad;
use App\Entity\Modelo;
use App\Entity\Vehiculo;
use FOS\RestBundle\Form\Transformer\EntityToIdObjectTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculoType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder
            ->add('anio_vehiculo')
            ->add('motor')
            ->add('chasis')
            ->add('patente')
            ->add($builder->create('modelo', ModeloType::class, ['em' => $options['em']]))
            ->add($builder->create('lista_medidas', CollectionType::class, [
            'entry_type' => MedidasSeguridadType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'entry_options' => [
                'em' => $options['em']
            ]
        ]))
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vehiculo::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ]);
        //Esto lo agregué porque no andaba objForm
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
