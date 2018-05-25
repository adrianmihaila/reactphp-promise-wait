<?php

require_once __DIR__ . '/../src/functions.php';
require_once __DIR__ . '/../tests/BaseTestCase.php';

use React\Promise\PromiseInterface;

/**
 * Class FunctionWaitTestCase
 */
class FunctionWaitTestCase extends BaseTestCase {

    /**
     * @test React\Promise\wait()
     */
    public function testWaitResolved() {
        $promise = $this->createPromiseResolved(rand(1, 9));
        $result = $promise->then(function ($value) {
            return $value * 2;
        });

        $this->assertInstanceOf(PromiseInterface::class, $result);

        $value = \React\Promise\wait($result);

        $this->assertNotInstanceOf(PromiseInterface::class, $value);
        $this->assertTrue(is_int($value));
    }

    public function testWaitRejected() {
        $promise = $this->createPromiseRejected(new Exception('test exception'));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('test exception');

        $value = \React\Promise\wait($promise);
    }

    public function testWaitRejectedWithNullWillThrowsUnexpectedValueException() {
        $promise = $this->createPromiseRejected(null);

        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('Promise rejected with unexpected value of type NULL');

        $value = \React\Promise\wait($promise);
    }
}