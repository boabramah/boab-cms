<?php
 
//src/Company/MyBundle/Form/Type/ContactType.php
namespace Invetico\PageBundle\Form\Type;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
 
class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {        
        $builder
            ->add(
                'message', 'textarea', [                    
                    'attr' => [
                        'maxlength' => 500,
                        'placeholder' => 'Write your message here...'
                    ]
                ]
            )
            ->add(
                'email', 'text', [                    
                    'attr' => [
                        'maxlength' => 50,
                        'placeholder' => 'Your E-mail'
                    ]
                ]
            )
            // i'm using captcha bundle which you can download here https://github.com/Gregwar/CaptchaBundle
            // and you can simply remove it from here and from the view if you don't want to use it
            ->add(
                'captcha', 'captcha', [
                    'length' => 3,
                    'attr' => ['maxlength' => 10, 'placeholder' => 'Security code'],
                    'invalid_message' => 'Security code is invalid',
                    'background_color' => [255, 255, 255],
                    'height' => 30,
                    'width' => 80,
                    'error_bubbling' => true
                ]
            )
            ->add('save', 'submit', ['label' => 'Send']);
    }
 
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $collectionConstraint = new Collection(array(
            'email' => array(
                new NotBlank(array('message' => 'Email should not be blank.')),
                new Email(array('message' => 'Invalid email address.'))
            ),
            'message' => array(
                new NotBlank(array('message' => 'Message should not be blank.')),
                new Length(array('min' => 5, 'minMessage' => 'Please enter your message'))
            )
        ));
 
        $resolver->setDefaults(array(
            'constraints' => $collectionConstraint
        ));
    }
 
    public function getName()
    {
        return 'contact';
    }
}