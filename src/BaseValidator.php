<?php
namespace ir0ny1\Validator;

use ir0ny1\Validator\Helpers\Arr;
use ir0ny1\Validator\Helpers\Str;

/**
 * Class BaseValidator
 * @author Dave Richer
 * @package ir0ny1\Validator
 */
abstract class BaseValidator implements IValidator
{
    /**
     * Hold the rules
     * @var array
     */
    protected $rules;

    /**
     * Holds the Errors
     * @var array
     */
    protected $errors;

    /**
     * Holds the Data
     * @var array
     */
    protected $data;

    /**
     * Constructor
     * @param $data array Associative array of data
     * @param $rules array Associative array of rules
     */
    public function __construct(array $data = [], array $rules = [])
    {
        // Set the rules
        $this->rules = $rules;
        // Set the data
        $this->data = $data;
    }


    /**
     * Add a message to the error Associative array
     * @param $property string
     * @param $message string
     */
    public function addError($property, $message)
    {

        // Prevent pushing a new message if a message for this property already exists
        if (!Arr::multiKeyExists($this->errors, $property)) {
            // Push the message into the errors array
            array_push($this->errors, [$property => $message]);
        }
    }

    /**
     * Set the data
     *
     * @param array $data
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Set the rules
     *
     * @param array $rules
     * @return $this
     */
    public function setRules(array $rules)
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * Check to see if the validator is in a valid state
     * Must run validate() first
     * @return bool true if valid false if not
     */
    public function valid()
    {
        return !is_null($this->errors) && !count($this->errors);
    }    /**
     * Get an array of validation messages
     * @return array of validation messages
     */
    public function validationSummary()
    {
        $output = [];
        foreach ($this->errors as $errors) {
            foreach (array_keys($errors) as $property) {
                array_push($output, $this->validationMessageFor($property));
            }
        }
        return $output;
    }

    /**
     * Run the validate method if the class is directly invoked
     */
    public function __invoke()
    {
        $this->validate();
    }    /**
     * Retrieve a validation method for a specified property
     * @param $property string the Property to get message for
     * @return string The message
     */
    public function validationMessageFor($property)
    {
        return Arr::multiKeyExists(
            $this->errors,
            $property
        ) ? $this->formatValidationMessage($property) : "";
    }

    /**
     * Validate the data against a set of specified rules
     */
    public function validate()
    {
        // If the error array does not exist, create it
        if (is_null($this->errors)) {
            $this->errors = [];
        }

        // go through the rules and break them into property / ruleLine key value pairs
        foreach ($this->rules as $property => $rulesLine) {
            // Extract the rules from the string
            $rules = explode("|", $rulesLine);
            // Go through each rule
            foreach ($rules as $ruleLine) {
                // split the rule and the value if the value exists
                $ruleData = explode(":", $ruleLine);
                // set the rule based on the first element
                $rule = $ruleData[0];
                // set the value to the second if it exists, or null
                $value = isset($ruleData[1]) ? $ruleData[1] : null;
                // Validate the individual property
                $this->validateProperty($property, $rule, $value);
            }
        }

        return $this;
    }

    /**
     * Validate a individual property using php kung fu magic
     * checks to see if $this->is{$Rule} exists,
     * if it does make sure it is callable
     * then invoke it passing it the property and rule
     * @param $property string Property key
     * @param $rule string Property rule
     * @param $value string property value
     */
    protected function validateProperty($property, $rule, $value)
    {
        // Build the rule name to follow PSR standard
        $pattern = 'is' . ucwords($rule);
        // Check to see if the rule exists
        if (method_exists($this, $pattern) && is_callable($pattern, true)) {
            // Invoke it with the property and value supplied
            $this->$pattern($property, $value);
        }
    }    /**
     * Format the validation message
     * @param $property string Property to format
     * @return string Formatted validation message
     */
    protected function formatValidationMessage($property)
    {
        return Str::camelToTitleCase($property) . " " . $this->extractValidationMessage($property);
    }

    /**
     * Check to see if the property exists in the data
     * @param $property string Property name
     * @return bool
     */
    protected function hasProperty($property)
    {
        return array_key_exists($property, $this->data);
    }    /***
     * Extract an error message from the error Associative array
     * @param $property string
     * @return string
     */
    protected function extractValidationMessage($property)
    {
        return Arr::getInnerValue($this->errors, $property);
    }

}
