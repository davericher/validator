<?php
use ir0ny1\Validator\Validator;

/**
 * Class ValidatorTest
 */
class ValidatorTest extends PHPUnit_Framework_TestCase
{

    public function testValidatorWorks()
    {
        $val = new Validator();
        $this->assertInstanceOf(Validator::class, $val);
    }

    public function testInvoke()
    {
        $val = new Validator(
        // Data
            [
                'name' => 'dave'
            ],
            // Rules
            [
                'name' => 'required'
            ]);
        $val();
        // Invoke the validation directly
        $this->assertTrue($val->valid());
    }

    public function testWithoutInvoke()
    {
        $val = new Validator(
        // Data
            [
                'name' => 'dave'
            ],
            // Rules
            [
                'name' => 'required'
            ]
        );

        $this->assertFalse($val->valid());
    }

    public function testChaining()
    {
        $val = new Validator();
        $this->assertTrue($val->setData(['name' => 'dave'])->setRules(['name' => 'required'])->validate()->valid());
    }

    public function testRequiredExists()
    {
        $val = new Validator(
            [
                'name' => 'Dave'
            ],
            [
                'name' => 'Dave'
            ]
        );

        $val->validate();

        $this->assertTrue($val->valid());
    }

    public function testRequiredDoesNotExist()
    {
        $val = new Validator(
            [
                'name' => ''
            ],
            [
                'name' => 'required'
            ]
        );

        $val->validate();

        $this->assertFalse($val->valid());
    }

    public function testEqualToPasses()
    {
        $val = new Validator(
            [
                'a' => 'a',
            ],
            [
                'a' => 'equalTo:a'
            ]
        );

        $val->validate();

        $this->assertTrue($val->valid());
    }

    public function testEqualToFails()
    {
        $val = new Validator(
            [
                'a' => 'b',
            ],
            [
                'a' => 'equalTo:a'
            ]
        );

        $val->validate();

        $this->assertFalse($val->valid());
    }

    public function testSameAsPasses()
    {
        $val = new Validator(
            [
                'a' => 'a',
                'b' => 'a'
            ],
            [
                'b' => 'sameAs:a'
            ]
        );

        $val->validate();

        $this->assertTrue($val->valid());
    }

    public function testSameAsFails()
    {
        $val = new Validator(
            [
                'a' => 'a',
                'b' => 'c'
            ],
            [
                'a' => 'sameAs:b',
            ]
        );

        $val->validate();

        $this->assertFalse($val->valid());
    }

    public function testMaxLengthPasses()
    {
        $val = new Validator(
            [
                'name' => 'dave'
            ],
            [
                'name' => 'maxLength:4'
            ]
        );

        $val->validate();

        $this->assertTrue($val->valid());
    }

    public function testMaxLengthFails()
    {
        $val = new Validator(
            [
                'name' => 'david'
            ],
            [
                'name' => 'maxLength:4'
            ]
        );

        $val->validate();

        $this->assertFalse($val->valid());
    }
}
