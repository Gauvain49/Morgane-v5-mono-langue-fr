<?php

namespace App\Controller\Admin;

use App\Entity\MgCarriers;
use App\Form\CarriersType;
use App\Services\DeleteItems;
use App\Entity\MgCarriersLang;
use App\Repository\MgCarriersRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/carriers")
 */
class CarriersController extends AbstractController
{
    /**
     * @Route("/", name="carriers_index")
     */
    public function index(MgCarriersRepository $repoCarriers)
    {
        return $this->render('admin/carriers/index.html.twig', [
            'carriers' => $repoCarriers->findAll(),
            'NavCarrierOpen' => true
        ]);
    }

    /**
     * @Route("/new", name="carriers_new", methods={"GET","POST"})
     */
    public function new(Request $request, MgCarriersRepository $repoCarriers)
    {
    	$carrier = new MgCarriers();
    	$delay = new MgCarriersLang();
    	//On vérifie s'il existe un transporteur par défaut
        $ifExistDefault = $repoCarriers->findOneBy(['carrier_default' => true]);
        $form = $this->createForm(CarriersType::class, $carrier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            //dd($task);
            $entityManager = $this->getDoctrine()->getManager();
            $file = $carrier->getCarrierLogo();
            if (!is_null($file)) {
                $carrier->setCarrierLogo($file->getClientOriginalName());
            }
            foreach ($carrier->getCarriersLangs() as $delay) {
            	$delay->setCarrier($carrier);
            	$entityManager->persist($delay);
            }
            $entityManager->persist($carrier);
            $entityManager->flush();
            //Gestion de l'image
            if (!is_null($file)) {
                $path = $this->getParameter('upload_directory') . '/carriers/' . $carrier->getId();
                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }
                $filename = $carrier->getCarrierLogo();
                try {
                    $file->move($path, $filename);
                } catch (FileException $e) {
                    die($e);
                }
            }

            // S'il existe déjà un transporteur par défaut, on lui retire ce statut si le nouveau est défini aussi par défaut
            if ($carrier->getCarrierDefault()) {
                if (!is_null($ifExistDefault)) {
                    $carrierDefault = $repoCarriers->find($ifExistDefault);
                    $carrierDefault->setCarrierDefault(false);
                    $entityManager->persist($carrier);
                    $entityManager->flush();
                }
            }

            $this->addFlash(
                'success',
                "Ajout du nouveau transporteur réussi."
            );

            return $this->redirectToRoute('carriers_index');
        }

        return $this->render('admin/carriers/new.html.twig', [
            'carrier' => $carrier,
            'form' => $form->createView(),
            'NavCarrierOpen' => true
        ]);
    }

    /**
     * @Route("/{id}/edit", name="carriers_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MgCarriers $carrier, DeleteItems $deleteItems, MgCarriersRepository $repoCarriers)
    {
        $img = $carrier->getCarrierLogo();//On vérifie s'il existe un transporteur par défaut
        $ifExistDefault = $repoCarriers->findOneBy(['carrier_default' => true]);
        $form = $this->createForm(CarriersType::class, $carrier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $file = $carrier->getCarrierLogo();
            if ($request->get('dellLogo') == 'on') {
                //Si une image existe déjà, on la supprime
                if(!is_null($img)) {
                    $deleteItems->deleteDirectoryAndHisFiles($this->getParameter('upload_directory') . '/carriers/' . $carrier->getId() . '/');
                }
            } else {
                if (!is_null($file)) {
                    //Si une image existe déjà, on la supprime
                    if(!is_null($img)) {
                        $deleteItems->deleteDirectoryAndHisFiles($this->getParameter('upload_directory') . '/carriers/' . $carrier->getId() . '/');
                    }
                    //On charge l'image sélectionné
                    $carrier->setCarrierLogo($file->getClientOriginalName());
                } else {
                    $carrier->setCarrierLogo($img);
                }             
            }

            foreach ($carrier->getCarriersLangs() as $delay) {
                $delay->setCarrier($carrier);
                $entityManager->persist($delay);
            }
            $entityManager->persist($carrier);
            $entityManager->flush();
            //Gestion de l'image
            if (!is_null($file)) {
                $path = $this->getParameter('upload_directory') . '/carriers/' . $carrier->getId();
                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }
                $filename = $carrier->getCarrierLogo();
                try {
                    $file->move($path, $filename);
                } catch (FileException $e) {
                    die($e);
                }
            }
            $this->addFlash(
                'success',
                "Modification réussie !"
            );

            // S'il existe déjà un transporteur par défaut, on lui retire ce statut si le nouveau est défini aussi par défaut
            if ($carrier->getCarrierDefault()) {
                if (!is_null($ifExistDefault) && $carrier->getId() != $ifExistDefault->getId()) {
                    $carrierDefault = $repoCarriers->find($ifExistDefault);
                    $carrierDefault->setCarrierDefault(false);
                    $entityManager->persist($carrier);
                    $entityManager->flush();
                }
            }

            return $this->redirectToRoute('carriers_index');
        }

        return $this->render('admin/carriers/edit.html.twig', [
            'carrier' => $carrier,
            'form' => $form->createView(),
            'NavCarrierOpen' => true
        ]);
    }

    /**
     * @Route("/{id}", name="carriers_delete", methods={"DELETE"})
     */
    public function delete(Request $request, MgCarriers $carrier): Response
    {
        if ($this->isCsrfTokenValid('delete'.$carrier->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($carrier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('carriers_index');
    }
}
