<?php


namespace App\Form;

use App\Entity\Cuota;
use App\Entity\Pago;
use FOS\RestBundle\Form\Transformer\EntityToIdObjectTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CuotaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){

        $pagoTransformer =  new EntityToIdObjectTransformer($options['em'], Pago::class);

        $builder
            ->add('id')
            ->add('num_cuota')
            ->add('fecha_vencimiento', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy/MM/dd'))
            ->add('monto')
            ->add('recargos')
            ->add('bonificacion_pago_adelantado')
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cuota::class,
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
