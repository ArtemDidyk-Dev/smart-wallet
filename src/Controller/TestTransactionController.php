<?php

namespace App\Controller;

use App\Entity\Transaction;
use Doctrine\ORM\EntityManagerInterface;
use Money\Currency;
use Money\Money;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class TestTransactionController extends AbstractController
{
    #[Route('/test', name: 'test')]
    public function index(EntityManagerInterface $em): JsonResponse
    {
        $transaction = new Transaction();
        $transaction->setAmount(new Money(100, new Currency('USD')));
        $em->persist($transaction);
        $em->flush();

        $transactionFromDb = $em->getRepository(Transaction::class)->find(2);
        if (!$transactionFromDb) {
            return new JsonResponse('Transaction not found');
        }
        $transactionFromDb->setAmount(new Money(200, new Currency('USD')));
        $em->persist($transactionFromDb);
        $em->flush();

        assert($transactionFromDb->getUpdatedAt() !== $transactionFromDb->getCreatedAt());

        return new JsonResponse($transactionFromDb?->getAmount());
    }
}
