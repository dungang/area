<?php
/**
 * @author dungang
 */
namespace huluwa\area\widgets;

use dungang\area\models\Area;
use dungang\area\models\City;
use dungang\area\models\Province;
use huluwa\area\assets\AreaAsset;
use yii\bootstrap\InputWidget;
use yii\helpers\Html;

class AreaWidget extends InputWidget
{

    /**
     * @var string 省份编码字段名称
     */
    public $provinceCode = 'provinceCode';


    /**
     * @var string 城市编码字段名称
     */
    public $cityCode = 'cityCode';

    /**
     * @var string 区域/县编码
     */
    public $areaCode = 'areaCode';

    /**
     * @var string 省份编码
     */
    public $province = '330000';


    /**
     * @var string 城市编码
     */
    public $city = '330100';

    /**
     * @var string 区域/县编码
     */
    public $area = '330104';

    public $provinceNameRefer = 'province';

    public $cityNameRefer = 'city';

    public $areaNameRefer = 'area';

    /**
     * @var string 控件输出模板
     */
    public $template = '{hidden}{province}{city}{area}';

    public $provinceOptions=[];

    public $cityOptions=[];

    public $areaOptions=[];


    public $wrapperAddon = false;

    public $addonIcon = 'calendar';

    /**
     * @var string
     * [textInput,passwordInput,fileInput,
     * textarea,checkbox,radio,booleanInput,
     * dropDownList,listBox,checkboxList,radioList,listInput]
     */
    public $inputType='textInput';

    /**
     * @var array dropDownList,listBox,checkboxList,radioList,listInput
     */
    public $items = [];

    /**
     * @param $content string
     * @return string
     */
    protected function wrapperGroupAddon($content)
    {
        return <<<ELEMENT
    <div class="input-group">
        <div class="input-group-addon">
            <i class="fa fa-{$this->addonIcon}"></i>
        </div>
        {$content}
    </div>
ELEMENT;
    }


    protected function renderSingleInput()
    {
        if ($this->hasModel()) {
            $inputType = 'active'.ucfirst($this->inputType);
            return Html::$inputType($this->model, $this->attribute, $this->options);
        } else {
            $inputType = $this->inputType;
            return Html::$inputType($this->name, $this->value, $this->options);
        }
    }


    protected function renderListInput()
    {
        if ($this->hasModel()) {
            $inputType = 'active'.ucfirst($this->inputType);
            return Html::$inputType($this->model, $this->attribute,$this->items, $this->options);
        } else {
            $inputType = $this->inputType;
            return Html::$inputType($this->name, $this->value, $this->items, $this->options);
        }
    }

    protected function getLanguage()
    {
        return \Yii::$app->language;
    }

    public function run()
    {
        return $this->wrapperAddon
            ? $this->wrapperGroupAddon($this->renderInput())
            : $this->renderInput();
    }


    public function init()
    {
        if(is_array($this->attribute))
            $this->attribute = implode('',$this->attribute);
        if ($this->hasModel()) {
            $this->provinceNameRefer = Html::getInputName($this->model, $this->provinceNameRefer);
            $this->cityNameRefer = Html::getInputName($this->model, $this->cityNameRefer);
            $this->areaNameRefer = Html::getInputName($this->model, $this->areaNameRefer);
        }
        parent::init();
        AreaAsset::register($this->getView());
        $this->clientOptions = array_merge($this->clientOptions,[
            'provinceCode'=>$this->provinceCode,
            'cityCode'=>$this->cityCode,
            'areaCode'=>$this->areaCode,
            'provinceName'=>$this->provinceNameRefer,
            'cityName'=>$this->cityNameRefer,
            'areaName'=>$this->areaNameRefer,
        ]);
        $this->registerPlugin('hlwPCA');

    }

    /**
     * 渲染输入框
     * @return mixed
     */
    protected function renderInput()
    {
        $this->options = array_merge(['class' => 'form-control'],$this->options);
        if(isset($this->options['id']))
            $this->id = $this->options['id'];

        $hidden = Html::hiddenInput($this->provinceNameRefer)
            . Html::hiddenInput($this->cityNameRefer)
            . Html::hiddenInput($this->areaNameRefer);
        $content = strtr($this->template, [
            '{hidden}'=> $hidden,
            '{province}' => $this->renderProvince(),
            '{city}' => $this->renderCity(),
            '{area}' => $this->renderArea(),
        ]);
        return Html::tag('div',$content,$this->options);
    }


    /**
     * 渲染省份<select>
     */
    protected function renderProvince()
    {
        return $this->renderSelect(
            $this->provinceCode,
            $this->province,
            Province::getMap(),
            '请选择省份',
            $this->provinceOptions);
    }

    /**
     * 渲染城市select
     */
    protected function renderCity()
    {
        return $this->renderSelect(
            $this->cityCode,
            $this->city,
            $items = City::getCity($this->province),
            '请选择城市',
            $this->cityOptions);
    }

    /**
     * 渲染区域select
     */
    protected function renderArea()
    {
        return $this->renderSelect(
            $this->areaCode,
            $this->area,
            $items = Area::getArea($this->city),
            '请选择区/县',
            $this->areaOptions);

    }

    protected function renderSelect($Code,$value,$items,$prompt,$options){
        $option = array_merge(['prompt' => $prompt], $options);
        $option['id'] = $this->id . $Code;
        if ($this->hasModel()) {
            return Html::activeDropDownList($this->model, $Code, $items, $option);
        } else {
            return Html::dropDownList($Code, $value, $items, $option);
        }
    }


}