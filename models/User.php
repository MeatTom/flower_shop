<?php

namespace app\models;
use yii\web\IdentityInterface;
use Yii;

/**
 * This is the model class for table "Users".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string|null $patronymic
 * @property string $login
 * @property string $email
 * @property string $password
 * @property int|null $isAdmin
 * @property string|null $access_token
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'login', 'email', 'password'], 'required'],
            [['isAdmin'], 'integer'],
            [['name', 'surname', 'patronymic', 'login', 'email', 'password', 'access_token'], 'string', 'max' => 255],
            [['email'], 'unique'],
            ['password'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID пользователя',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'login' => 'Логин',
            'email' => 'Почта',
            'password' => 'Пароль',
            'isAdmin' => 'Админ',
            'access_token' => 'Токен',
        ];
    }
    
     public static function findIdentity($id)
 {
 return static::findOne($id);
 }
 public static function findIdentityByAccessToken($token, $type =
null)
 {
 return static::findOne(['access_token' => $token]);
 }
 public function getId()
 {
 return $this->id;
 }
 public function getAuthKey()
 {
 return ;
 }
 public function validateAuthKey($authKey)
 {
 return ;
 }
 public function validatePassword($password){
 return $this->password==$password;
 }
 public static function findByLogin($login){
 return self::find()->where(['login'=> $login])->one();
 }

}
