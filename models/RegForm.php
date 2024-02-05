<?php
namespace app\models;
use app\models\User;

class RegForm extends User
{
 public $confirm_password;
 public $agree;
 public function rules()
 {
     return [
         [['name', 'surname', 'login', 'email', 'password', 'confirm_password', 'agree'], 'required'],
         [['name'], 'match', 'pattern'=>'/^[А-Яёа-яё]{5,}$/u','message'=>'Используйте минимум 5 русских букв'],
         [['surname'], 'match', 'pattern'=>'/^[А-Яёа-яё]{5,}$/u','message'=>'Используйте минимум 5 русских букв'],
         [['patronymic'], 'match', 'pattern'=>'/^[А-Яёа-яё]{5,}$/u','message'=>'Используйте минимум 5 русских букв'],
         [['isAdmin'], 'integer'],
         [['name', 'surname', 'patronymic', 'login', 'email', 'password', 'access_token'], 'string', 'max' => 255],
         [['email'], 'unique'],
         [['email'], 'email'],
         [['password'], 'match', 'pattern'=>'/^[A-Za-z0-9]{5,}$/','message'=>'Используйте минимум 5 латинских букв и цифр'],
         [['confirm_password'], 'compare', 'compareAttribute'=>'password'],
         [['agree'], 'compare', 'compareValue'=>true, 'message'=>''],
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
    'confirm_password' => 'Повторите пароль',
    'agree' => 'Подтвердите согласие на обработку персональных данных',
 ];
 }
}
