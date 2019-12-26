<?php


namespace App\Form;

use App\Entity\Cliente;
use App\Entity\Cuota;
use App\Entity\EnumFormaPago;
use App\Entity\Hijo;
use App\Entity\Localidad;
use App\Entity\MedidasSeguridad;
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

/**
 * Class PolizaType
 * @package App\Form
 */
class PolizaType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('nro_poliza')
            ->add('suma_asegurada')
            ->add('km_anio')
            ->add('fecha_inicio_vigencia', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy/MM/dd'
            ))
            ->add('fecha_fin_vigencia', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy/MM/dd'
            ))
            ->add('premio')
            ->add('importe_por_descuento')
            ->add('ultimo_dia_pago', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy/MM/dd'
            ))
            ->add('monto_total_a_abonar')
            ->add($builder->create('vehiculo', VehiculoType::class, ['em' => $options['em']]))
            ->add($builder->create('lista_hijos', CollectionType::class, [
                'entry_type' => HijoType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options' => [
                    'em' => $options['em']
                ]
            ]))
            ->add($builder->create('lista_cuotas', CollectionType::class, [
                'entry_type' => CuotaType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options' => [
                    'em' => $options['em']
                ]
            ]))
            ->add($builder->create('tipo_cobertura', TipoCoberturaType::class, ['em' => $options['em']]))
            ->add($builder->create('localidad', LocalidadType::class, ['em' => $options['em']]))
            ->add($builder->create('formapago', FormaPagoType::class, ['em' => $options['em']]))
            ->add($builder->create('siniestro_FC', SiniestrosType::class, ['em' => $options['em']]))
             ->add($builder->create('cliente', ClienteType::class, ['em' => $options['em']]));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Poliza::class,
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