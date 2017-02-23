<?php

namespace dungang\area\controllers;

use yii\web\Controller;
use yii\helpers\Json;
use dungang\area\models\City;
use dungang\area\models\CityQuery;
use dungang\area\models\AreaQuery;
use dungang\area\models\Area;
use dungang\area\models\ProvinceQuery;
use dungang\area\models\Province;

/**
 * Default controller for the `area` module
 */
class InfoController extends Controller
{

    /**
     * 以json的形式
     * @param $code
     * @param $type
     * @return string
     */
    public function actionIndex($code,$type)
    {
        switch ($type) {
            case 'city':
                $info = $this->cities($code);
                break;
            case 'area':
                $info = $this->areas($code);
                break;
            default:
                $info = $this->provinces();
        }
        return Json::encode($info, true);
    }

    /**
     * 返回所有省份信息
     */
    protected function provinces()
    {
        $provinceQuery = new ProvinceQuery(Province::className());
        return $provinceQuery->all();
    }

    /**
     * 根据省份code返回城市
     * @param $provinceCode
     * @return array|\huluwa\area\models\City[]
     */
    protected function cities($provinceCode)
    {
        $cityQuery = new CityQuery(City::className());
        return $cityQuery->where(['provincecode' => $provinceCode])->all();
    }

    /**
     * 根据城市code返回区域
     * @param $cityCode
     * @return array|\huluwa\area\models\Area[]
     */
    protected function areas($cityCode)
    {
        $areaQuery = new AreaQuery(Area::className());
        return $areaQuery->where(['citycode' => $cityCode])->all();
    }
}