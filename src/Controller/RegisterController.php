<?php

namespace App\Controller;

use App\Entity\MgUsers;
use App\Form\CustomersType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
	private $em;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->em = $entityManager;
	}
    /**
     * @Route("/inscription", name="register")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
    	$user = new MgUsers();
    	$form = $this->createForm(CustomersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        	$task = $form->getData();
        	$user->setEmail($task->getUsername());
        	$password = $encoder->encodePassword($user, $user->getPassword());
        	$user->setPassword($password);
        	$this->em->persist($user);
        	$this->em->flush();
        }
    	
        return $this->render('register/index.html.twig', [
        	'form' => $form->createView()
        ]);
    }
}
