<?php


namespace App\Controller;


use App\Entity\Contact;
use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\ContactType;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use App\Service\ContactService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
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
     * @Route("/Property",name="property.index")
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
//        $property = new Property();
//        $property->setTitle("LaFrance")
//            ->setDescription("Building luxury")
//            ->setCity("Montreal")
//            ->setBedrooms(3)
//            ->setRooms(5)
//            ->setHeat(1)
//            ->setPostalCode("H3W1B7")
//            ->setPrice(2500000)
//            ->setSurface(60)
//            ->setFloor(5);
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($property);
//        $em->flush();

//        $repository = $this->getDoctrine()->getRepository(Property::class);
//        dump($repository);
//        $property = $this->repository->getAllSoldFalse();
//        dump($property);
//
//        $property[0]->setSold(true);
//        $this->em->flush();
//        dump($property);
        #$property = $this->repository->find(1);
        #dump($property->getSlug());
        #$properties = $this->repository->getAllSoldFalse();

        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class,$search);
        $form->handleRequest($request);


        $properties = $paginator->paginate($this->repository->getAllSoldFalse($search),
            $request->query->getInt('page', 1),
            12);
        return $this->render("property/index.html.twig",
            ['current_page' => 'property',
                'properties' => $properties,
                'form' => $form->createView()

            ]);
    }

    /**
     * @param Property $property
     * @param string $slug
     * @return Response
     * @Route("/Property/{slug}-{id}", name="property.show", requirements={"slug":"[a-zA-Z0-9\-]*"})
     */
    public function show(Property $property, string $slug, Request $request, ContactService $contactService): Response
    {
        #$property = $this->repository->find($id);



        if($property->getSlug() !== $slug) {
            return $this->redirectToRoute("property.show", [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ],301);
        }

        $contact = new Contact();
        $contact->setProperty($property);
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $contactService->notify($contact);
            $this->addFlash("success", "Message envoyer avec success");
            return $this->redirectToRoute("property.show", [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ]);
        }

        return $this->render("property/show.html.twig",[
            'current_page' => 'property',
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

}