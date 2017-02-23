<?php

namespace dungang\area\models;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "area".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $citycode
 */
class Area extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qc_area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'citycode'], 'required'],
            [['code', 'citycode'], 'string', 'max' => 6],
            [['name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'name' => Yii::t('app', 'Name'),
            'citycode' => Yii::t('app', 'Citycode'),
        ];
    }

    /**
     * @inheritdoc
     * @return AreaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AreaQuery(get_called_class());
    }
    public static function getMap() {
    	$area = (new Query())->select(['code','name'])
    	->from(self::tableName())
    	->all();
    	return ArrayHelper::map($area,'code','name');
    }
    public static function getArea($cityCode){
    	$city = (new AreaQuery(self::className()))->select(['code','name'])
    	->where([ 'citycode' => $cityCode ])
    	->all();
    	return ArrayHelper::map($city, 'code', 'name');
    }
    
    
}
