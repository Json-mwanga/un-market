<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName() {
        return 'user';
    }

public function rules() {
    return [
        [['first_name', 'last_name', 'username', 'phone_number', 'email', 'password_hash'], 'required'],
        [['username', 'email', 'phone_number'], 'unique'],
        ['email', 'email'],
        [['address', 'bio', 'profile_image', 'cover_image'], 'safe'],
    ];
}

public function attributeLabels() {
    return [
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'username' => 'Username',
        'phone_number' => 'Phone Number',
        'email' => 'Email Address',
        'address' => 'Address',
        'bio' => 'Biography',
        'profile_image' => 'Profile Image',
        'cover_image' => 'Cover Image',
    ];
}


    public static function findIdentity($id) {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {}

    public static function findByUsername($username) {
        return static::findOne(['username' => $username]);
    }

    public function getId() {
        return $this->id;
    }

    public function getAuthKey() {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey) {
        return $this->auth_key === $authKey;
    }

    public function validatePassword($password) {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    public function getProfileImageUrl()
    {
        if ($this->profile_image && file_exists(\Yii::getAlias('@webroot/' . $this->profile_image))) {
            return \Yii::getAlias('@web/' . $this->profile_image);
        }
        return \Yii::getAlias('@web/images/default-profile.png'); // fallback default image
    }


}
