<?php


namespace App\Controller;


use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/Biens",name="property.index")
     * @return Response
     */
    public function index(): Response
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
        $property = $this->repository->find(1);
        dump($property->getSlug());
        return $this->render("property/index.html.twig",
            ['slug' => $property->getSlug(),
            'current_page' => 'property']);
    }

    /**
     * @param Property $property
     * @return Response
     * @Route("/Biens/{slug}-{id}", name="property.show", requirements={"slug":"[a-zA-Z0-9\-]*"})
     */
    public function show(Property $property, string $slug): Response
    {

        #$property = $this->repository->find($id);

        if($property->getSlug() !== $slug) {
            return $this->redirectToRoute("property.show", [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ],301);
        }

        return $this->render("property/show.html.twig",[
            'current_page' => 'property',
            'property' => $property
        ]);
    }

}