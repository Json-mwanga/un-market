<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

class SignupForm extends Model
{
    public $first_name;
    public $last_name;
    public $username;
    public $phone_number;
    public $email;
    public $password;
    public $password_confirm;



    public function rules()
    {
        return [
            [['first_name', 'last_name', 'username', 'phone_number', 'email', 'password', 'password_confirm'], 'required'],
            ['email', 'email'],
            ['password_confirm', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
        ];
    }


    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

    $user = new User();
    $user->first_name = $this->first_name;
    $user->last_name = $this->last_name;
    $user->username = $this->username;
    $user->phone_number = $this->phone_number;
    $user->email = $this->email;
    $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
    $user->auth_key = Yii::$app->security->generateRandomString();
    $user->created_at = time();
    $user->updated_at = time();


        // Validate User model before saving
        if (!$user->validate()) {
            // Add User model errors to SignupForm to show on form
            foreach ($user->getErrors() as $attribute => $errors) {
                foreach ($errors as $error) {
                    $this->addError($attribute, $error);
                }
            }
            return null;
        }

        if (!$user->save()) {
            // Log save error for debugging
            Yii::error('User save failed: ' . json_encode($user->getErrors()), __METHOD__);
            return null;
        }

        return $user;
    }

    public function attributeLabels()
    {
        return [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'username' => 'Username',
            'phone_number' => 'Phone Number',
            'email' => 'Email Address',
            'password' => 'Password',
            'password_confirm' => 'Confirm Password',
        ];
    }
    private $_user = false;

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

}
