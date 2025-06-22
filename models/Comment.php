<?php
namespace app\models;

use yii\db\ActiveRecord;

class Comment extends ActiveRecord
{
    public static function tableName()
    {
        return 'product_comment';
    }

    public function rules()
    {
        return [
            [['comment', 'product_id', 'user_id', 'created_at'], 'required'],
            [['comment'], 'string'],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}


