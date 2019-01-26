<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Exception\FailedCredentialsException;
use App\Repository\User\UserRepositoryInterface;
use App\Service\Security\SecurityServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Security\LoginFormAuthenticator;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

/**
 * Controller provides login, registration pages.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
class SecurityController extends AbstractController
{
    private $userRepository;
    private $securityService;

    public function __construct(UserRepositoryInterface $userRepository, SecurityServiceInterface $securityService)
    {
        $this->userRepository = $userRepository;
        $this->securityService = $securityService;
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
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
    }

    /**
     * @Route("/signup", name="app_register")
     */
    public function registration(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        GuardAuthenticatorHandler $guardHandler,
        LoginFormAuthenticator $authenticator,
        $error = ''
    )
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $this->securityService->verifyUsername($user->getUsername());
                $this->securityService->verifyEmail($user->getEmail());
            } catch (FailedCredentialsException $e) {
                return $this->getFailedResponse($form, $e->getMessage());
            }

            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setIsActive(true);

            if ($user->getTrainerAccepted()) {
                $user->addRole('ROLE_USER_TRAINER');
                $user->setIsTrainer(true);
            } else {
                $user->setIsTrainer(false);
            }

            $this->userRepository->save($user);

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render(
            'security/registration.html.twig',
            [
                'form' => $form->createView(),
                'error' => $error,
            ]
        );
    }

    private function getFailedResponse($form, $error): Response
    {
        return $this->render(
            'security/registration.html.twig',
            [
                'form' => $form->createView(),
                'error' => $error,
            ]
        );
    }
}
