<?php
namespace ir0ny1\Validator;

use ir0ny1\Validator\Helpers\Str;

/**
 * A modular validation approach inspired by Illuminate
 * Class Validator
 * @author Dave Richer
 * @package ir0ny1\Validator
 */
class Validator extends  BaseValidator
{

    /**
     * Check if a property exists in the property
     * @param $property string The property that is required
     * @return $this Validator Current validator for chaining
     */
    public function isRequired($property)
    {
        if (!$this->hasProperty($property) || empty(trim($this->data[$property]))) {
            $this->addError($property, "is a required field");
        }

        return $this;
    }

    /**
     * Checks for equality
     * @param $property string
     * @param $value string
     * @return $this Validator Current validator for chaining
     */
    public function isEqualTo($property, $value)
    {
        if ($this->hasProperty($property) && $this->data[$property] != $value) {
            $this->addError($property, "Needs to be equal to $value");
        }

        return $this;
    }

    /**
     * Compare two properties for equality
     * @param $property string The first property to compare
     * @param $value string The second property to compare
     * @return $this Validator Current validator for chaining
     */
    public function isSameAs($property, $value)
    {
        if ($this->hasProperty($value) && $this->data[$value] != $this->data[$property]) {
            $this->addError($property, "must be the same as " . Str::camelToTitleCase($value));
        }

        return $this;
    }

    /**
     * Check to see if the string exceeds a specified length
     * @param $property string The property to validate
     * @param $value string The maximum string length threshold
     * @return $this Validator Current validator for chaining
     */
    public function isMaxLength($property, $value)
    {
        if ($this->hasProperty($property) && strlen($this->data[$property]) > $value) {
            $this->addError($property, "must not be longer then $value characters");
        }

        return $this;
    }

    /**
     * Check the length and validate it meets a minimum requirement
     * @param $property string The property to validate
     * @param $value string The minimum string length threshold
     * @return $this Validator Current validator for chaining
     */
    public function isMinLength($property, $value)
    {
        if ($this->hasProperty($property) && strlen($this->data[$property]) < $value) {
            $this->addError($property, "must not be shorter then $value characters");
        }

        return $this;
    }

    /**
     * Check if the property matches the (555) 555-5555 phone number format
     * @param $property
     * @return $this Validator Current validator for chaining
     */
    public function isPhoneNumber($property)
    {
        if ($this->hasProperty($property)
            && !preg_match('/^[(]\d{3}[)].\d{3}[-]\d{4}$/', $this->data[$property])
        ) {
            $this->addError($property, "must be a phone number in (nnn) nnn-nnnn format");
        }

        return $this;
    }

    /**
     * Check if the property matches a postal code format in A0A 0A0 or A0A0A0 format
     * @param $property string The property to check
     * @return $this Validator Current validator for chaining
     */
    public function isPostalCode($property)
    {
        if ($this->hasProperty($property)
            && !preg_match('/^[a-z][0-9][a-z][\s]?[0-9][a-z][0-9]$/i', $this->data[$property])
        ) {
            $this->addError($property, "must be a postal code in a0a 0a0 or a0a0a0 format");
        }
        return $this;
    }

    /**
     * Check to see if the property is a complex password
     * One capital character
     * One lowercase character
     * One numeric character
     * One special character
     * Minimum length of 6 characters
     * @param $property string The property to check
     * @return $this Validator Current validator for chaining
     */
    public function isComplexPassword($property)
    {
        // Preg match pattern
        $pattern = '/^\S*(?=\S{5,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/';
        // Validate
        if ($this->hasProperty($property) && !preg_match($pattern, $this->data[$property])) {
            $this->addError(
                $property,
                "must be a complex password, min 6 characters, 1 lower, 1 upper, 1 numeric, 1 special"
            );
        }

        return $this;
    }

    /**
     * Check to see if the field is a valid email address
     * @param $property string The Property to validate
     * @return $this Validator Current validator for chaining
     */
    public function isEmailAddress($property)
    {
        if ($this->hasProperty($property) && !filter_var($this->data[$property], FILTER_VALIDATE_EMAIL)) {
            $this->addError($property, "must be a valid email address");
        }

        return $this;
    }

    /**
     * Set the Min File size
     * @param $property string Property to be validates
     * @param $value int Size in Megabytes
     * @return $this
     */
    public function isFileSizeMin($property, $value)
    {
        $fileExists = array_key_exists($property, $_FILES);
        $fileSize = $_FILES[$property]['size'];
        if ($fileExists && $fileSize < ($value * 1024)) {
            $this->addError($property, "must be under " . ($value * 1024) . " MB");
        }

        return $this;
    }

    /**
     * Set the Max File size
     * @param $property string Property to be validates
     * @param $value int Size in Megabytes
     * @return $this
     */
    public function isFileSizeMax($property, $value)
    {
        $fileExists = array_key_exists($property, $_FILES);
        $fileSize = $_FILES[$property]['size'];
        if ($fileExists && $fileSize > ($value * 1024)) {
            $this->addError($property, "must be under " . ($value * 1024) . " MB");
        }

        return $this;
    }

    /**
     * Check if a property exists in the property
     * @param $property string The property that is required
     * @return $this Validator Current validator for chaining
     */
    public function isFileRequired($property)
    {
        if (!array_key_exists($property, $_FILES)) {
            $this->addError($property, "is a required File upload");
        }

        return $this;
    }

}
