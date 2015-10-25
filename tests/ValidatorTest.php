<?php

use ir0ny1\Validator\Validator;

class ValidatorTest extends PHPUnit_Framework_TestCase
{

    public function testRequiredExists()
    {
        $data = [
            'name'  => 'Dave'
        ];

        $rules = [
            'name'  => 'required'
        ];

        $val = new Validator($data, $rules);

        $val->validate();

        $this->assertTrue($val->valid());
    }

    public function testRequiredDoesNotExist()
    {
        $data = [];
        $rules = [
            'name'  => 'required'
        ];

        $val = new Validator($data, $rules);

        $val->validate();

        $this->assertTrue(!$val->valid());
    }
}
