## Exceptions

## Initialize

- config/app.php

```php
'providers' => [
    // ...
    AIGenerate\Services\Exceptions\ExceptionServiceProvider::class
];
```

- app/Exceptions/Handler.php

```php
public function __construct(
    Container                  $container,
    protected ExceptionService $service
) {
    parent::__construct($container);
}
    
public function register(): void
{
    $this->reportable(function (Throwable $throwable) {
        $this->service->log($throwable);
    });
    
    // ...
}
```