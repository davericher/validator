<?php
namespace ir0ny1\Validator;

/**
 * Interface IValidator
 * @author Dave Richer
 * @package ir0ny1\Validator
 */
interface IValidator
{
    /**
     * Returns the current state of the model
     *
     * @return bool
     */
    public function valid();

    /**
     * Validates the model against its rules
     *
     * @return void
     */
    public function validate();

    /**
     * Add an error into the errors array
     *
     * used to hook into the validator for custom messages
     * will invalidate the model
     *
     * @param $property
     * @param $message
     * @return void
     */
    public function addError($property, $message);

    /**
     * Get a array of error messages
     *
     * @return array
     */
    public function validationSummary();

    /**
     * Get a validation message for a property if one exists
     *
     * @param $property
     * @return string
     */
    public function validationMessageFor($property);

    /**
     * Set the rules
     *
     * @param array $rules
     * @return mixed
     */
    public function setRules(array $rules);

    /**
     * Set the data
     *
     * @param array $data
     * @return mixed
     */
    public function setData(array $data);
}
