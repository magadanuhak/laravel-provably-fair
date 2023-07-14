<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Magadanuhak\ProvablyFair\Services\ProvablyFair;

final class ProvablyFairTest extends TestCase
{
    public function testProvablyFairGeneratesARandomNumber(): void
    {
        $provablyFairService = new ProvablyFair();

        $clientSeed = 'thisStringIsASeedForProvablyFair000';

        $result = $provablyFairService->getRandomNumber(clientSeed: $clientSeed);

        $this->assertTrue($result->clientSeed === $clientSeed, 'Client Seed is the same');

        $verificationResult = $provablyFairService->verify(
            result: $result->resultedNumber,
            clientSeed: $clientSeed,
            serverSeed: $result->serverSeed,
            nonce: $result->nonce
        );

        $this->assertTrue($verificationResult, 'Check if provably fair number is legit');
    }
}
