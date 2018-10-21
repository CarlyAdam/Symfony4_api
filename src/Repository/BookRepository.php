<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function transform(Book $book)
        {
        return [
                'id'    => (int) $book->getId(),
                'name' => (string) $book->getName()
         ];
        }

    public function transformAll()
        {
        $books = $this->findAll();
        $booksArray = [];

        foreach ($books as $book) {
            $booksArray[] = $this->transform($book);
          }

        return $booksArray;
        }
}
