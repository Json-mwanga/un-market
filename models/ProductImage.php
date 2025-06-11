<?php

namespace app\models;

use yii\db\ActiveRecord;

class ProductImage extends ActiveRecord
{
    public static function tableName()
    {
        return 'product_image';  // Your images table name
    }

    public function rules()
    {
        return [
            [['product_id', 'image_path'], 'required'],
            [['product_id'], 'integer'],
            [['image_path'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'image_path' => 'Image Path',
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
