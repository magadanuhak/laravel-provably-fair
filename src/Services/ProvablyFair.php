<?php

namespace Magadanuhak\ProvablyFair\Services;

use Magadanuhak\ProvablyFair\Contracts\ProvablyFairContract;
use Magadanuhak\ProvablyFair\Data\ProvablyFairResultData;
use Illuminate\Support\Str;
use Magadanuhak\ProvablyFair\Exceptions\InvalidHashHmacAlgorithmException;
use Magadanuhak\ProvablyFair\Exceptions\InvalidMinimalAndMaximalValuesException;

class ProvablyFair implements ProvablyFairContract
{

    public function __construct(
        private int            $nonce = 0,
        private float          $minimalValue = 0.00000001,
        private float          $maximalValue = 100.,
        public readonly string $algorithm = 'sha512',
        public readonly int    $bytes = 6,
    )
    {
    }

    public function getRandomNumber(string $clientSeed): ProvablyFairResultData
    {
        $serverSeed = $this->getServerSeed();

        $this->nonce++;

        $resultedNumber = $this->getResultUsingClientSeedAndServerSeed($clientSeed, $serverSeed);

        return new ProvablyFairResultData(
            clientSeed: $clientSeed,
            serverSeed: $serverSeed,
            nonce: $this->nonce,
            resultedNumber: $resultedNumber,
            minimalValue: $this->minimalValue,
            maximalValue: $this->maximalValue,
        );
    }

    private function getServerSeed(): string
    {
        $str = rand();

        return sha1($str);
    }


    private function getResultUsingClientSeedAndServerSeed(string $clientSeed, string $serverSeed): float
    {
        if (!in_array($this->algorithm, hash_hmac_algos())) {
            throw new InvalidHashHmacAlgorithmException('Use a valid Hash HMAC Algorithm');
        }

        if ($this->minimalValue >= $this->maximalValue) {
            throw new InvalidMinimalAndMaximalValuesException("Minimal value is greather or equal with maximal value");
        }

        $hash = hash_hmac($this->algorithm, "{$clientSeed}-{$this->nonce}", $serverSeed);

        $partOfHash = substr($hash, 0, 5);
        $decimal = hexdec($partOfHash);

        return $decimal % (1000000) / 10000;
    }

    public function verify(float $result, string $clientSeed, string $serverSeed, int $nonce): bool
    {
        $resultedNumber = $this->getResultUsingClientSeedAndServerSeed(clientSeed: $clientSeed, serverSeed: $serverSeed);

        return bccomp("{$result}", "{$resultedNumber}", 6) == 0;
    }
}
