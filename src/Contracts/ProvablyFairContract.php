<?php

declare(strict_types=1);

namespace Magadanuhak\ProvablyFair\Contracts;

use Magadanuhak\ProvablyFair\Data\ProvablyFairResultData;

interface ProvablyFairContract
{
    public function getRandomNumber(string $clientSeed): ProvablyFairResultData;

    public function verify(float $result, string $clientSeed, string $serverSeed, int $nonce): bool;
}
