<?php

use yii\helpers\Html;

\backend\assets\VueAsset::register($this);
$this->title = '运营位添加';

/* @var $this yii\web\View */
/* @var $model backend\models\ShopGoods */
?>


<div id='form'>
    <form action="" class="form-horizontal">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">运营位添加</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="" class="col-sm-1 control-label">标题</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="title">
                    </div>
                </div>


                <div class="form-group">
                    <label for="" class="col-sm-1 control-label">发布位置</label>
                    <div class="col-sm-10">
                        <select v-model="position" class="form-control">
                            <option v-for="v in positions" :value="v.id">{{v.name}}</option>
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <label for="" class="col-sm-1 control-label">类型</label>
                    <div class="col-sm-10">
                        <select v-model="type" class="form-control">
                            <option v-for="v in types" :value="v.id">{{v.name}}</option>
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <label for="" class="col-sm-1 control-label">标题</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="title">
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-primary col-sm-offset-1">保存</button>
    </form>


</div>


<script>
    var app = new Vue({
        el: '#form',
        data: {
            title: '',
            position: 1,
            positions: [
                {id: 1, name: '轮播图'},
                {id: 2, name: '列表位'},
            ],
            type: 1,
            types: [
                {id: 1, name: 'Url链接'},
                {id: 2, name: '房源id'},
            ]
        },
        methods: {}
    });
</script>