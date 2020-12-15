<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
include_once("utility/control.php");

final class test extends TestCase
{
    public function testSuccess(): void
    {
        // Check if it returns
        $this->assertNotEmpty([newMessage()]);

        // Check if the config File exists
        $this->assertFileExists('verification/config.php');

        // check if function is not empty
        $this->assertNotNull([regularOptions()]);
    }
}
?>