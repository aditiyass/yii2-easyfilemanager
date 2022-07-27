<?php

namespace aditiya\easyfilemanager\models;

use aditiya\easyfilemanager\traits\ModuleTrait;
use Exception;
use thamtech\uuid\helpers\UuidHelper;
use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%easyfilemanager}}".
 *
 * @property string $key
 * @property string $name
 * @property string $extension
 * @property string|null $category
 * @property string|null $description
 * @property string $mimetype
 * @property string|null $roles
 * @property int|null $size
 * @property string|null $created_at
 * @property string $filepath
 * @property string $file
 * @property array $rolelists
 */
class Easyfilemanager extends \yii\db\ActiveRecord
{
    // Traits
    use yii\base\ArrayableTrait;
    use ModuleTrait;

    // Attributes
    public $baseurl; //url untuk mengambil data file
    public $file; //placeholder attribute untuk upload file
    public $rolelists = ['@','?']; //daftar role
    public $folderpath; //init saat awal
    public $modulename = 'efm'; //placeholder kalau mau masukkan file sendiri

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%easyfilemanager}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key', 'name', 'extension', 'mimetype', 'filepath'], 'required'],
            [['description', 'roles'], 'string'],
            [['size'], 'integer'],
            [['created_at', 'file'], 'safe'],
            [['key'], 'string', 'max' => 36],
            [['name', 'extension', 'category', 'mimetype', 'filepath'], 'string', 'max' => 255],
            [['key'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'key' => Yii::t('easy_file_manager', 'Key'),
            'name' => Yii::t('easy_file_manager', 'Name'),
            'extension' => Yii::t('easy_file_manager', 'Extension'),
            'category' => Yii::t('easy_file_manager', 'Category'),
            'description' => Yii::t('easy_file_manager', 'Description'),
            'mimetype' => Yii::t('easy_file_manager', 'Mimetype'),
            'roles' => Yii::t('easy_file_manager', 'Roles'),
            'size' => Yii::t('easy_file_manager', 'Size'),
            'created_at' => Yii::t('easy_file_manager', 'Created At'),
            'filepath' => Yii::t('easy_file_manager', 'Filepath'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $module = $this->getModule();
        $this->folderpath = $module->uploadfilepath;
        $this->baseurl = $module->defaultUrl;
    }

    /**
     * @return Module
     */
    private function getModule()
    {
        return \Yii::$app->getModule($this->modulename);
    }

    /**
     * {@inheritdoc}
     * @return EasyfilemanagerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EasyfilemanagerQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function afterFind()
    {
        $this->rolelists = (array)json_decode($this->roles);
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        $this->roles = json_encode($this->rolelists);
        if($this->category == null){
            $this->category = '*';
        }
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function afterDelete()
    {
        $this->eraseFile();
    }

    /**
     * Check whether user can access file data or not.
     *
     * @param boolean $throwErrors Whether throw errors or not
     * @return boolean if permitted to access file data or not
     * @throws ForbiddenHttpException if not permitted and $throwErrors is true.
     */
    public function checkCredential($throwErrors = false)
    {
        $access = false;
        if(Yii::$app->user->isGuest){
            if(array_search('?',$this->rolelists) != false){
                $access = true;
            }
        }
        else{
            if(array_search('@',$this->rolelists) != false){
                $access = true;
            }
            else{
                foreach ($this->rolelists as $role) {
                    if(Yii::$app->user->can($role)){
                        $access = true;
                    }
                }   
            }
        }
        if(!$access && $throwErrors){
            throw new ForbiddenHttpException("Access Denied. You don't have credential to access file data.");
        }
        return $access;
    }

    /**
     * url to request file.
     *
     * @return string|boolean
     */
    public function getFileUrl($param = 'key')
    {
        return Url::to([$this->baseurl,$param=>$this->key],true);
    }

    /**
     * Get path where file is or will be saved.
     *
     * @return string|boolean
     */
    public function fullFolderPath()
    {
        return Yii::getAlias($this->folderpath);
    }

    /**
     * Full file path.
     *
     * @return string|boolean
     */
    public function fullFilePath($key = null)
    {
        if($key == null){
            return $this->fullFolderPath().'/'.$this->key;
        }
        $dummy = Easyfilemanager::findOne(['key'=>$key]);
        if($dummy){
            return $dummy->fullFilePath();
        }
        return false;
    }

    /**
     * Folder path where meta data is stored.
     *
     * @return string|boolean
     */
    public function fullMetaDataPath()
    {
        return Yii::getAlias($this->metadatapath);
    }

    /**
     * The file should be uploaded using [[\yii\widgets\ActiveField::fileInput()]].
     * 
     * @param \yii\base\Model $model — the data model
     * @param string $attribute 
     * the attribute name. The attribute name may contain array indexes. For example, '[1]file' for tabular file uploading; and 'file[1]' for an element in a file array.
     * @return string uploaded file key
     * @throws Exception if something wrong happened
     */
    public function uploadByInstance($model,$attribute)
    {
        $this->initDir();
        $uploadedfile = UploadedFile::getInstance($model,$attribute);
        if($uploadedfile){
            if($uploadedfile->hasError){
                throw new Exception('Upload Error Code: '.$uploadedfile->error);
            }
            $this->key = UuidHelper::uuid();
            $this->size = $uploadedfile->size;
            $this->name = $uploadedfile->name;
            $this->extension = $uploadedfile->extension;
            $this->created_at = date("Y-m-d H:i:s");
            $is_uploaded = $uploadedfile->saveAs($this->fullFilePath());
            if($is_uploaded){
                $this->mimetype = FileHelper::getMimeType($this->fullFilePath());
                $this->filepath = $this->fullFilePath();
                if($this->save()){
                    return $this->key;
                }
                else{
                    $this->eraseFile();
                    $this->validate();
                    var_dump($this->errors);exit;
                    throw new Exception('File not uploaded');
                }
            }
        }
        throw new Exception('File not uploaded');
    }

    //private functions
    private function initDir()
    {
        if(!file_exists($this->fullFolderPath())){
            FileHelper::createDirectory($this->fullFolderPath());
        }
    }

    private function eraseFile()
    {
        if(is_file($this->fullFilePath())){
            return unlink($this->fullFilePath());
        }
        return false;
    }
}
