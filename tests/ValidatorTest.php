<?php

use ir0ny1\Validator\Validator;

/**
 * Class ValidatorTest
 */
class ValidatorTest extends PHPUnit_Framework_TestCase
{

    public function testRequiredExists()
    {
        $data = [
            'name' => 'Dave'
        ];

        $rules = [
            'name' => 'required'
        ];

        $val = new Validator($data, $rules);

        $val->validate();

        $this->assertTrue($val->valid());
    }

    public function testRequiredDoesNotExist()
    {
        $data = [
            'name'  =>  ''
        ];
        $rules = [
            'name'  =>  'required'
        ];

        $val = new Validator($data, $rules);

        $val->validate();

        $this->assertFalse($val->valid());
    }

    public function testEqualToPasses()
    {
        $data = [
            'a' => 'a',
        ];

        $rules = [
            'a' => 'equalTo:a'
        ];

        $val = new Validator($data, $rules);

        $val->validate();

        $this->assertTrue($val->valid());
    }

    public function testEqualToFails()
    {
        $data = [
            'a' => 'b',
        ];

        $rules = [
            'a' => 'equalTo:a'
        ];

        $val = new Validator($data, $rules);

        $val->validate();

        $this->assertFalse($val->valid());
    }

    public function testSameAsPasses()
    {
        $data = [
            'a' => 'a',
            'b' => 'a'
        ];

        $rules = [
            'b' => 'sameAs:a'
        ];

        $val = new Validator($data, $rules);

        $val->validate();

        $this->assertTrue($val->valid());
    }

    public function testSameAsFails()
    {
        $data = [
            'a' => 'a',
            'b' => 'c'
        ];

        $rules = [
            'a' => 'sameAs:b',
        ];

        $val = new Validator($data, $rules);

        $val->validate();

        $this->assertFalse($val->valid());
    }

    public function testMaxLengthPasses()
    {
        $data = [
            'name'  =>  'dave'
        ];

        $rules = [
            'name'  =>  'maxLength:4'
        ];

        $val = new Validator($data, $rules);

        $val->validate();

        $this->assertTrue($val->valid());
    }

    public function testMaxLengthFails()
    {
        $data = [
            'name'  =>  'david'
        ];

        $rules = [
            'name'  =>  'maxLength:4'
        ];

        $val = new Validator($data, $rules);

        $val->validate();

        $this->assertFalse($val->valid());
    }
}
