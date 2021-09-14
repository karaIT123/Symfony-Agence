<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use App\Service\FileUploader;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class AdminPropertyController extends AbstractController {

    /**
     * @var PropertyRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $em;


    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin",name="admin.property.index")
     * @return Response
     */
    public function index(): Response
    {
        $properties = $this->repository->findAll();
        return $this->render("admin/property/index.html.twig", compact("properties"));
    }

    /**
     * @Route("/admin/property/create", name="admin.property.new")
     */
    public function new(Request $request, FileUploader $uploader)
    {
        $property = new Property();
        $form =  $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $file = $form['fileName']->getData();
            if($file)
            {
                $file = $uploader->upload($file);
                $property->setFileName($file);
            }

            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success','Creation effectuer avec success');
            return $this->redirectToRoute('admin.property.index');
        }


        return $this->render("admin/property/new.html.twig", [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id}", name="admin.property.edit", methods={"GET","POST"})
     * @param Property $property
     * @param Request $request
     * @return Response
     */
    public function edit(Property $property, FileUploader $uploader, Request $request): Response
    {
        $form =  $this->createForm(PropertyType::class, $property);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $file = $form['imageFile']->getData();
            if($file)
            {
                $file = $uploader->upload($file);
                $property->setUpdatedAt(new \DateTimeImmutable('NOW'));
                $property->setFileName($file);
            }

            $this->em->flush();
            $this->addFlash('success','Edition effectuer avec success');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render("admin/property/edit.html.twig", [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/delete/{id}", name="admin.property.delete", methods="POST")
     * @param Property $property
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function delete(Property $property,Request $request)
    {

    if($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token')))
    {
        $this->em->remove($property);
        $this->em->flush();
        $this->addFlash('success','Suppression effectuer avec success');
    }
        #dump("suppressing delete");

        return $this->redirectToRoute('admin.property.index');
    }
}