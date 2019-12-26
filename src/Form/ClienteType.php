<?php


namespace App\Form;


use App\Entity\Cliente;
use App\Entity\Direccion;
use App\Entity\EnumCondIva;
use App\Entity\EnumEstadoCivil;
use App\Entity\EnumSexo;
use App\Entity\EnumTipoDni;
use App\Services\Form\DataTransformer\JsonCollectionToIdTransformer;
use FOS\RestBundle\Form\Transformer\EntityToIdObjectTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClienteType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder
            ->add('id')
            ->add('dni')
            ->add('cuil_cuit')
            ->add('fecha_nac', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy/MM/dd'))
            ->add('apellido')
            ->add('nombre')
            ->add('email')
            ->add('profesion')
            ->add('anio_registro')
            ->add($builder->create('enum_tipo_dni', TipoDniType::class, ['em' => $options['em']]))
            ->add($builder->create('enum_cond_iva', CondIvaType::class, ['em' => $options['em']]))
            ->add($builder->create('direccion', DireccionType::class, ['em' => $options['em']]))
            ->add($builder->create('enum_estado_civil', EstadoCivilType::class, ['em' => $options['em']]))
            ->add($builder->create('enum_sexo', SexoType::class, ['em' => $options['em']]));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cliente::class,
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
