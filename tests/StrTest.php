<?php
use ir0ny1\Validator\Helpers\Str;

class StrTest extends PHPUnit_Framework_TestCase
{

    public function testCamelToTitleCase()
    {
        $this->assertEquals(Str::camelToTitleCase("helloWorldThisIsATest"), "Hello World This Is A Test");
    }

    public function testCamelToRegularCase()
    {
        $this->assertEquals(Str::camelToRegularCase("helloWorldThisIsATest"), "hello world this is a test");
    }
}
