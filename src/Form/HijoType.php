<?php


namespace App\Form;

use App\Entity\EnumEstadoCivil;
use App\Entity\Hijo;
use FOS\RestBundle\Form\Transformer\EntityToIdObjectTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HijoType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){

        $estadCivilTransformer =  new EntityToIdObjectTransformer($options['em'], EnumEstadoCivil::class);

        $builder
            ->add('dni')
            ->add('fecha_nac', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy/MM/dd'))
            ->add($builder->create('estado_civil', EstadoCivilType::class, ['em' => $options['em']]))
            ->add($builder->create('enum_sexo', SexoType::class, ['em' => $options['em']]))
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Hijo::class,
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
