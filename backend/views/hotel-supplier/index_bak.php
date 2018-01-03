
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/dist/css/xhhgrogshop.css">
<?php
/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/4/25
 * Time: 下午4:14
 */

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\HotelSupplierQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '酒店供应商列表';
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\VueAsset::register($this);

//列表字段信息
$excelList = $gridColumns = [
    ['class' => 'yii\grid\SerialColumn','header' => '序号'],

    'id',
    'name',
    'brand',
    [
        'label' => '供应商类型',
        'value' => function($model){
            return Yii::$app->params['hotel_supplier_type'][$model->type];
        }
    ],
    [
        'label' => '所属城市',
        'value' => function($model){
            return $model->cityName->name;
        }
    ],
    [
        'label' => '关联酒店',
        'format' => 'raw',
        'value' => function($model){
            $html = '';

            if(empty($model->hotels)){
                return '---';
            }

            foreach($model->hotels as $index => $hotel){
                if($index > 4) break;
                $html .= Html::a($hotel->complete_name,'/hotel/update?id='.$hotel->id) . '<br>'. PHP_EOL;
            }
            return $html;
        }
    ],
    [
        'label' => '供应商状态',
        'value' => function($model){
            return Yii::$app->params['hotel_supplier_status'][$model->status];
        }
    ],
    [
        'label' => '有效期',
        'format' => 'raw',
        'value' => function($model){
            $start_time = substr($model->start_time,0,10);
            $end_time = substr($model->end_time,0,10);

            $start_time = empty($start_time)? '-' : $start_time;
            $end_time = empty($end_time)? '-' : $end_time;

            $html = <<<html
{$start_time}
<br>
至
<br>
{$end_time}
html;
            return $html;

        }
    ],
    [
        'label' => '结算状态',
        'value' => function($model){
            return Yii::$app->params['hotel_supplier_settle_type'][$model->settle_type];
        }
    ],
    [
        'label' => '开票状态',
        'value' => function($model){
            return Yii::$app->params['hotel_supplier_invoice_status'][$model->invoice_status];
        }
    ]
];

//客户端操作内容
$frotend_block = [
    'class' => 'yii\grid\ActionColumn',
    'header' => '操作',
    'template' => '<div class="dropdown profile-element group-btn-edit">
                                    {add}
                                    {stop}
                                    {begin}
                                </div> ',
    'buttons' => [
        'add' => function ($url, $model, $key) {
            return Html::a('查看', "$url", ['class' => 'delnode btn btn-primary btn-sm', 'style' => 'color:white']);
        },

        'stop' => function ($url, $model, $key) {
            if($model->status == 1){
                return Html::a('停用', "$url", ['class' => 'delnode btn btn-danger btn-sm', 'style' => 'color:white']);
            }
            return null;
        },
        'begin' => function ($url, $model, $key) {
            if($model->status == 3){
                return Html::a('启用', "$url", ['class' => 'delnode btn btn-success btn-sm', 'style' => 'color:white']);
            }
            return null;
        },

    ]
];

//审核操作
$backend_block = [
    'class' => 'yii\grid\ActionColumn',
    'header' => '审核',
    'template' => '<div class="dropdown profile-element group-btn-edit">
                                    {allow}
                                    {forbidden}
                                </div> ',
    'buttons' => [
        'allow' => function ($url, $model, $key) {
            return Html::button('通过', ['@click' => "openAlert({$model->status},1,'{$url}')",'class' => 'delnode btn btn-success btn-sm', 'style' => 'color:white']);
        },

        'forbidden' => function ($url, $model, $key) {
            return Html::button('拒绝', ['@click' => "openAlert({$model->status},2,'{$url}')",'class' => 'delnode btn btn-danger btn-sm', 'style' => 'color:white']);
        },

    ]
];

if($is_frontend){
    array_push($gridColumns,$frotend_block);
}

if($is_backend){
    array_push($gridColumns,$backend_block);
}

//搜索部分需要的数据
$default_city = \backend\controllers\HotelSupplierController::getCity(5);
array_unshift($default_city,['code'=>null,'name'=>'全部城市']);
$default_city = json_encode($default_city);
//\common\tools\Helper::dd(json_encode($default_city));

?>

<style>
    [v-cloak]{
        display: none;
    }
   .col-sm-2{
       width:auto;
   }
</style>
<?= \backend\widgets\ElementAlertWidget::widget() ?>
<div class="hotel-supplier-index" id="index" v-cloak>


    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
    <?php  echo $this->render('_search', ['searchModel' => $searchModel]); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <?= Html::a('新增供应商', ['add'], ['class' => 'btn btn-success']) ?>
            </div>
            <div class="col-sm-2">
                <?=
                \kartik\export\ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $excelList
                ])

                ?>
            </div>
        </div>
    </div>




    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'pager' => [
            'firstPageLabel' => '首页',
            'lastPageLabel' => '尾页',
            'nextPageLabel' => '下一页',
            'prevPageLabel' => '上一页',
            'hideOnSinglePage' => false,
        ],
    ]); ?>




<script>

    var options = <?= $default_city ?>;
    //用于消息提示
    var app = new Vue({
        el: '#index',
        data: {
            options: [],
            city_value: '',
            list: [],
            loading: false,
            states: options,
        },
        methods: {
            openAlert:function(onStatus,toStatus,url) {
                if(onStatus == toStatus){
                    this.$alert('当前状态未发生改变,操作无效','提示',{
                        confirmButtonText: '确定'
                    });
                }else{
                    location.href = url;
                }
            },
            remoteMethod: function(query){
                if(query === '全部'){
                    return
                }

                var _self = this;
                if (query !== '') {
                    this.loading = true;
                    setTimeout(function() {
                        var postUrl = '/hotel-supplier/search-city';
                        var postData = new FormData();
                        postData.append('city_name',query);
                        axios.post(postUrl,postData).then(function(res){

                            _self.options = res.data.map(function(item){
                                return { value: item.code, label: item.name };
                            });
                            _self.loading = false;

                        }).catch(function(error){
                            _self.loadDefaultCity();
                            _self.loading = false;
                        })
                    }, 200);
                } else {
                    this.loading = false;
                    this.loadDefaultCity();
                }
            },
            loadDefaultCity: function(){
                this.options = this.states.map(function(item) {
                    return { value: item.code, label: item.name };
                });
            }
        },
        mounted: function() {
            this.loadDefaultCity();
        }
    })




</script>