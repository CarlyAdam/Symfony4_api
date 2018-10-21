<?php


namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;

class BookController extends ApiController

{

   /**
     * List the books.
     * @Route("/api/books", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Return books",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Book::class, groups={"full"}))
     *     )
     * )
     */
    public function index(BookRepository $bookRepository)
    {
        $books= $bookRepository->transformAll();

        return $this->respond($books);
    }

   /**
     * Create new book.
     * @Route("/api/books", methods={"POST"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns books",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Book::class, groups={"full"}))
     *     )
     * )
     * @SWG\Parameter(
     *     name="name",
     *     in="query",
     *     type="string",
     *     description="The name of the book"
     * )
     */
    public function create(Request $request, BookRepository $bookRepository, EntityManagerInterface $em)
    {
        if (! $request->get('name')) {
            return $this->respondValidationError('Please provide a name!');
        }

        // persist the new book
        $book = new Book;
        $book->setName($request->get('name'));
        $em->persist($book);
        $em->flush();

        return $this->respondCreated($bookRepository->transform($book));
    }

    


}