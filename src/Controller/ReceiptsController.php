<?php

namespace App\Controller;

use App\Entity\Receipts;
use App\Form\ReceiptsType;
use App\Repository\ReceiptsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * @Route("/receipts")
 */
class ReceiptsController extends AbstractController
{
    /**
     * @Route("/", name="app_receipts_index", methods={"GET"})
     */
    public function index(ReceiptsRepository $receiptsRepository): Response
    {
        return $this->render('receipts/index.html.twig', [
            'receipts' => $receiptsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_receipts_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ReceiptsRepository $receiptsRepository, SluggerInterface $slugger): Response
    {
        $receipt = new Receipts();
        $form = $this->createForm(ReceiptsType::class, $receipt);
        $form->handleRequest($request);
        $user = $this->getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            $pictureReceipt  = $form->get('pictureReceipt')->getData();
            if ($pictureReceipt) {
                $originalFilename = pathinfo($pictureReceipt->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $pictureReceipt->guessExtension();
                try {
                    $pictureReceipt->move($this->getParameter('photos_directory'),                         $newFilename);
                } catch (FileException $e) {
                }
                $receipt->setPictureReceipts($newFilename);
            }
            $receipt->setUser($user);
            $receiptsRepository->add($receipt);
            return $this->redirectToRoute('app_receipts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('receipts/new.html.twig', [
            'receipt' => $receipt,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_receipts_show", methods={"GET"})
     */
    public function show(Receipts $receipt): Response
    {
        return $this->render('receipts/show.html.twig', [
            'receipt' => $receipt,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_receipts_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Receipts $receipt, ReceiptsRepository $receiptsRepository): Response
    {
        $form = $this->createForm(ReceiptsType::class, $receipt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $receiptsRepository->add($receipt);
            return $this->redirectToRoute('app_receipts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('receipts/edit.html.twig', [
            'receipt' => $receipt,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_receipts_delete", methods={"POST"})
     */
    public function delete(Request $request, Receipts $receipt, ReceiptsRepository $receiptsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $receipt->getId(), $request->request->get('_token'))) {
            $receiptsRepository->remove($receipt);
        }

        return $this->redirectToRoute('app_receipts_index', [], Response::HTTP_SEE_OTHER);
    }
}
