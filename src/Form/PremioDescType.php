<?php


namespace App\Form;

use App\Entity\Cliente;
use App\Entity\Cuota;
use App\Entity\EnumFormaPago;
use App\Entity\Hijo;
use App\Entity\Localidad;
use App\Entity\Poliza;
use App\Entity\SiniestrosFc;
use App\Entity\TipoCobertura;
use App\Entity\Vehiculo;
use FOS\RestBundle\Form\Transformer\EntityToIdObjectTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PremioDescType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder
            ->add('tipoCobertura')
            ->add('localidad')
            ->add('modelo')
            ->add('kmAnio')
            ->add('medidasSeguridad')
            ->add('cantSiniestros')
            ->add('cantHijos')
            ->add('tipoPago')
            ->add('sumaAsegurada')
            ->add('cliente')
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        //'data_class' => Poliza::class,
        $resolver->setDefaults([
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