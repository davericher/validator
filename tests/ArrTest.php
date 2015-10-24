<?php

use ir0ny1\Validator\Helpers\Arr;

class ArrTest extends PHPUnit_Framework_TestCase
{
    protected $array;

    protected function setUp() {
        $this->array = [
            'thekey' =>
                [
                    'innerKey'   => 'thevalue'
                ]
        ];
    }
    public function testMultiKeyExists() {
        // One Level deep
        $this->assertTrue(Arr::multiKeyExists($this->array,'thekey'));
        // Two Levels deep
        $this->assertTrue(Arr::multiKeyExists($this->array,'innerKey'));
    }

    public function testGetInnerValue() {
        $test = ['outerkey' => [
            'innerkey' => 'innervalue'
        ]];
        $this->assertEquals('innervalue',Arr::getInnerValue($test,'innerkey'));
    }

    public function testInnerKeyExists() {
        $this->assertTrue(Arr::innerKeyExists($this->array, 'innerKey'));
    }
}