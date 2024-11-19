<?php

namespace app\models;

use Yii;

use yii\base\Model;
use yii\web\UploadedFile;
class ImageUpload extends Model

{
    public function rules()
    {
        return [
            [['image'], 'file', 'extensions' => 'png, jpg, jpeg, gif', 'mimeTypes' => 'image/jpeg, image/png, image/gif', 'maxSize' => 1024 * 1024 * 5],
        ];
    }
    public $image;
    public function uploadFile(UploadedFile $file)
    {
        $file->saveAs(Yii::getAlias('@webroot/uploads/') . $file->name);
        return $file->name;
    }
}