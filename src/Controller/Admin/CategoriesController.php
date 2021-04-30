<?php

namespace App\Controller\Admin;

use App\Entity\MgCategories;
use App\Form\CategoriesType;
use App\Repository\MgCategoriesRepository;
use App\Services\TreeStructure;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/categories")
 */
class CategoriesController extends AbstractController
{
    /**
     * @Route("/{type}/{parent<\d+>?1}", name="categories_index", methods={"GET"})
     */
    public function index(MgCategoriesRepository $categoriesRepository, string $type, $parent): Response
    {
        $categories = $categoriesRepository->findBy(['parent' => $parent, 'type' => $type], ['position' => 'ASC']);

        // Création du fil d'ariane
        $filAriane = [];
        $parentID = $parent;
        while ($parentID != 1) {
            $getParent = $categoriesRepository->findOneBy(['id' => $parentID]);
            /*foreach ($getParent->getContents() as $v) {
                if ($v->getLang() == $languages->languageDefault()) {
                    $filAriane[$parentID] = $v->getName();
                }
            }*/
            $filAriane[$parentID] = $getParent->getName();
            $parentID = $getParent->getParent()->getId();
        }
        $filAriane = array_reverse($filAriane, true);

        //Construction de l'affichage par arborescence
        $treeStructure = $categoriesRepository->findBy(['type' => $type], ['position' => 'ASC']);

        //Comptage du nombre d'enfant pour une catégorie
        $children = [];//Tableau pour compter les enfants
        foreach ($categories as $value) {
            $catChildren = $categoriesRepository->findBy(['parent' => $value->getId()]);
            $children[$value->getId()] = count($catChildren);
        }

        if ($type == 'product') {
            $NavContentOpen = 'NavCatalogOpen';
        } else {
            $NavContentOpen = 'NavContentPostOpen';
        }
        return $this->render('admin/categories/index.html.twig', [
            'categories' => $categories,
            'type' => $type,
            'filAriane' => $filAriane,
            'children' => $children,
            'parent' => $parent,
            'treeStructure' => $treeStructure,
            $NavContentOpen => true
        ]);
    }

