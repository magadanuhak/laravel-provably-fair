# magadanuhak/laravel-provably-fair

Laravel ProvablyFair is a package that permits to generate random numbers using clientSeed - a string from frontend and serverSeed - a string from backend.

<p align="center">
<a href="https://packagist.org/packages/magadanuhak/laravel-provably-fair"><img src="https://img.shields.io/packagist/dt/magadanuhak/laravel-provably-fair" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/magadanuhak/laravel-provably-fair"><img src="https://img.shields.io/packagist/v/magadanuhak/laravel-provably-fair" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/magadanuhak/laravel-provably-fair"><img src="https://img.shields.io/packagist/l/magadanuhak/laravel-provably-fair" alt="License"></a>
</p>


If you know clientSeed, serverSeed and nonce you can generate the same random number.
Nonce is a countable number that is used to count how much times the same clientSeed and serverSeed was used.

## Installation

Use the composer package manager [composer](https://getcomposer.org/download/) to install package.

```bash
composer require magadanuhak/laravel-provably-fair
```

Usage
```php 
    $provablyFairService = new ProvablyFair(); //Initialization of provably fair
    $clientSeed = $request->client_seed; // Client seed is a string that you should get from frontend
    $resultedData = $provablyFairService->getRandomNumber($clientSeed); // This method will return an object ProvablyFairResultData
```
Result of `getRandomNumber($clientSeed);` will be 
```php
class ProvablyFairResultData
{
    public function __construct(
        public readonly string $clientSeed,
        public readonly string $serverSeed,
        public readonly int    $nonce,
        public readonly float  $resultedNumber,
        public readonly float  $minimalValue,
        public readonly float  $maximalValue,
    )
    {
    }
}
```
Now you can store this data in database, return to the user.
Here is an example of getting an item from a collection by chance
```php
class GetRandomWeapon {

    public function chances(): Collection
    {
        return collect([
            "Ak-47" => 45,
            "Mp-40" => 50,
            "AWM" => 5,
        ]);
    } 

    public function getItem(): string //Returns won Item Name 
    {
        $sum = 0;

        $provablyFairService = new ProvablyFair(); //Initialization of provably fair
        $clientSeed = $request->client_seed; // Client seed is a string that you should get from frontend
        $resultedData = $provablyFairService->getRandomNumber($clientSeed);  // This method will return an object ProvablyFairResultData
//      $resultedData = $provablyFairService->getRandomNumber($clientSeed, $serverSeed, $nonce);  // $serverSeed, $nonce are optionally This method will return an object ProvablyFairResultData

        $choice = $resultedData->resultedNumber;

        return app(
            $this->chances()
                ->map(function ($value, $item) use (&$sum) {
                    $sum += $value;
                    return $sum;
                })
                ->reduce(function ($result, $value, $key) use ($choice) {
                    if (is_string($result)) {
                        return $result;
                    }

                    if ($choice <= $value) {
                        return $key;
                    }

                    return $result + $value;
                }, 0)
        );
    }
}
```

By defaul `ProvablyFair::class` is binded to `ProvablyFairContract::class`
You can use Laravel Service Container Dependency Injection to use ProvablyFair in your Laravel project
```php
class GetRandomItemByChance {
    
    public function __construct(
        ProvablyFairContract $provablyFair
    )
    {}

    public function getProvablyFairResult(string $clientSeed): ProvablyFairResultData
    {
        return $this->provablyFair->getRandomNumber($clientSeed);
    }
}
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](https://choosealicense.com/licenses/mit/)





