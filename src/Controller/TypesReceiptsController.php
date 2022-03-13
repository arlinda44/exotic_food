<?php

namespace App\Controller;

use App\Entity\TypesReceipts;
use App\Form\TypesReceiptsType;
use App\Repository\TypesReceiptsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/types/receipts")
 */
class TypesReceiptsController extends AbstractController
{
    /**
     * @Route("/", name="app_types_receipts_index", methods={"GET"})
     */
    public function index(TypesReceiptsRepository $typesReceiptsRepository): Response
    {
        return $this->render('types_receipts/index.html.twig', [
            'types_receipts' => $typesReceiptsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_types_receipts_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TypesReceiptsRepository $typesReceiptsRepository): Response
    {
        $typesReceipt = new TypesReceipts();
        $form = $this->createForm(TypesReceiptsType::class, $typesReceipt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typesReceiptsRepository->add($typesReceipt);
            return $this->redirectToRoute('app_types_receipts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('types_receipts/new.html.twig', [
            'types_receipt' => $typesReceipt,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_types_receipts_show", methods={"GET"})
     */
    public function show(TypesReceipts $typesReceipt): Response
    {
        return $this->render('types_receipts/show.html.twig', [
            'types_receipt' => $typesReceipt,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_types_receipts_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TypesReceipts $typesReceipt, TypesReceiptsRepository $typesReceiptsRepository): Response
    {
        $form = $this->createForm(TypesReceiptsType::class, $typesReceipt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typesReceiptsRepository->add($typesReceipt);
            return $this->redirectToRoute('app_types_receipts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('types_receipts/edit.html.twig', [
            'types_receipt' => $typesReceipt,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_types_receipts_delete", methods={"POST"})
     */
    public function delete(Request $request, TypesReceipts $typesReceipt, TypesReceiptsRepository $typesReceiptsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typesReceipt->getId(), $request->request->get('_token'))) {
            $typesReceiptsRepository->remove($typesReceipt);
        }

        return $this->redirectToRoute('app_types_receipts_index', [], Response::HTTP_SEE_OTHER);
    }
}
