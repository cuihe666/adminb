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
\backend\assets\ScrollAsset::register($this);

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
//                if($index > 4) break;
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
//    [
//        'label' => '结算状态',
//        'value' => function($model){
//            $settles = $model->settleList;
//
//            if(empty($settles)){
//                return '未生成账单';
//            }
//            $settle = current($settles);
//
//            return \Yii::$app->params['close_account'][$settle->status];
//        }
//    ],
//    [
//        'label' => '开票状态',
//        'value' => function($model){
//            $settles = $model->settleList;
//
//            if(empty($settles)){
//                return '未生成账单';
//            }
//            $settle = current($settles);
//
//            return \Yii::$app->params['hotel_supplier_invoice_status'][$settle->invoice];
//        }
//    ]
];

//客户端操作内容
$frotend_block = [
    'class' => 'yii\grid\ActionColumn',
    'header' => '操作',
    'template' => '
                                    {add}
                                    {stop}
                                    {begin}
                                ',
    'buttons' => [
        'add' => function ($url, $model, $key) {
            return Html::a('查看', "$url", ['class' => ' btn btn-primary btn-sm', 'style' => 'color:white','target'=>'_blank']);
        },

        'stop' => function ($url, $model, $key) {
            if($model->status == 1){
                return Html::a('停用', "$url", ['class' => ' btn btn-danger btn-sm', 'style' => 'color:white']);
            }
            return null;
        },
        'begin' => function ($url, $model, $key) {
            if($model->status == 3){
                return Html::a('启用', "$url", ['class' => ' btn btn-success btn-sm', 'style' => 'color:white']);
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
            return Html::button('通过', ['@click' => "openAlert({$model->status},1,'{$url}')",'class' => 'btn btn-success btn-sm', 'style' => 'color:white']);
        },

        'forbidden' => function ($url, $model, $key) {
//            return Html::button('拒绝', ['@click' => "openPrompt({$model->status},2,'{$url}')",'class' => 'btn btn-danger btn-sm', 'style' => 'color:white']);
            return Html::button('拒绝', ['@click' => "openModel({$model->status},2,'{$url}')",'class' => 'btn btn-danger btn-sm', 'style' => 'color:white']);
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

?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/common.min.css">
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/dist/css/xhhgrogshop.css">

<style>
    [v-cloak]{
        display: none;
    }
   .col-sm-2{
       width:auto;
   }
    /*#w3{*/
        /*width: 1780px;*/
    /*}*/
    .action-column{
        width: 100px;
    }
    .btn-primary{
        margin-right: 0px;
    }
    .search-box{
       margin-left: 0px;
    }

    .search-box .search-item {

        margin: 17px 8px 0 0;
    }
    .content-header > h1{
        text-indent: 20px;
    }
    /*@media (min-width: 768px){*/
        /*.col-sm-12 {*/
            /*width: auto;*/
        /*}*/
    /*}*/
    .search-box .search-item {
        margin: 17px 4px 0 0;
    }
    /*@media screen and (max-width:1784px){*/
        /*.content{*/
            /*overflow-x: hidden;*/
        /*}*/
    /*}*/

</style>
<?= \backend\widgets\ElementAlertWidget::widget() ?>


<div class="wrapper-content animated fadeInRight" id="index" v-cloak>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="search-box clearfix" style="margin: -65px 0 0 0px;">
                        <?php  echo $this->render('_search', ['searchModel' => $searchModel]); ?>
                    </div>
                    <?php
                    use kartik\export\ExportMenu;

                    // Renders a export dropdown menu
                    echo ExportMenu::widget([
                        'dataProvider' => $dataProvider
                        ,'columns' => $excelList
                    ]);
                    ?>
                    <?= Html::a('新增供应商', ['add'], ['class' => 'btn btn-success']) ?>
                    <?php
                    // You can choose to render your own GridView separately
                    // You can choose to render your own GridView separately
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => $gridColumns,
                        'pager' => [
                            'firstPageLabel' => '首页',
                            'lastPageLabel' => '尾页',
                            'nextPageLabel' => '下一页',
                            'prevPageLabel' => '上一页',
                            'hideOnSinglePage' => false,
                        ],
                    ]);
                    ?>

                </div>
            </div>
        </div>
    </div>



</div>




<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="transition: all 1s;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">提示:</h4>
            </div>
            <div class="modal-body">
                <p>
                    <label style="float: left">审核状态：</label>
                    <span class="check_status">{{ statusList[modelInfo.status] }}</span>
                </p>
                <p>
                    <label style="float: left">审核备注：</label>
                    <textarea name="remarks" class="remarks" cols="60" rows="5" v-model="modelInfo.msg"></textarea>
                </p>

                <transition mode="out-in" enter-active-class="animated flipInX" leave-active-class="animated flipOutX">
                    <p v-if="modelInfo.isError" key="1">
                        <label style="float: left; width: 70px;">提示信息: </label>
                        <span style="color: #f0ad4e;">{{ modelInfo.errorInfo }}</span>
                    </p>
                    <p v-else key="2" style="height: 18.89px">
                    </p>
                </transition>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" @click="closeModel()">确定</button>
            </div>
        </div>
    </div>
</div>









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
            timer : null,
            modelInfo: {
                oldStatus: '',
                status: '1',
                msg:'',
                token: '',
                url: '',
                isError: false,
                errorInfo: ''
            },
            statusList: <?= json_encode(Yii::$app->params['hotel_supplier_status']) ?>
        },
        methods: {
            openAlert:function(onStatus,toStatus,url) {
                if(onStatus == toStatus){
                    this.$alert('当前状态未发生改变,操作无效','提示',{
                        confirmButtonText: '确定'
                    });
                }else{
                    location.href = url + "&oldStatus=" + onStatus + "&status+" + toStatus + "&token=<?= Yii::$app->session->get('token',null) ?>";
                }
            },
            openPrompt: function(onStatus,toStatus,url){
                if(onStatus == toStatus){
                    this.$alert('当前状态未发生改变,操作无效','提示',{
                        confirmButtonText: '确定'
                    });
                }else{
                    var _self = this;
                    this.$prompt('请输入拒绝理由', '提示',{
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        inputValidator: function(value){
                            console.log(value.length)
                            if(value.length < 2){
                                return '原因不得少于2个字符'
                            }
                            return true;
                        }
                    }).then(function(res){
                        if(res.action == "confirm"){
                            var msg = res.value
                            var token = '<?= Yii::$app->request->csrfToken ?>';
                            var path = url + '&msg=' + msg + '&token=' + token;
                            location.href = path
                        }
                    })
                }
            },
            //开启模态框
            openModel: function(onStatus,toStatus,url){
                if(onStatus == toStatus){
                    this.$alert('当前状态未发生改变,操作无效','提示',{
                        confirmButtonText: '确定'
                    });
                }else{
                    //连续打开相同的条目将不做重置
                    if(url != this.modelInfo.url){
                        this.resetModelInfo();
                    }
                    $('#myModal').modal('show');
                    //导入条目信息
                    this.modelInfo.oldStatus = onStatus;
                    this.modelInfo.status = toStatus;
                    this.modelInfo.url = url;
                    this.modelInfo.token = '<?= Yii::$app->session->get('token',null) ?>';
                }
            },
            //重置审核信息
            resetModelInfo: function(){
                this.modelInfo.msg = '';
                this.modelInfo.isError = false;
                this.modelInfo.errorInfo = '';
            },
            remoteMethod: function(query){
                if(query === '全部城市'){
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
    });



    //协助组件(因为模态框和 table 中存在样式冲突)
    var vm_model = new Vue({
        el : '#myModal',
        data: app.$data,
        methods: {
            //关闭模态框(确认提交的情况)
            closeModel: function(){
                if(!this.modelInfo.isError){
                    $('#myModal').modal('hide');
                    var info = this.modelInfo;
                    var path = info.url + '&msg=' + info.msg + '&oldStatus=' + info.oldStatus + '&status=' + info.status + '&token=' + info.token;
                    location.href = path;
                }
            }
        },
        watch: {
            modelInfo : {
                deep : true,
                handler : function(newInfo,oldInfo){
                    console.log(newInfo.msg,oldInfo.msg);
                    //检测输入内容
                    if(this.modelInfo.msg.length < 2){
                        this.modelInfo.isError = true;
                        this.modelInfo.errorInfo = '审核记录不得少于两个字';
                    }else{
                        this.modelInfo.isError = false;
                    }
                }
            }
        }
    })






</script>