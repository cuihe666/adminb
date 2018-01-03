<?php
/**
 * User: snowno
 * Date: 2017/11/7 0006
 * Time: 18:13
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$this->title = '批量造点评';
$this->params['breadcrumbs'][] = ['label' => '点评', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
    <script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/js/plugins/layer/layer.js"></script>
<style>
    /*a  upload */
    .a-upload {
        padding: 4px 10px;
        height: 30px;
        line-height: 20px;
        position: relative;
        cursor: pointer;
        color: #888;
        top:10px;
        background: #fafafa;
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
        display: inline-block;
        *display: inline;
        *zoom: 1
    }

    .a-upload  input {
        position: absolute;
        font-size: 100px;
        right: 0;
        top: 0;
        opacity: 0;
        filter: alpha(opacity=0);
        cursor: pointer
    }

    .a-upload:hover {
        color: #444;
        background: #eee;
        border-color: #ccc;
        text-decoration: none
    }
</style>
<div class="comment-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <form  action="<?=Url::to(['comment-manage/muti-create'])?>" method="post" enctype="multipart/form-data" >

    <div class="comment-form">
        上传Excel: <input type="text" class="showFileName">
        <a href="javascript:;" class="a-upload">
            <input type="file" name="file" id="">点击这里上传文件
        </a>
        <input type="hidden" name="_csrf-backend" value="<?=Yii::$app->request->getCsrfToken()?>">
        <input type="submit" value="导入">
    </div>
    </form>

    <a href="<?=Url::to(['comment-manage/download'])?>" id="download">上传Excel模板，点击下载</a>
</div>
<script>
    $(".a-upload").on("change","input[type='file']",function(){
        var filePath=$(this).val();
        if(filePath.indexOf("xls")!=-1){
            var arr=filePath.split('\\');
            var fileName=arr[arr.length-1];
            $(".showFileName").val(fileName);
        }else{
            $(".showFileName").val("");
            alert("您未上传文件，或者您上传文件类型有误！");
            return false
        }
    });

</script>
<?php
if (Yii::$app->session->hasFlash('info')) {

    ?>
    <script>layer.alert("<?=var_dump($err_arr)?>")</script>
<?php }?>