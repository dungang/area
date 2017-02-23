<?php

namespace dungang\area\models;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "city".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $provincecode
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qc_city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'provincecode'], 'required'],
            [['code', 'provincecode'], 'string', 'max' => 6],
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
            'provincecode' => Yii::t('app', 'Provincecode'),
        ];
    }

    /**
     * @inheritdoc
     * @return CityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CityQuery(get_called_class());
    }
    public static function getMap() {
    	$city = (new Query())->select(['code','name'])
    	->from(self::tableName())
    	->all();
    	return ArrayHelper::map($city,'code','name');
    }
    public static function getCity($provinceCode){
    	$info = (new CityQuery(self::className()))->select(['code','name'])
    	->where(['provincecode' => $provinceCode])
    	->all();
    	return ArrayHelper::map($info, 'code', 'name');
    }
}
