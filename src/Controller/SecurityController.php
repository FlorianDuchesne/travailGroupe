<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use App\Form\ChangePasswordType;
use App\Repository\UserRepository;
use App\Form\ForgottenPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\AppVariable;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/security/forgotten_password", name="forgotten_password")
     */
    public function forgottenPassword(User $user = null, EntityManagerInterface $manager, Request $request, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator, UserRepository $userRepository): Response
    {
        // on instancie la variable $form

        $form = $this->createForm(ForgottenPasswordType::class);

        $form->handleRequest($request);

        $email = $form->get('emailResetPassword')->getData();

        $user = $userRepository->findOneByEmail($email);

        if ($form->isSubmitted() && $form->isvalid()) {

            if ($request->isMethod('POST')) {

                // on génère un Token unique
                $token = $tokenGenerator->generateToken();
                try {

                    $user->setResetToken($token);

                    $manager->flush();
                } catch (\Exception $e) {
                    $this->addFlash('Warning', $e->getMessage());
                    return $this->redirectToRoute('app_login');
                }

                // on génère une URL qui va comporter la route permettant de changer le mot de passe

                $url = $this->generateUrl('resetPassword', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

                // on envoie le mail
                $message = (new Email())
                    ->from('symfonyFloEtJp@gmail.com')
                    ->to($user->getEmail())
                    ->subject('Récuperation de mot de passe test')
                    ->text("Voici le lien de récupération de votre mot de passe :" . $url, 'text/html')
                    ->html("<p> Ceci est un test: " . $url, 'text/html' . "</p>");

                $mailer->send($message);

                $this->addFlash('info', 'Le mail de récupération de mot passe a bien été envoyé vous pouvez aller le consulter.');
            }
        }


        return $this->render('security/forgottenPassword.html.twig', [
            'form' => $form->createView(),
            'title' => "Reinitialisation du mot de passe"
        ]);
    }

    /**
     * @Route("/resetPassword/{token}", name="resetPassword")
     */
    public function resetPassword(EntityManagerInterface $manager, Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository)
    {

        // $form = $this->createForm(ChangePasswordType::class);
        // $form -> handleRequest($request);

        // redefinir le token

        if ($request->isMethod('POST')) {


            // $user = $userRepository->findOneByResetToken($token);
            $user = $manager->getRepository(User::class)
                ->findOneByResetToken($token);

            // if($form->isSubmitted() && $form->isValid()){

            $user->setResetToken(NULL);

            // $newPassword = $form->get('password')->getData();

            $user->setPassword(
                $passwordEncoder->encodePassword($user, $request->request->get('password'))
            );
            $manager->flush();
            $this->addFlash('info', 'Votre mot de passe a bien été reinitialisé !');

            return $this->redirectToRoute('app_login');

            // }
        }

        return $this->render('security/resetPassword.html.twig', [
            'token' => $token,
            // 'form' => $form->createView(),
            'title' => "Reinitialisation du mot de passe"

        ]);
    }
}
