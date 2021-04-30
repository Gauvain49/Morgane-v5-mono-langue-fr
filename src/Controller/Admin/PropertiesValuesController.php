<?php

namespace App\Controller\Admin;

use App\Entity\MgPropertiesValues;
use App\Form\PropertiesValuesType;
use App\Repository\MgPropertiesRepository;
use App\Repository\MgPropertiesValuesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/properties/values")
 */
class PropertiesValuesController extends AbstractController
{
    /**
     * @Route("/{property}", name="properties_values_index", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function index(MgPropertiesValuesRepository $propertiesValuesRepository, MgPropertiesRepository $propertiesRepository, int $property): Response
    {
        $properties_values = $propertiesValuesRepository->findBy(['property' => $property, 'custom' => false]);
        $properties = $propertiesRepository->findOneBy(['id' => $property]);
        $name_property = $properties->getName();
        return $this->render('admin/properties/values/index.html.twig', [
            'properties_values' => $properties_values,
            'property' => $property,
            'name_property' => $name_property
        ]);
    }

    /**
     * @Route("/{property}/new", name="properties_values_new", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function new(Request $request, int $property, MgPropertiesRepository $propertiesRepository): Response
    {
        $propertiesValue = new MgPropertiesValues();
        $properties = $propertiesRepository->findOneBy(['id' => $property]);
        $propertiesValue->setProperty($properties);
        $form = $this->createForm(PropertiesValuesType::class, $propertiesValue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $property = $task->getProperty()->getId();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($propertiesValue);
            $entityManager->flush();

            return $this->redirectToRoute('properties_values_index', ['property' => $property]);
        }

        return $this->render('admin/properties/values/new.html.twig', [
            'mg_properties_value' => $propertiesValue,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="properties_values_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MgPropertiesValues $propertiesValue): Response
    {
        $form = $this->createForm(PropertiesValuesType::class, $propertiesValue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('properties_values_new');
        }

        return $this->render('admin/properties/values/edit.html.twig', [
            'properties_value' => $propertiesValue,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="properties_values_delete", methods={"DELETE"})
     */
    public function delete(Request $request, MgPropertiesValues $propertiesValue): Response
    {
        if ($this->isCsrfTokenValid('delete'.$propertiesValue->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($propertiesValue);
            $entityManager->flush();
        }

        return $this->redirectToRoute('properties_values_index');
    }
}
