<?php

namespace FormValidator;

class FormValidator
{
    protected $name;
    protected $value;
    protected $file;
    protected $patterns = [
        'email' => "^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$",

        'phone' => '^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$',

        'text' => "^[a-zA-Z ]*$",

        'url' => "https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)",

        'uri' => "\w+:(\/?\/?)[^\s]+",
    ];
    protected $errors = '';


    /**
     * Return the name of the field to test.
     *
     * @param string $name
     * @return self
     */
    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Return the value of the field to test.
     *
     * @param [type] $value
     * @return self
     */
    public function value($value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Return the file to test.
     *
     * @param [type] $file
     * @return self
     */
    public function file($file): self
    {
        $this->file = $file;
        return $this;
    }

    /**
     * Return true if the value passed all the tests without getting errors, and false if there has been errors.
     *
     * @return boolean
     */
    public function isValid(): bool
    {
        if (empty($this->errors)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Return true if $value is an boolean, and false otherwise.
     *
     * @param [type] $value
     * @return boolean
     */
    public function isBool($value): bool
    {
        if (is_bool(filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Return true if $value is an email, and false otherwise.
     *
     * @param string $value
     * @return boolean
     */
    public function isEmail(string $value): bool
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Use a predefined pattern of the class called by the parameter and check if the value is valid. If not, add error message.
     *
     * @param [type] $name
     * @return self
     */
    public function predefinedPattern($name): self
    {
        $regex = '/' . $this->patterns[$name] . '/u';
        if ($this->value != '' && !preg_match($regex, $this->value)) {
            $this->errors[] = 'The ' . $this->name . ' field is invalid.';
        }
        return $this;
    }

    /**
     * Use a custom pattern regex called by the parameter and check if the value is valid. If not, add error message.
     *
     * @param [type] $pattern
     * @return self
     */
    public function customPattern($pattern): self
    {
        $regex = '/' . $pattern . '/u';
        if ($this->value != '' && !preg_match($regex, $this->value)) {
            $this->errors[] = 'The ' . $this->name . ' field is invalid.';
        }
        return $this;
    }

    /**
     * Add error message if the field isn't set.
     *
     * @return self
     */
    public function required(): self
    {
        if ((isset($this->file) && $this->file['error'] == 4) || ($this->value == '' || $this->value == null)) {
            $this->errors[] = 'The field ' . $this->name . ' is mandatory.';
        }
        return $this;
    }

    /**
     * Add error message if the value or the string length is too small.
     *
     * @param [type] $length
     * @return self
     */
    public function minInput($length): self
    {
        if (is_string($this->value)) {

            if (strlen($this->value) < $length) {
                $this->errors[] = 'The ' . $this->name . ' field doesn\'t have enough characters.';
            }
        } elseif ($this->value < $length) {
            $this->errors[] = 'The ' . $this->name . ' value is too small.';
        }
        return $this;
    }

    /**
     * Add error message if the value or the string length is too big.
     *
     * @param [type] $length
     * @return self
     */
    public function maxInput($length): self
    {
        if (is_string($this->value)) {

            if (strlen($this->value) > $length) {
                $this->errors[] = 'The ' . $this->name . ' field have too many characters.';
            }
        } elseif ($this->value > $length) {
            $this->errors[] = 'The ' . $this->name . ' value is too big.';
        }
        return $this;
    }

    /**
     * Add error message if the value previously entered isn't equal to the value of the parameter.
     *
     * @param [type] $value
     * @return self
     */
    public function equal($value): self
    {
        if ($this->value != $value) {
            $this->errors[] = "The $this->name field is invalid.";
        }
        return $this;
    }

    /**
     * Add error message is the file previously set doesn't have the extension set as parameter. 
     *
     * @param [type] $ext
     * @return self
     */
    public function fileExt($ext): self
    {
        if ($this->file['error'] != 4 && pathinfo($this->file['name'], PATHINFO_EXTENSION) != $ext && strtoupper(pathinfo($this->file['name'], PATHINFO_EXTENSION)) != $ext) {
            $this->errors[] = 'The ' . $this->name . ' is not a .' . $ext . ' .';
        }
        return $this;
    }

    /**
     * Get the value of errors
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Display all error messages in the html
     *
     * @return void
     */
    public function displayErrors($tags, $class)
    {
        foreach ($this->errors as $error) {
            echo $error;
        }
    }
}
