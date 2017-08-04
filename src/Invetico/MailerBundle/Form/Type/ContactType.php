<?php
 
namespace Invetico\MailerBundle\Form\Type;
 
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
                'fullName', 'text', [                    
                    'attr' => [
//                        'maxlength' => 500,
                        'placeholder' => 'Your full name...'
                    ]
                ]
            )        
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

            ->add(
                'contactNumber', 'text', [                
                    'attr' => [
                        'maxlength' => 200,
                        'placeholder' => 'Your Contact Number'
                    ]
                ]
            ) 
            ->add(
                'subject', 'text', [                   
                    'attr' => [
                        'maxlength' => 200,
                        'placeholder' => 'Subject'
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
                   // 'error_bubbling' => true
                ]
            );
//            ->add('save', 'submit', ['label' => 'Send']);
    }
 
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $collectionConstraint = new Collection(array(
            'fullName' => array(
                new NotBlank(array('message' => 'Full name should not be blank.')),
                new Length(array('min' => 5, 'minMessage' => 'Invalid name supplied'))
            ),            
            'email' => array(
                new NotBlank(array('message' => 'Email should not be blank.')),
                new Email(array('message' => 'Invalid email address.'))
            ),
            'subject' => array(
                new NotBlank(array('message' => 'Subject should not be blank.'))
            ),
            'contactNumber' => array(
                new NotBlank(array('message' => 'Contact Number should not be blank.'))
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