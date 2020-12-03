<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class test extends TestCase
{
    public function testFailure(): void
    {
        $this->assertContains(3, [1, 2, 3]);
    }
}