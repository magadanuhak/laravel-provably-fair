<?php 

namespace Magadanuhak\ProvablyFair\Data;

class ProvablyFairResultData {
     public function __construct(
          public readonly string $clientSeed,
          public readonly string $serverSeed,
          public readonly int $nonce,
          public readonly float $resultedNumber,
          public readonly float $minimalValue,
          public readonly float $maximalValue,
     )
     {
     }
}