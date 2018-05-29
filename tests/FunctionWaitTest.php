<?php

require_once __DIR__ . '/../src/functions.php';

use React\Promise\PromiseInterface;

/**
 * Class FunctionWaitTest
 */
class FunctionWaitTest extends BaseTestCase {

    public function testWaitResolved() {
        $promise = $this->createPromiseResolved(rand(1, 9));
        $result = $promise->then(function ($value) {
            sleep(5);

            return $value * 2;
        });

        $this->assertInstanceOf(PromiseInterface::class, $result);

        $value = \AdiMihaila\Promise\wait($result);

        $this->assertNotInstanceOf(PromiseInterface::class, $value);
        $this->assertTrue(is_int($value));
    }

    public function testWaitRejected() {
        $promise = $this->createPromiseRejected(new Exception('test exception'));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('test exception');

        $value = \AdiMihaila\Promise\wait($promise);
    }

    public function testWaitRejectedWithNullWillThrowsUnexpectedValueException() {
        $promise = $this->createPromiseRejected(null);

        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('Promise rejected with unexpected value of type NULL');

        $value = \AdiMihaila\Promise\wait($promise);
    }
}