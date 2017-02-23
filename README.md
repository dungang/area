修改配置文件
--

> file: config/web.php,config/console.php

```php

    'modules' => [
        'area'=>[
            'class'=>'dungang\area\Module'
        ],
    ],
    
```

添加区域数据
--

```sh

php yii area/create-area

```

如何使用
--
```php

<?php 
use dungang\area\widgets\ActiveForm;
$form = ActiveForm::begin()?>

// like this
<?= $form->field($model, ['provinceCode', 'cityCode', 'areaCode'])->widget(\dungang\area\widgets\AreaWidget::className(), [
    'clientOptions' => [
        'url' => \yii\helpers\Url::toRoute('/area/info'),
        //'enabled' => false
    ]
]) ?>

// or like this
<?= \dungang\area\widgets\AreaWidget::widget([
    'name'=>'provinceCodecityCodeareaCode',
    'clientOptions' => [
        'url' => \yii\helpers\Url::toRoute('/area/info'),
        //'enabled' => false
    ]
]) ?>

<?php ActiveForm::end()?>

```