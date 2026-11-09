<?php

namespace App\Controller;

use App\Entity\Coaster;
use App\Repository\CoasterRepository;
use App\Form\CoasterType;
use App\Service\DescriptionGeneratorService;
use Doctrine\ORM\EntityManagerInterface;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CoasterController extends AbstractController {

#[route('/coaster/', name: 'app_coaster_index')]

public function chapeau(CoasterRepository $repository) : Response
{

    return $this->render('coaster/index.html.twig' , [
        'coasters' => $repository->findAll()
    ]);

}


#[route('/coaster/add' , name: 'app_coaster_add')]
public function add( Request $request, EntityManagerInterface $em): Response
{
    // ...
    $entity = new Coaster();
    $form = $this->createForm(CoasterType::class, $entity);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($entity);
        $em->flush();

        return $this->redirectToRoute('app_coaster_index');
    }

    return $this->render('coaster/add.html.twig', [
        'coasterForm' => $form,
    ]);
}


#[route('/coaster/{id}/edit' , name: 'app_coaster_edit')]
public function edit( Coaster $coaster, Request $request, EntityManagerInterface $em): Response
{
    // ...
    $form = $this->createForm(CoasterType::class, $coaster);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($coaster);
        $em->flush();

        return $this->redirectToRoute('app_coaster_index');
    }

    return $this->render('coaster/edit.html.twig', [
        'coasterForm' => $form,
    ]);
}

#[route('/coaster/{id}/delete' , name: 'app_coaster_delete')]
public function delete( Coaster $coaster, Request $request, EntityManagerInterface $em): Response
{
    // ...
    $form = $this->createForm(CoasterType::class, $coaster);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($coaster);
        $em->flush();

        return $this->redirectToRoute('app_coaster_index');
    }

    return $this->render('coaster/delete.html.twig', [
        'coaster' => $coaster,
    ]);
}

#[route('/coaster/{id}/generate-description', name: 'app_coaster_generate')]
public function generateDescription(Coaster $coaster, EntityManagerInterface $em, DescriptionGeneratorService $dgs): Response
{
    $dgs->generateForCoaster($coaster);
    $em->flush();

    return $this->redirectToRoute('app_coaster_index')

}

}