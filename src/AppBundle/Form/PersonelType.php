<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Personel;
use AppBundle\Entity\Material;

class PersonelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')->add('lastname')
            ->add('materials', null, [
                'choice_label' => 'name',
                'expanded' => true,
                'by_reference' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Personel::class
        ]);
    }
    
    public function getBlockPrefix()
    {
        return 'appbundle_personel';
    }
}

