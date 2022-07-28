Easy File Manager
=================
Manage and upload file easily. feature are rbac validation and category tag. need db to use.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist aditiya/yii2-easyfilemanager "*"
```

or add

```
"aditiya/yii2-easyfilemanager": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, add to module configuration :

```php
    'modules' => [
        ...
        'efm' => [
            'class' => 'aditiya\easyfilemanager\Module', // Module class
            'usedemo' => true, // if you want to use demo
        ],
        ...
    ]
```

module parameters are :
<br>```usedemo``` : to use demo in /efm
<br>```uploadfilepath``` : path to upload file folder
<br>```defaultUrl``` : where to get file. you can create costum url by simply extend controller from ```aditiya\easyfilemanager\controllers\FileController```
<br>```dbConnection``` : custom database connection