<?php

namespace App\Controller\Admin;

use App\Entity\MgPosts;
use App\Form\PostsType;
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
     * @Route("/", name="posts_index", methods={"GET"})
     */
    public function index(MgPostsRepository $postsRepository): Response
    {
        return $this->render('mg_posts/index.html.twig', [
            'mg_posts' => $postsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="posts_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $post = new MgPosts();
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('posts_index');
        }

        return $this->render('admin/posts/new.html.twig', [
            'mg_post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="posts_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MgPosts $post): Response
    {
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('posts_index');
        }

        return $this->render('admin/posts/edit.html.twig', [
            'mg_post' => $post,
            'form' => $form->createView(),
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
