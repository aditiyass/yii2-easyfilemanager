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

Once the extension is installed, simply add to module configuration :

```php
    'modules' => [
        ...
        'efm' => [
            'class' => 'aditiya\easyfilemanager\Module', // Module class
            'usedemo' => true, // if you want to use demo in this default controller
            // 'uploadfilepath' => '@app/uploads/files',
            // 'defaultUrl' => '/sfm/file/get',
        ],
        ...
    ]
```