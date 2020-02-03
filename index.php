<?php
spl_autoload_register(function ($className) {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    require_once 'vendor' . DIRECTORY_SEPARATOR . $file . '.php';
});

use FormValidator\FormValidator;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <?php

    $validator = new FormValidator();

    $validator->setName('email')->setValue('testtest.fr')->isEmail()->predefinedPattern('email');
    $validator->setName('bool')->setValue('trueg111hj')->isAlphanum();
    $validator->setName('custom')->setValue('FRJBI')->customPattern('[A-Z]');
    $validator->setName('required')->setValue('sdf')->required();
    $validator->setName('length')->setValue('sdfsdfsqsdqsdqsdqsdqsdqsddf')->minInput(5)->maxInput(12);
    $validator->setName('lsdfsdfsdfh')->setValue(5)->betweenInputs(2, 10);
    $validator->setName('lsdfsdfsdfh')->setValue('test')->matches('test');
    if (isset($_POST['upload'])) {
        $validator->setName('image')->setFile($_FILES)->fileMaxSize(30000000)->fileExt('png');
    }
    if ($validator->isValid()) {
        // Do whatever you want with this valid form
    } else {
        foreach ($validator->getErrors() as $errorMessage) {
            echo $errorMessage . '<br>';
        }
    }






    if ($validator->isValid()) {
        echo "Yes";
    } else {
        echo "No !";
    }


    ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <input name="image" type="file">
        <button type='submit' name='upload'>qsd</button>
    </form>
</body>

</html>