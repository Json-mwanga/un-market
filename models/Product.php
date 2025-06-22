<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Product extends ActiveRecord
{
    public $imageFiles; // for multiple image upload

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';  // your product table name
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'price' ], 'required'],
            [['user_id'], 'integer'],
            [['price'], 'number'],
            [['description'], 'string'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'maxFiles' => 5, 'extensions' => 'png, jpg, jpeg, gif'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'description' => 'Description',
            'created_at' => 'Created At',
            'imageFiles' => 'Product Images (Max 5)',
        ];
    }

    /**
     * Relation to ProductImage model to get images
     */
    public function getImages()
    {
        return $this->hasMany(ProductImage::class, ['product_id' => 'id']);
    }

    /**
     * Relation to User model to get the owner of the product
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getrecentComments()
    {
        return $this->hasMany(Comment::class, ['product_id' => 'id'])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(1); // or 2, as needed
    }

    public function getComments()
    {
        return $this->hasMany(Comment::class, ['product_id' => 'id'])
            ->orderBy(['created_at' => SORT_DESC])
            ->with('user'); // preload user for each comment
    }






}
