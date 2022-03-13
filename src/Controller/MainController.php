<?php

namespace App\Controller;

use App\Repository\ReceiptsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface; 
use Symfony\Component\HttpFoundation\File\Exception\FileException; 
use Symfony\Component\HttpFoundation\File\UploadedFile; 

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ReceiptsRepository $receiptsRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'receipts' => $receiptsRepository->findAll(),
        ]);
  
    }

    /**
     * @Route("/recettes", name="recipes")
     */
    public function recipes(ReceiptsRepository $receiptsRepository): Response
    
    {
        return $this->render('main/recipes.html.twig', [
            'controller_name' => 'MainController',
            'receipts' => $receiptsRepository->findAll(),
        ]);

    }

    /**
     * @Route("/produits", name="foods")
     */
    public function foods(ReceiptsRepository $receiptsRepository): Response
    {
        return $this->render('food/index.html.twig', [
            'controller_name' => 'MainController',
            'receipts' => $receiptsRepository->findAll(),
        ]);
    }
    /**
     * @Route("/blogs", name="blogs")
     */
     public function blogs(ReceiptsRepository $receiptsRepository): Response

     {
        return $this->render('main/blogs.html.twig', [
            'controller_name' => 'MainController',
            'receipts' => $receiptsRepository->findAll(),
        ]);
  
    
    }
}
