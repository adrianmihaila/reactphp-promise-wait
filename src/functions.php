<?php

namespace React\Promise;

function wait(PromiseInterface $promise) {
    $result = null;
    $exception = null;
    $isRejected = false;

    $wait = true;
    while ($wait) {
        $promise
            ->then(function ($r) use (&$result) {
                $result = $r;
            }, function ($e) use (&$exception, &$isRejected) {
                $exception = $e;
                $isRejected = true;
            })
            ->always(function () use (&$wait) {
                $wait = false;
            });
    }

    if ($isRejected) {
        if (!$exception instanceof \Exception) {
            $exception = new \UnexpectedValueException(
                'Promise rejected with unexpected value of type ' . (is_object($exception) ? get_class($exception) : gettype($exception))
            );
        }

        throw $exception;
    }

    return $result;
}

function waitClosure(\Closure $closure) {
    $result = null;
    $exception = null;
    $isRejected = false;

    $wait = true;
    while ($wait) {
        $closure()
            ->then(function ($r) use (&$result) {
                $result = $r;
            }, function ($e) use (&$exception, &$isRejected) {
                $exception = $e;
                $isRejected = true;
            })
            ->always(function () use (&$wait) {
                $wait = false;
            });
    }

    if ($isRejected) {
        if (!$exception instanceof \Exception) {
            $exception = new \UnexpectedValueException(
                'Promise rejected with unexpected value of type ' . (is_object($exception) ? get_class($exception) : gettype($exception))
            );
        }

        throw $exception;
    }

    return $result;
}