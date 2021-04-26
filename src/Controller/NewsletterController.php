<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Newsletter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
        $contact = new Newsletter();
        $builder = $this->createFormBuilder($contact)
            ->add('name')
            ->add('email', EmailType::class)
            ->add('submit', SubmitType::class);

        $form = $builder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            dump('C\'est valide', $form->getData());
            $mailer->send(
                (new TemplatedEmail())->to($contact->email)
                    ->from('newsletter@makigai.com')
                    ->subject(sprintf('%s - from',$contact->name))
                    ->htmlTemplate('emails/newsletter.html.twig')
                    ->context([
                            'name' => $contact->name,
                            ])
            );
            $this->addFlash('notice', 'Message envoyé');
        }
        return $this->render('newsletter.html.twig', ['form'=>$form->createView()]);
    }
}
