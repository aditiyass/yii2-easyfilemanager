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

Make sure to migrate all table from `src/migrations` folder.

Once the extension is installed and database is ready, add to module configuration :

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

- `usedemo` : to use demo in /efm
- `uploadfilepath` : path to upload file folder
- `defaultUrl` : where to get file. you can create costum url by simply extend controller from class `FileController`
- `dbConnection` : custom database connection

to ***upload*** file, use Easyfilemanagermodel. you can set it's category, rolelist (default : ```['@','?']```), and description.

to ***get instance object***, you can use ```getByKey()``` or ```getByCategory()```.

to ***get file url***, use ```getFileUrl()``` function.

```php
use aditiya\easyfilemanager\models\Easyfilemanager;

...

//on action create
$model = new Easyfilemanager();

if ($this->request->isPost) {
    $model->rolelists = ['admin','writer'];
    $model->category = 'draftpage';
    $model->description = 'draft page image';
    $key = $model->uploadByInstance($model,'file');
    if($key){
        return $this->redirect(['view', 'key' => $key]);
    }
}
```

you can use `EasyfilemanagerTrait` and `Easyfilemanagerinterface` together in your own model
```php
use aditiya\easyfilemanager\interfaces\EasyfilemanagerInterface;
use aditiya\easyfilemanager\traits\EasyfilemanagerTrait;


class ModelExample extends Model implements EasyfilemanagerInterface {
    use EasyfilemanagerTrait;
    ...
    public function getFileUrl()
    {
        return $this->getEfmFileUrl($this->filekey);
    }

    public function uploadFile()
    {
        $is_uploaded = $this->uploadEfmByInstance('filekey');
        if($is_uploaded){
            $this->filekey = $is_uploaded;
            return true;
        }
        return false;
    }

    public function deleteFile()
    {
        return $this->deleteEfm($this->filekey);
    }
    ...
}
```

***update 1.1.0*** : now you can add in rolelist, if you only want specific user with specific role to access your data.
```php
$model = new Easyfilemanager();
$model->rolelists = ['admin','writer'=>1,'editor'=>[2,3,4]];
```
