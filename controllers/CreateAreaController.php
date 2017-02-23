<?php
/**
 * User: dungang
 * Date: 2017/2/21
 * Time: 下午 5:52
 */

namespace dungang\area\controllers;


use yii\console\Controller;

class CreateAreaController extends Controller
{
    public function actionIndex()
    {
        $sql = file_get_contents(dirname(__DIR__).'/scheme/area.sql');
        if(\Yii::$app->db->createCommand($sql)->execute())
        {
            echo "create areas success ! \n";
        }

    }
}