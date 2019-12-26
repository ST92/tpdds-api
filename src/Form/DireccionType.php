<?php

namespace App\Form;

use App\Entity\Direccion;
use App\Entity\EnumEstadoCivil;
use App\Entity\Marca;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DireccionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add("id")
			->add("nombre_calle")
			->add("num_calle")
			->add("num_dpto")
			->add($builder->create('localidad', LocalidadType::class, ['em' => $options['em']]));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Direccion::class,
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