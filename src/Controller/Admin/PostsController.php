<?php

namespace App\Controller\Admin;

use App\Entity\MgPosts;
use App\Form\PostsType;
use App\Repository\MgCategoriesRepository;
use App\Repository\MgPostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/posts")
 */
class PostsController extends AbstractController
{
    /**
     * @Route("/{role}", name="posts_index", methods={"GET"})
     * @Route("/{role}/status/{status}", name="posts_index_status", methods={"GET"})
     */
    public function index(MgPostsRepository $postsRepository, $role, $status = false): Response
    {
        //Si aucun status n'est demandé, on récupère tous les posts
        if (!$status) {
            $posts = $postsRepository->findBy(['type' => $role, 'status' => ['publish', 'draft']], ['id' => 'DESC']);
        } else {
            $posts = $postsRepository->findBy(['type' => $role, 'status' => $status], ['id' => 'DESC']);
        }
        $published = $postsRepository->findBy(['type' => $role, 'status' => 'publish']);
        $draft = $postsRepository->findBy(['type' => $role, 'status' => 'draft']);
        $trash = $postsRepository->findBy(['type' => $role, 'status' => 'trash']);

        if ($role == 'page') {
            $NavContentOpen = 'NavContentPageOpen';
        } else {
            $NavContentOpen = 'NavContentPostOpen';
        }
        return $this->render('admin/posts/index.html.twig', [
            'posts' => $posts,
            'role' => $role,
            'published' => $published,
            'draft' => $draft,
            'trash' => $trash,
            $NavContentOpen => true
        ]);
    }
 
    /**
     * @Route("/new/{role}", name="posts_new", methods={"GET","POST"})
     */
    public function new($role, Request $request, MgPostsRepository $postsRepository, MgCategoriesRepository $categoriesRepository): Response
    {
        $post = new MgPosts();
        if ($role == $post::PAGE) {
            $chooseParent = $postsRepository->findAllByArborescence();
        } elseif ($role == $post::POST) {
            $chooseParent = [];
        }
        $form = $this->createForm(PostsType::class, $post, ['checkbox' => $chooseParent, 'role' => $role]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            //Si c'est une page, on donne la position par rapport à la dernière donnée
            if ($role == $post::PAGE) {
                $post->setSort($postsRepository->setPosition($post->getParent()));
            }
            //Si c'est un post, on gère les catégories
            if ($role == $post::POST) {
                //Si aucune catégorie n'est sélectionné, on attribue 'Non classé' (racine) par défaut
                if(count($post->getCategory()) == 0) {
                    $post->addCategory($categoriesRepository->find(2));
                } else {
                    //Sinon, on attribue les catégories sélectionnée
                    foreach ($post->getCategory() as $category) {
                        //$cat = $repoCat->findOneById($category);
                        $cat = $categoriesRepository->find($category);
                        $post->addCategory($cat);
                    }
                }
            }
            // Auteur de la page
            $post->setAuthor($this->getUser());
            // Status de la page
            if ($form->get('post_draft')->isClicked()) {
                $post->setStatus('draft');
            } elseif ($form->get('post_view')->isClicked()) {
                $post->setStatus('draft');
            } elseif ($form->get('post_publish')->isClicked()) {
                $post->setStatus('publish');
            }
            // Type de la page
            $post->setType($role);

            $entityManager->persist($post);
            $entityManager->flush();
            $this->addFlash(
                'success',
                "Ajout réussi !"
            );

            return $this->redirectToRoute('posts_edit', ['id' => $post->getId()]);
        }

        if ($role == 'page') {
            $NavContentOpen = 'NavContentPageOpen';
        } else {
            $NavContentOpen = 'NavContentPostOpen';
        }

        return $this->render('admin/posts/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
            'role' => $role,
            $NavContentOpen => true
        ]);
    }

    /**
     * @Route("/{id}/edit", name="posts_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MgPosts $post, MgPostsRepository $postsRepository, MgCategoriesRepository $categoriesRepository): Response
    {
        $role = $post->getType();
        $id = $post->getId();
        $sauvPost = clone $post;
        if ($role == $post::PAGE) {
            $chooseParent = $postsRepository->findAllByArborescence();
        } elseif ($role == $post::POST) {
            $chooseParent = [];
        }
        /*$checkRevision = $postsRepository->findOneBy(['parent' => $post], ['id' => 'DESC']);
        if (!is_null($checkRevision)) {
            $post = $checkRevision;
        }*/

        $form = $this->createForm(PostsType::class, $post, ['checkbox' => $chooseParent, 'role' => $role]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            if ($role == $post::POST) {
                //Si aucune catégorie n'est sélectionné, on attribue 'Non classé' (racine) par défaut
                if(count($post->getCategories()) == 0) {
                    $post->addCategory($categoriesRepository->find(2));
                }
            }

            if ($form->get('post_draft')->isClicked()) {
                $post->setStatus($post::DRAFT);
            } elseif ($form->get('post_view')->isClicked()) {
                $post->setStatus($post::DRAFT);
            } elseif ($form->get('post_publish')->isClicked()) {
                $post->setStatus($post::PUBLISH);
            }

            if ($task->getCategories() == $sauvPost->getCategories() && $task->getTitle() == $sauvPost->getTitle() && $task->getContent() == $sauvPost->getContent() && $task->getParent() == $sauvPost->getParent() && $task->getComment() == $sauvPost->getComment() && $task->getDatePublish() == $sauvPost->getDatePublish() && $task->getDateExpire() == $sauvPost->getDateExpire() && $task->getRelationPages() == $sauvPost->getRelationPages()) {
            } else {
                $post->setAuthor($this->getUser());
                $entityManager->persist($post);
                $entityManager->flush();

                $newPost = $sauvPost;
                $newPost->setType($newPost::REVISION);
                $newPost->setParent($post);
                $entityManager->persist($newPost);
                $entityManager->flush();
                //$id = $newPost->getId();
            }
            $this->addFlash(
                'success',
                "Modification réussie !"
            );

            return $this->redirectToRoute('posts_edit',['id' => $id]);
        }

        if ($role == 'page') {
            $NavContentOpen = 'NavContentPageOpen';
        } else {
            $NavContentOpen = 'NavContentPostOpen';
        }

        return $this->render('admin/posts/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
            'role' => $role,
            $NavContentOpen => true
        ]);
    }

    /**
     * @Route("/{id}", name="posts_delete", methods={"DELETE"})
     */
    public function delete(Request $request, MgPosts $post): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('posts_index');
    }
}
