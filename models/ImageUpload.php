<?php

namespace app\models;

use Yii;

use yii\base\Model;
use yii\web\UploadedFile;
class ImageUpload extends Model

{
    public function rules(){

        return[

            [['image'], 'required'],

            [['image'],'file', 'extensions' => 'jpg,png']
        ];
    }
    public $image;
    public function deleteCurrentImage($currentImage)
    {
        if (file_exists(Yii::getAlias('@webroot/uploads/') . $currentImage) &&

            is_file(Yii::getAlias('@webroot/uploads/') . $currentImage)) {

            unlink(Yii::getAlias('@webroot/uploads/') . $currentImage);

        }
    }
    public function uploadFile(UploadedFile $file, $currentImage)
    {
        $this->image = $file;

        if ($this->validate()) {
            $this->deleteCurrentImage($currentImage);

            $filename = strtolower(md5(uniqid($file->baseName)) . '.' . $file->extension);

            $file->saveAs(Yii::getAlias('@webroot/uploads/') . $filename);
            return $filename;
        }
    }
}