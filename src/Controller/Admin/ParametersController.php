<?php

namespace App\Controller\Admin;

use App\Entity\MgParameterAddresses;
use App\Entity\MgParameters;
use App\Form\ParameterAddressType;
use App\Form\ParameterBasketType;
use App\Form\ParametersType;
use App\Repository\MgParameterAddressesRepository;
use App\Repository\MgParameterBasketRepository;
use App\Repository\MgParametersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/parameters", name="parameters_")
 */
class ParametersController extends AbstractController
{

		/**
		 * @Route("/", name="index", methods={"GET","POST"})
		 */
		public function index(Request $request, MgParametersRepository $mgParametersRepository): Response
		{
				$parameter = $mgParametersRepository->find(1);
				$form = $this->createForm(ParametersType::class, $parameter);
				$form->handleRequest($request);

				if ($form->isSubmitted() && $form->isValid()) {
						$this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'success',
                "Modification réussie !"
            );

						return $this->redirectToRoute('parameters_index');
				}
				return $this->render('admin/parameters/index.html.twig', [
						'parameters' => $parameter,
						'form' => $form->createView(),
            'NavParamsOpen' => true
				]);
		}

    /**
     * @Route("/addresses", name="adresses")
     */
    public function addresses(MgParameterAddressesRepository $repoParamAddresses)
    {
      $addresses = $repoParamAddresses->findAll();
      return $this->render('admin/parameters/addresses/index.html.twig', [
          'addresses' => $addresses,
          'NavParamsOpen' => true
      ]);
    }

    /**
     * @Route("/parameters_adresses_new", name="address_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
    	$param_address = new MgParameterAddresses();
        $form = $this->createForm(ParameterAddressType::class, $param_address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($param_address);
            $em->flush();
            $this->addFlash(
                'success',
                "Création réussie !"
            );

            return $this->redirectToRoute('parameters_adresses');
        }
        return $this->render('admin/parameters/addresses/new.html.twig', [
            'form' => $form->createView(),
            'NavParamsOpen' => true
        ]);
    }

    /**
     * @Route("/{id}/parameters_adresses_edit", name="address_edit", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function edit(Request $request, MgParameterAddresses $addresses): Response
    {
        $form = $this->createForm(ParameterAddressType::class, $addresses);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($addresses);
            $em->flush();
            $this->addFlash(
                'success',
                "Modification réussie !"
            );

            return $this->redirectToRoute('parameters_adresses');
        }

        return $this->render('admin/parameters/addresses/edit.html.twig', [
            'form' => $form->createView(),
            'NavParamsOpen' => true
        ]);

    }

    /**
     * @Route("/parameters_adresses_delete/{id}", name="address_delete", methods={"DELETE"})
     */
    public function delete(Request $request, MgParameterAddresses $paramAddresses): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paramAddresses->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($paramAddresses);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Adresse supprimée.'
            );
        }

        return $this->redirectToRoute('parameters_adresses');
    }

    /**
     * @Route("/parameters_basket", name="basket_index", methods={"GET","POST"})
     */
    public function basket(Request $request, MgParameterBasketRepository $parameterBasketRepository): Response
    {
        $parameter = $parameterBasketRepository->find(1);
        $form = $this->createForm(ParameterBasketType::class, $parameter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'success',
                "Modification réussie !"
            );

            return $this->redirectToRoute('parameters_basket_index');
        }
        return $this->render('admin/parameters/basket/index.html.twig', [
            'parameter' => $parameter,
            'form' => $form->createView(),
            'NavParamsOpen' => true
        ]);
    }}
