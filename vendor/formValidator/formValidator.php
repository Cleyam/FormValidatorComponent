<?php

namespace FormValidator;

class FormValidator
{
    protected $name;
    protected $value;
    protected $file;
    protected $patterns = [
        'email' => "^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$",

        'phone' => '^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$',

        'text' => "^[a-zA-Z ]*$",

        'url' => "https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)",

        'uri' => "\w+:(\/?\/?)[^\s]+",
    ];
    protected $errors = [];

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @return  self
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of file
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set the value of file
     *
     * @return  self
     */
    public function setFile($file)
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
        return empty($this->errors);
    }

    /**
     * Get the value of errors
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * This method can be used to quickly display a list of all the errors found at the end of the validation inside the HTML. 
     */
    public function displayErrorsList()
    {
        $errorList = "<ul>";

        foreach ($this->errors as $error) {
            $errorList .= "<li>$error</li>";
        }
        $errorList .= "</ul>";
        echo $errorList;
    }

    /**
     * Add error message if the value previously set isn't a boolean.
     *
     * @return self
     */
    public function isBool(): self
    {
        if (!is_bool(filter_var($this->value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE))) {
            $this->errors[$this->name] = 'The ' . $this->name . ' field isn\'t an boolean.';
        }
        return $this;
    }

    /**
     * Add error message if the value previously set isn't empty.
     *
     * @return self
     */
    public function isEmpty(): self
    {
        if (!empty($this->value)) {
            $this->errors[$this->name] = 'The ' . $this->name . ' field is not empty.';
        }
        return $this;
    }

    /**
     * Add error message if the value previously set isn't a float number.
     *
     * @return self
     */
    public function isFloat(): self
    {
        if (!filter_var($this->value, FILTER_VALIDATE_FLOAT)) {
            $this->errors[$this->name] = 'The ' . $this->name . ' field is not a float number.';
        }
        return $this;
    }

    /**
     * Add error message if the value previously set isn't a integer number.
     *
     * @return self
     */
    public function isInt(): self
    {
        if (!filter_var($this->value, FILTER_VALIDATE_INT)) {
            $this->errors[$this->name] = 'The ' . $this->name . ' field is not a integer number.';
        }
        return $this;
    }

    /**
     * Add error message if the value previously set isn't a string of characters.
     *
     * @return self
     */
    public function isString(): self
    {
        if (!is_string($this->value)) {
            $this->errors[$this->name] = 'The ' . $this->name . ' field is not a string of characters.';
        }
        return $this;
    }

    /**
     * Add error message if the value previously set isn't a alphabetical string.
     *
     * @return self
     */
    public function isAlpha(): self
    {
        if (!filter_var($this->value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z]+$/")))) {
            $this->errors[$this->name] = 'The ' . $this->name . ' field isn\'t an alphabetical string.';
        }
        return $this;
    }

    /**
     * Add error message if the value previously set isn't a alphanumerical string.
     *
     * @return self
     */
    public function isAlphanum(): self
    {
        if (!filter_var($this->value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z0-9]+$/")))) {
            $this->errors[$this->name] = 'The ' . $this->name . ' field isn\'t an alphanumerical string.';
        }
        return $this;
    }

    /**
     * Add error message if the value previously set isn't a email adress.
     *
     * @return self
     */
    public function isEmail(): self
    {
        if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$this->name] = 'The ' . $this->name . ' field isn\'t an email adress.';
        }
        return $this;
    }

    /**
     * Use a predefined pattern of the class called by the parameter and check if the value is valid. If not, add error message.
     *
     * @param [type] $option
     * @return self
     */
    public function predefinedPattern($option): self
    {
        $regex = '/' . $this->patterns[$option] . '/u';
        if ($this->value != '' && !preg_match($regex, $this->value)) {
            $this->errors[$this->name] = 'The ' . $this->name . ' field is invalid.';
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
            $this->errors[$this->name] = 'The ' . $this->name . ' field is invalid.';
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
            $this->errors[$this->name] = 'The field ' . $this->name . ' is mandatory.';
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
                $this->errors[$this->name] = 'The ' . $this->name . ' field doesn\'t have enough characters.';
            }
        } elseif ($this->value < $length) {
            $this->errors[$this->name] = 'The ' . $this->name . ' value is too small.';
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
                $this->errors[$this->name] = 'The ' . $this->name . ' field have too many characters.';
            }
        } elseif ($this->value > $length) {
            $this->errors[$this->name] = 'The ' . $this->name . ' value is too big.';
        }
        return $this;
    }

    /**
     * Add error message if the value isn't a number between $min and $max.
     *
     * @param integer $min
     * @param integer $max
     * @return self
     */
    public function betweenInputs(int $min, int $max): self
    {
        if ($this->value < $min || $this->value > $max) {
            $this->errors[$this->name] = "The $this->name field must contain a number between $min and $max.";
        }
        return $this;
    }

    /**
     * Add error message if the value previously entered isn't equal to the value of the parameter.
     *
     * @param [type] $value
     * @return self
     */
    public function matches($value): self
    {
        if ($this->value != $value) {
            $this->errors[$this->name] = "The $this->name field is invalid.";
        }
        return $this;
    }

    /**
     * Add error message if the file size exceeds the size set as parameter. 
     *
     * @param [type] $size
     * @return self
     */
    public function fileMaxSize($size): self
    {

        if ($this->file[$this->name]['error'] != 4 && $this->file[$this->name]['size'] > $size) {
            $this->errors[$this->name] = 'The ' . $this->name . ' file exceeds the size limit of ' . number_format($size / 1048576, 2) . ' MB.';
        }
        return $this;
    }

    /**
     * Add error message if the file size is smaller than the size set as parameter. 
     *
     * @param [type] $size
     * @return self
     */
    public function fileMinSize($size): self
    {

        if ($this->file[$this->name]['error'] != 4 && $this->file[$this->name]['size'] < $size) {
            $this->errors[$this->name] = 'The ' . $this->name . ' file must be at least ' . number_format($size / 1048576, 2) . ' MB.';
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
        if ($this->file[$this->name]['error'] != 4 && pathinfo($this->file[$this->name]['name'], PATHINFO_EXTENSION) != $ext && strtoupper(pathinfo($this->file[$this->name]['name'], PATHINFO_EXTENSION)) != $ext) {
            $this->errors[$this->name] = 'The ' . $this->name . ' is not a .' . $ext . ' .';
        }
        return $this;
    }

    /**
     * Add error message is the file previously set doesn't have the format set as parameter. 
     *
     * @param [type] $format
     * @return self
     */
    public function fileFormat($format): self
    {
        if ($this->file[$this->name]['error'] != 4 && !mime_content_type($this->file[$this->name]['tmp_name'], $format)) {
            $this->errors[$this->name] = 'The ' . $this->name . ' is not a .' . $format . ' .';
        }
        return $this;
    }
}
