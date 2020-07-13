<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserProfileType;
use App\Security\EmailVerifier;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserController extends AbstractController
{
    private $emailVerifier;
    private $em;

    public function __construct(EmailVerifier $emailVerifier, EntityManagerInterface $em)
    {
        $this->emailVerifier = $emailVerifier;
        $this->em = $em;
    }

    /**
     * @Route("/user", name="user_profile")
     */
    public function index( Request $request, UserPasswordEncoderInterface $passwordEncoder,GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator, SluggerInterface $slugger)
    {
        $user = $this->getUser();

        $form = $this->createForm(UserProfileType::class, $this->getUser());
        $form->handleRequest($request);

        if ( $form->isSubmitted() ) {

            $avatarFile = $form->get('avatar')->getData();

            if ($avatarFile) {
                $originalFilename = pathinfo($avatarFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = md5(mktime().$safeFilename).'-'.uniqid().'.'.$avatarFile->guessExtension();
//                $newFilename = $safeFilename;
//                die(var_dump());

                // Move the file to the directory where brochures are stored
                try {
                    $avatarFile->move(
                        $this->getParameter('avatar_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setAvatar(''.$newFilename);
            }

            if ($form->get('password')->getData()) {
                // encode the plain password
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
//            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
//                (new TemplatedEmail())
//                    ->from(new Address('no-reply@s-blog.com.ua', 'NoReply'))
//                    ->to($user->getEmail())
//                    ->subject('Please Confirm your Email')
//                    ->htmlTemplate('registration/confirmation_email.html.twig')
//            );
            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'user' => $user,
            'userProfileForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/unsubscribe/{id}", name="user_unsubscribe")
     */
    public function unsubscribe (User $user)
    {
        $user->setIsSubscribe(false);
        $this->em->persist($user);
        $this->em->flush();
        return $this->redirectToRoute('article_index');
    }

}
