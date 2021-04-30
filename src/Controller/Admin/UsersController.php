<?php

namespace App\Controller\Admin;

use App\Repository\MgUsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    /**
     * @Route("/admin/users", name="users_index", methods={"GET"})
     */
    public function index(MgUsersRepository $usersRepository): Response
    {
    	$allUsers = $usersRepository->findByRole("ROLE_ADMIN");
    	$userAdmin = [];
    	foreach ($allUsers as $key => $value) {
    		if (in_array('ROLE_SUPER_ADMIN',  $value->getRoles()) || in_array('ROLE_ADMIN',  $value->getRoles()) || in_array('ROLE_USER',  $value->getRoles()) || in_array('ROLE_CONTR',  $value->getRoles())) {
    			$userAdmin[] = $value;
    		}
    	}
        return $this->render('admin/users/index.html.twig', [
            'users' => $userAdmin,
        ]);
    }

    /**
     * @Route("/admin/users/new", name="users_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $mgUser = new MgUsers();
        $form = $this->createForm(UsersType::class, $mgUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($mgUser);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Ajout réussi !'
            );

            return $this->redirectToRoute('users_index');
        }

        return $this->render('admin/users/new.html.twig', [
            'user' => $mgUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/users/{id}/edit", name="users_edit", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function edit(Request $request, MgUsers $user): Response
    {
        $userRoles = $this->getUser()->getRoles();
        //dump($userRole);
        $form = $this->createForm(UsersEditType::class, $user, ['userRoles' => $userRoles]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'success',
                'Modification enregistrée !'
            );

            return $this->redirectToRoute('users_index');
        }

        return $this->render('admin/users/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Permet de modifier le mot de passe de l'utilisateur
     *
     * @Route ("/admin/users/update-password", name="users_password")
     *
     * @return Response
     */
    public function updatePassword(Request $request, MgUsersRepository $usersRepository, UserPasswordEncoderInterface $encoder)
    {
        $user = $this->getUser();
        $form = $this->createForm(UsersPasswordEditType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $task = $form->getData();
            //dd($task);
            //1. Vérifier que l'ancien mot de passe renseigné est correcte
            if(!password_verify($task['oldPassword'], $user->getPassword())) {
                //Gestion de l'erreur
                $form->get('oldPassword')->addError(new FormError("Le mot de passe saisie n'est pas votre mot de passe actuel"));
            } else {
                $newPassword = $task['newPassword'];
                $password = $encoder->encodePassword($user, $newPassword);
                $usersRepository->upgradePassword($user, $password);

                $this->addFlash(
                    'success',
                    'Le mot passe a bien été modifié !'
                );

                return $this->redirectToRoute('users_index');
            }
        }
        return $this->render('admin/users/password-edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
