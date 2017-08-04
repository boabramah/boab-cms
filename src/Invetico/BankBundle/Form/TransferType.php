<?php

namespace Invetico\BankBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransferType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dateCreated')
                ->add('referenceNumber')
                ->add('authorizationCode')
                ->add('authStatus')
                ->add('amount')
                ->add('status')
                ->add('processDate')
                ->add('isRepeatable')
                ->add('transferFrequency')
                ->add('fromAccount')
                ->add('toAccount')
                ->add('description')
                ->add('customer');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Invetico\BankBundle\Entity\Transfer',
            'csrf_protection'   => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'invetico_bankbundle_transfer';
    }


}
