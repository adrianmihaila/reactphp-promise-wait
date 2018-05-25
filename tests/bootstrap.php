<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use React\Promise\Deferred;

/**
 * Class BaseTestCase
 */
class BaseTestCase extends TestCase {

    protected function createPromiseResolved($value = null) {
        $deferred = new Deferred();

        sleep(5);
        $deferred->resolve($value);

        return $deferred->promise();
    }

    protected function createPromiseRejected($value = null) {
        $deferred = new Deferred();

        sleep(5);
        $deferred->reject($value);

        return $deferred->promise();
    }
}