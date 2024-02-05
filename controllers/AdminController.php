<?php

namespace app\controllers;

class AdminController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function beforeAction($action)
    {
    if ((\Yii::$app->user->isGuest) || (\Yii::$app->user->identity->isAdmin==0)){
    $this->redirect(['site/login']);
    return false;
    } else return true;
    }
   
}
