<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserController extends AbstractController
{
  public function index(UserRepository $userRepository): Response
  {
    return $this->render('user/index.html.twig', [
      'users' => $userRepository->findAll(),
    ]);
  }

  public function show(): Response
  {
    return $this->render('user/show.html.twig');
  }

  public function new(
    Request $request,
    EntityManagerInterface $entityManager,
    UserPasswordHasherInterface $passwordHasher
  ): Response {
    $user = new User();
    $form = $this->createForm(UserType::class, $user);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      // Encoder le mot de passe qui est en clair pour l’instant
      $hashedPassword = $passwordHasher->hashPassword(
        $user,
        $user->getPassword()
      );
      $user->setPassword($hashedPassword);
      // Définir le rôle de l’usager qui va être créé
      $user->setRoles(["ROLE_CLIENT"]);
      // Faire persister l’usager en BD
      $entityManager->persist($user);
      $entityManager->flush();
      // Après l’inscription, rediriger vers l’authentification
      return $this->redirectToRoute('app_login');
    }
    return $this->renderForm('user/new.html.twig', [
      'user' => $user,
      'form' => $form,
    ]);
  }

  public function orders(): Response
  {
    return $this->render('user/orders.html.twig');
  }
}