    /**
     * @Route("/new/{type}", name="categories_new", methods={"GET","POST"})
     */
    public function new(Request $request, $type, MgCategoriesRepository $categoriesRepository, TreeStructure $tree): Response
    {
        $category = new MgCategories();

        //Création de l'arborescence pour améliorer
        //la présentation de choix de catégorie parente
        $categories = $categoriesRepository->findByType($type);
        $array = [];
        foreach ($categories as $cat) {
            $enfant = $categoriesRepository->findOneById($cat->getParent());
            //dd($enfant);
            /*$principal = $categoriesRepository->findOneById($cat->getId());
            foreach($principal->getContents() as $content) {
                if ($content->getLang()->getId() == 1) {
                    $lang = $content->getName();
                    break;
                }
            }*/
            $array[] = [
                'parent' => !is_null($enfant) ? $enfant->getId() : 0,
                'id' => $cat->getId(),
                'nom' => $cat->getName()
            ];
        }
        //dd($array);
        $arborescence = $tree->treeStructure(1, 0, $array, '—');
        $checkbox = [];
        $checkbox[''] = $categoriesRepository->find(1);
        foreach ($arborescence as $key => $value) {
            $checkbox[$key] = $categoriesRepository->find($value);
        }

        $form = $this->createForm(CategoriesType::class, $category, ['checkbox' => $checkbox]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            //Attribution du niveau
            $level = $categoriesRepository->setLevel($category->getParent());
            //Attribution de la position
            $position = $categoriesRepository->setPosition($form->getData()->getParent(), $type);
            // Si la catégorie parent n'est pas la racine...
            if ($form->getData()->getParent()->getId() != 1) {
                //...Il faudra éventuellement mettre à jour la position de plusieurs catégories enfants
                $fetchCategories = $categoriesRepository->setPositionCascad($position, null, $type);
                foreach ($fetchCategories as $updatePosition) {
                    $newPosition = $updatePosition->getPosition() + 1;
                    $updatePosition->setPosition($newPosition);
                    $entityManager->persist($updatePosition);
                }
            }
            $category->setPosition($position);
            $category->setType($type);
            $category->setLevel($level);
            $entityManager->persist($category);
            //$category->setSlug($category->getName() . '-' . $category->getId());
            $entityManager->flush();

            $this->addFlash(
                'success', 'Création réussie !'
            );

            return $this->redirectToRoute('categories_index', ['type' => $type]);
        }

        if ($type == 'product') {
            $NavContentOpen = 'NavCatalogOpen';
        } else {
            $NavContentOpen = 'NavContentPostOpen';
        }

        return $this->render('admin/categories/new.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
            'type' => $type,
            $NavContentOpen => true
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categories_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MgCategories $category, MgCategoriesRepository $categoriesRepository, TreeStructure $tree): Response
    {
        $type = $category->getType();
        $parent = $category->getParent()->getId();
        $thisLevel = $category->getLevel();
        $thisPosition = $category->getPosition();
        //Création de l'arborescence pour améliorer
        //la présentation de choix de catégorie parente
        $categories = $categoriesRepository->findByType($category->getType());
        $array = [];
        foreach ($categories as $cat) {
            $enfant = $categoriesRepository->findOneById($cat->getParent());
            $principal = $categoriesRepository->findOneById($cat->getId());
            /*foreach($principal->getContents() as $content) {
                if ($content->getLang()->getId() == 1) {
                    $lang = $content->getName();
                    break;
                }
            }*/
            $array[] = [
                'parent' => !is_null($enfant) ? $enfant->getId() : 0,
                'id' => $cat->getId(),
                'nom' => $cat->getName()
            ];
        }
        $arborescence = $tree->treeStructure(1, 0, $array, '—');
        $checkbox = [];
        $checkbox[''] = $categoriesRepository->find(1);
        foreach ($arborescence as $key => $value) {
            $checkbox[$key] = $categoriesRepository->find($value);
        }
        $form = $this->createForm(CategoriesType::class, $category, ['checkbox' => $checkbox]);
        $form->handleRequest($request);
        //Initialisation de la variable qui indiquera s'il faudra mettre à jour plusieurs position après cet enregistrement.
        $updatePositionCascad = false;

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            //Si le parent a changé, il faudra redéfinir des positions
            if ($form->getData()->getParent()->getId() != $parent) {
                $updatePositionCascad = true;
                // mise à jour du niveau
                $level = $categoriesRepository->setLevel($category->getParent());
                $category->setLevel($level);
            }
            $entityManager->flush();

            if ($updatePositionCascad) {
                $position = 1;
                $categoriesRepository->fetchChildren(1, $type);
                foreach ($categoriesRepository->getChildren() as $value) {
                    $value->setPosition($position);
                    $entityManager->persist($value);
                    ++$position;
                }
                $entityManager->flush();
            }
            //$this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success', 'Modification réussie !'
            );

            return $this->redirectToRoute('categories_index', ['type' => $type]);
        }

        return $this->render('admin/categories/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
            'type' => $category->getType(),
        ]);
    }

    /**
     * @Route("/{id}/update-position/{update}", name="categories_position_edit", methods={"GET","POST"})
     */
    public function updatePosition(Request $request, $update, MgCategories $category, MgCategoriesRepository $categoriesRepository)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $parent = $category->getParent()->getId();
        //On récupère la position actuel de la catégorie
        if ($update == 'down' || $update == 'up') {
            $updatePosition = $categoriesRepository->switchPosition($category, $update);
            foreach ($updatePosition as $id => $newPosition) {
                $upCategory = $categoriesRepository->find($id);
                $upCategory->setPosition($newPosition);
                $entityManager->persist($upCategory);
            }
            $entityManager->flush();
        }

        return $this->redirectToRoute('categories_index', ['type' => $category->getType(), 'parent' => $parent]);
    }

    /**
     * @Route("/{id}", name="categories_delete", methods={"DELETE"})
     */
    public function delete(Request $request, MgCategories $category, MgCategoriesRepository $categoriesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $type = $category->getType();
            
            //On remonte d'un cran les enfants de la catégorie
            $children = $categoriesRepository->findByParent($category);
            foreach ($children as $child) {
                $child->setParent($category->getParent());
                $newLevel = $categoriesRepository->setLevel($category->getParent());
                $child->setLevel($newLevel);
                $entityManager->persist($child);
            }
            $entityManager->remove($category);
            $entityManager->flush();

            //On remet à jour toute sles positions
            $position = 1;
            $categoriesRepository->fetchChildren(1, $type);
            foreach ($categoriesRepository->getChildren() as $value) {
                $value->setPosition($position);
                $entityManager->persist($value);
                ++$position;
            }
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Suppression réussie.'
            );
        }

        return $this->redirectToRoute('categories_index', ['type' => $category->getType()]);
    }
}
