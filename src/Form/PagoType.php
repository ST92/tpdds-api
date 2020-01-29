<?php


namespace App\Form;


use App\Entity\Pago;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class PagoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('id')
            ->add('monto')
            ->add('fecha', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy/MM/dd'
            ))
            ->add($builder->create('lista_cuotas', CollectionType::class, [
                'entry_type' => CuotaType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options' => [
                    'em' => $options['em']
                ]
            ]));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pago::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true
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