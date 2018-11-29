<?php

namespace App\Form;

use App\Entity\Producto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('barcode',TextType::class)
            ->add('nombre',TextType::class)
            ->add('cantPack',IntegerType::class)
            ->add('cantUnit',IntegerType::class)
            ->add('cantTotal',IntegerType::class)
            ->add('precioPack',IntegerType::class)
            ->add('precioUnit',IntegerType::class)
            ->add('isIva',CheckboxType::class)
            ->add('guardar', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Producto::class,
        ]);
    }
}
