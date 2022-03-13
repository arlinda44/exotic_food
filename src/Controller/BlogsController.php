<?php

namespace App\Controller;

use App\Entity\Blogs;
use App\Form\BlogsType;
use App\Repository\BlogsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blogs")
 */
class BlogsController extends AbstractController
{
    /**
     * @Route("/", name="app_blogs_index", methods={"GET"})
     */
    public function index(BlogsRepository $blogsRepository): Response
    {
        return $this->render('blogs/index.html.twig', [
            'blogs' => $blogsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_blogs_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BlogsRepository $blogsRepository): Response
    {
        $blog = new Blogs();
        $form = $this->createForm(BlogsType::class, $blog);
        $form->handleRequest($request);
$user= $this->getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            $blog->setUser($user);
            $blogsRepository->add($blog);
            return $this->redirectToRoute('app_blogs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('blogs/new.html.twig', [
            'blog' => $blog,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_blogs_show", methods={"GET"})
     */
    public function show(Blogs $blog): Response
    {
        return $this->render('blogs/show.html.twig', [
            'blog' => $blog,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_blogs_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Blogs $blog, BlogsRepository $blogsRepository): Response
    {
        $form = $this->createForm(BlogsType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $blogsRepository->add($blog);
            return $this->redirectToRoute('app_blogs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('blogs/edit.html.twig', [
            'blog' => $blog,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_blogs_delete", methods={"POST"})
     */
    public function delete(Request $request, Blogs $blog, BlogsRepository $blogsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$blog->getId(), $request->request->get('_token'))) {
            $blogsRepository->remove($blog);
        }

        return $this->redirectToRoute('app_blogs_index', [], Response::HTTP_SEE_OTHER);
    }
}
