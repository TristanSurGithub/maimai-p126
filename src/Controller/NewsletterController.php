<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Newsletter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/newsletter", name="newsletter")
 */
final class NewsletterController extends AbstractController
{
    public function __invoke(Request $request, MailerInterface $mailer)
    {
        $dataNewsletter = new Newsletter();
        $builder = $this->createFormBuilder($dataNewsletter)
            ->add('lastname', TextType::class, array('required' => false))
            ->add('firstname', TextType::class, array('required' => false))
            ->add('email', EmailType::class)
            ->add('submit', SubmitType::class);

        $form = $builder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $mailer->send(
                (new TemplatedEmail())->to($dataNewsletter->email)
                    ->from('newsletter@makigai.com')
                    ->subject(sprintf('Makigai Maimai p126 - Newsletter'))
                    ->htmlTemplate('emails/newsletter.html.twig')
                    ->context([
                            'lastname' => empty($dataNewsletter->lastname )? '' : $dataNewsletter->lastname,
                            'firstname' => empty($dataNewsletter->firstname )? '' : $dataNewsletter->firstname,
                            ])
            );
            $this->addFlash('notice', 'Vous êtes maintenant abonné 😀');
        }
        return $this->render('newsletter.html.twig', ['form'=>$form->createView()]);
    }
}
