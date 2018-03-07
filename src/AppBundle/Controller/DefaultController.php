<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;



class DefaultController extends Controller
{
    /**
     * @Route("/{_locale}", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            /*'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,*/
        ]);
    }

    /**
     * @Route("/{_locale}/presentation", name="presentation_page")
     */
    public function presentationAction()
    {
        // replace this example code with whatever you need
        return $this->render('default/presentation.html.twig', [
            /*'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,*/
        ]);
    }

    /**
     * @Route("/{_locale}/cv", name="cv_page")
     */
    public function cvAction()
    {
        // replace this example code with whatever you need
        return $this->render('default/cv.html.twig', [
            /*'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,*/
        ]);
    }

    /**
     * @Route("/{_locale}/competences", name="competences_page")
     */
    public function competencesAction()
    {
        // replace this example code with whatever you need
        return $this->render('default/competences.html.twig', [
            /*'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,*/
        ]);
    }


    /**
     * @Route("/{_locale}/contact", name="contact_page")
     */
    public function formAction(Request $request, $_locale, \Swift_Mailer $mailer)
    {

        $formBuilder = $this->createFormBuilder();

        $formBuilder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'contact.form.name', 'translation_domain' => 'contact',
                'constraints' => [
                    new NotBlank()
                    ]
            ])
            ->add('surname', TextType::class, [
                'required' => true,
                'label' => 'contact.form.surname', 'translation_domain' => 'contact',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('email', EmailTYpe::class, [
                'required' => true,
                'label' => 'contact.form.email', 'translation_domain' => 'contact',
                'constraints' => [
                    new NotBlank(),
                    new Email
                ]
            ])
            ->add('object', ChoiceType::class, [
                'required' => true,
                'label' => 'contact.form.liste.label', 'translation_domain' => 'contact',
                'choices' => [
                    'contact.form.liste.contact' => 'contact',
                    'contact.form.liste.di' => 'di',
                    'contact.form.liste.devis' => 'devis',
                    'contact.form.liste.rdv' => 'rdv',
                ],
            ])
            ->add('message', TextareaType::class, [
                'required' => true,
                'label' => 'contact.form.message', 'translation_domain' => 'contact',
                'constraints' => [
                    new NotBlank()
                ]
            ]);

        $form = $formBuilder->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData(); // Récupère les valeurs. $data['champ1']; // Accès à la valeur du champ1.
            //// Faire quelques choses.
            return $this->redirectToRoute('succes_form_page', ['_locale' => $_locale,
            ]);
        }

        return $this->render('default/contact.html.twig', ['form_example' => $form->createView(),

        ]);


        // Création de l'email.
        $message = new \Swift_Message($data['object']);
        $message->setFrom($data['email']);
        $message->setTo('boilot.maxime@gmail.com');
        $message->setBody($data['message']);
        // Envoi de l'email.
        $mailer->send($message);

    }

    /**
     * @Route("/{_locale}/successForm", name="succes_form_page")
     */
    public function successFormAction()
    {
        return $this->render('default/result_form.html.twig');
    }



}
