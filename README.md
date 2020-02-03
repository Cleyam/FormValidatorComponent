# **PHP Form Validator by Cleyam**

This PHP class will help you easily validate HTML form fields. The class has built-in fluent methods to ease the validation of any kind of input, with preset methods, but also the possibility to create custom regex paterns for more specific situations.

## **How to setup**

* Copy the /vendor directory inside your project.


## **Working with the Form Validator**

To validate a form :

1-  Require/Include/Autoload the FormValidator class in your file.

2-	Instantiate a new object with the FormValidator class wherever you want within PHP tags.

Exemple
```php
$formValidator = new FormValidator();
```
 
3-	For each input to validate, set the name and the value of said input, then use the fluent methods provided with the class to make sure the input's value is valid. If it isn't, it will add error messages inside the $errors attribute, which is an array containing error messages sorted by the names of your inputs. You can then use the isValid() method to either move on with your values if they are valid, or use the getErrors() method to use those error messages wherever you want in your code.

Exemple
```php
    $validator->setName('name')->setValue($_POST['name'])->required(); // The input can't be empty
    $validator->setName('email')->setValue($_POST['email'])->isEmail()->predefinedPattern('email'); // The email must be in a email format, but also in a pattern predefined by the class.
    $validator->setName('password')->setValue($_POST['password'])->customPattern('^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$'); // custom pattern for a password input
    $validator->setName('message')->setValue($_POST['message'])->minInput(10)->maxInput(500); // In this exemple, the user must type a text containing at least 10 characters, but less than 500 characters.
    $validator->setName('number')->setValue(40)->betweenInputs(2, 10); // The number must be between 2 and 10, this will return a error message
    $validator->setName('typeThis')->setValue('hello')->matches('hello'); // The user must type the exact same thing as in the matches() method
    if (isset($_POST['upload'])) {
        $validator->setName('image')->setFile($_FILES)->fileMaxSize(30000000)->fileExt('png'); // The file must respect the size and the extension
    }
    if ($validator->isValid()) {
        // Do whatever you want with this valid form
    } else {
        foreach ($validator->getErrors() as $errorMessage) {
            echo $errorMessage . '<br>'; // display error messages in the HTML
        }
    }
```


## **Methods & options**

* #### setName
This method is **mandatory** and must be used before you start checking the validity of an input. It is advise to give it the same name as the input.


* #### setValue
This method is **mandatory** ( except if you're validating a file ) and must be used before you start checking the validity of an input. It is advise to use it right after you set the name. It should contain the value you got from the input.


* #### setFile
This method is **mandatory** ( if you're validating a file ) and must be used before you start checking the validity of an file input. It is advise to give it the same name as the input.


* #### getName
This method will return the last name set.


* #### getValue
This method will return the last value set.


* #### getFile
This method will return the last file set.


* #### isValid
This method will return true if the $errors attribute is empty. 


* #### getErrors
This method will return the $errors attribute as an array. Each key of this array will be the name of the input containing a error, and the values will error messages.


* #### displayErrorList
If you don't want to use the getErrors method to deal with the failures in the validation of your form, you can use this method to quickly display a list of said errors in the HTML. It can be useful for test purpose, but for a proper display of the errors, getErrors should always be prefered.


* #### isBool
This method will add a contextual error message in the $errors array if the set value isn't a boolean.


* #### isEmpty
This method will add a contextual error message in the $errors array if the set value isn't empty.


* #### isFloat
This method will add a contextual error message in the $errors array if the set value isn't a float number.


* #### isInt
This method will add a contextual error message in the $errors array if the set value isn't a integer number.


* #### isString
This method will add a contextual error message in the $errors array if the set value isn't a string.


* #### isAlpha
This method will add a contextual error message in the $errors array if the set value isn't a alphabetical string.


* #### isAlphanum
This method will add a contextual error message in the $errors array if the set value isn't a alphanumerical string.


* #### isEmail
This method will add a contextual error message in the $errors array if the set value isn't a email recognized by the filter_var() function.


* #### predefinedPattern
This method will add a contextual error message in the $errors array if the set value doesn't match the predefined regex pattern set as a parameter.

`pattern` - You can use one of the following predefined patterns : email, phone, text, url, uri.


* #### predefinedPattern
This method will add a contextual error message in the $errors array if the set value doesn't match the custom regex pattern set as a parameter.

`pattern` - You'll have to set an regex string as a parameter, without delimiters.


* #### required
This method will add a contextual error message in the $errors array if the set value is empty.


* #### minInput
This method will add a contextual error message in the $errors array if the set value is smaller than the parameter. It works for string's length or for integer.

`length` - the number of characters the string must exceed, or the number the integer must exceed.


* #### maxInput
This method will add a contextual error message in the $errors array if the set value is bigger than the parameter. It works for string's length or for integer.

`length` - the number of characters the string must not exceed, or the number the integer must not exceed.


* #### betweenInput
This method will add a contextual error message in the $errors array if the set value isn't a number bigger than the first parameter and smaller than the second parameter.

`min` - The number the integer must exceed.

`max` - The number the integer must not exceed.


* #### matches
This method will add a contextual error message in the $errors array if the set value isn't exactly identical to the value set as parameter.

`value` - the value your input's value must be identical to.


* #### fileMaxSize
This method will add a contextual error message in the $errors array if the set file is bigger than the set size as parameter.

`size` - the size your file must not exceeds.


* #### fileMinSize
This method will add a contextual error message in the $errors array if the set file is smaller than the set size as parameter.

`size` - the size your file must exceeds.


* #### fileExt
This method will add a contextual error message in the $errors array if the set file doesn't have the extension set as parameter.

`ext` - the extension your file must have.


* #### fileFormat
This method will add a contextual error message in the $errors array if the set file doesn't have the format / mime type set as parameter.

`format` - the format / mime type your file must have.