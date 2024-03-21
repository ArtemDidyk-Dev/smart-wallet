<?php

namespace App\Tests\Entity;

use App\Entity\Transaction;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TransactionTest extends KernelTestCase
{
    private EntityManager $entityManager;

    public function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();


    }

    public function testTransaction(): void
    {
        $transaction =  $this->entityManager->getRepository(Transaction::class)->find(1);
        dd($transaction);
    }

}