# ReactPHP promise/wait [![Build Status](https://travis-ci.org/adrianmihaila/reactphp-promise-wait.svg?branch=master)](https://travis-ci.org/adrianmihaila/reactphp-promise-wait)

This lightweight library provides a wait functionality for ReactPHP/promise library.

## Installation
```
composer require adimihaila/promise-wait
```

## Usage
```
<?php

use React\Promise\Deferred;

function doAsyncSomething() {
    $deferred = new Deferred();
    $deferred->resolve($value);

    return $deferred->promise();
}

$value = doAsyncSomething()
    ->then(function ($response) {
        sleep(5);
        
        return $response++;
    });
    
echo \React\Promise\wait($value);
```