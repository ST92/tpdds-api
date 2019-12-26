<?php

namespace App\Form;

use App\Entity\EnumCondIva;
use App\Entity\EnumEstadoCivil;
use App\Entity\EnumTipoDni;
use App\Entity\Marca;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TipoDniType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('id')
            ->add('descripcion');

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EnumTipoDni::class,
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