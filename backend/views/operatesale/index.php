<?php
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script type="text/javascript">
        var adminId = '<?=Yii::$app->user->getId();?>';
    </script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>促销</title>
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/operate-sale/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/operate-sale/css/promotion.css">
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/operate-sale/css/bootstrap-datetimepicker.css">

    <script src="<?= Yii::$app->request->baseUrl ?>/operate-sale/js/method/base.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/operate-sale/js/method/newBase.js"></script>
    <!--<script src="../js/lib/dropload.min.js"></script>-->
    <script src="<?= Yii::$app->request->baseUrl ?>/operate-sale/js/lib/jquery-1.11.3.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/operate-sale/js/lib/jquery.md5.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/operate-sale/js/lib/layer/layer.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/operate-sale/js/lib/bootstrap.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/operate-sale/js/lib/My97DatePicker/WdatePicker.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/operate-sale/js/custorm/promotion_sale.js?v=1"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/operate-sale/js/custorm/page.js"></script>
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/operate-sale/js/lib/layui/css/layui.css">
    <script src="<?= Yii::$app->request->baseUrl ?>/operate-sale/js/lib/layui/layui.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/operate-sale/js/lib/layui/layui.all.js"></script>

</head>
<body>
<div class="container">
    <div class="bs-example" data-example-id="simple-horizontal-form">
        <form class="form-inline" id="promotion_form" onsubmit="return false">
            <div class="form-group">
                <label for="promotion_name">促销名称</label>
                <input type="text" class="form-control" id="promotion_name" placeholder="请输入促销名称" value="">
            </div>
            <div class="form-group">
                <label for="promotion_state">促销状态</label>
                <select   class="form-control" id="promotion_state" value="">
                    <option value="">- 请选择促销状态 -</option>
                    <option value="1">开启</option>
                    <option value="0">关闭</option>
                </select>
            </div>
            <div class="form-group">
                <label for="promotion_overlay">过期状态</label>
                <select   class="form-control" id="promotion_overlay" value="">
                    <option value="">- 请选择过期状态 -</option>
                    <option value="0">已过期</option>
                    <option value="1">未过期</option>
                </select>
            </div>
            <div class="form-group">
                <label for="promotion_restrict">限购状态</label>
                <select   class="form-control select-test" id="promotion_restrict" value="">
                    <option value="">- 请选择限购状态 -</option>
                    <option value="0">限购</option>
                    <option value="1">不限购</option>
                </select>
            </div>
            <div class="form-group">
                <label for="promotion_nub">限购数量</label>
                <input type="text" class="form-control" id="promotion_nub" placeholder="请输入限购数量" value="">
            </div>
            <div class="form-group">
                <label for="promotion_mode">促销方式</label>
                <select   class="form-control" id="promotion_mode" value="">
                    <option value="">- 请选择促销方式 -</option>
                    <option value="1">直降</option>
                    <option value="2">折扣</option>
                    <option value="3">满减</option>
                </select>
            </div>
            <div class="form-group">
                <label for="date_made" class="control-label">创建时间</label>
                <div class="input-group date form_datetime">
                    <input id="date_made" class="form-control" readonly/>
                    <span class="input-group-addon" onclick="WdatePicker({el:$dp.$('date_made')})"><span class="glyphicon glyphicon-th"></span></span>
                </div>
                <input type="hidden" id="dtp_input1" value="" /><br/>
            </div>
            <div class="form-group">
                <label for="date_start">活动时间</label>
                <div class="input-group date form_datetime">
                    <input id="date_start" class="form-control" readonly/>
                    <span class="input-group-addon" onclick="var date_end=$dp.$('date_ends');WdatePicker({el:$dp.$('date_start'),onpicked:function(){date_end.click()}})"><span class="glyphicon glyphicon-th"></span></span>
                </div>
                -
                <div class="input-group date form_datetime">
                    <input id="date_end" class="form-control" readonly/>
                    <span  id="date_ends"class="input-group-addon" onclick="WdatePicker({minDate:'#F{$dp.$D(\'date_start\')}',el:$dp.$('date_end'),maxDate:'#F{$dp.$D(\'date_start\',{M:+6})}'})"><span class="glyphicon glyphicon-th"></span></span>
                </div>
            </div>
            <div class="form-group">
                <label for="promotion_operator">操  作  员</label>
                <input type="text" class="form-control" id="promotion_operator" placeholder="请输入操作员">
            </div>
            <div class="form-group">
                <label for="promotion_id">促销活动ID</label>
                <input type="text" class="form-control" id="promotion_id" placeholder="请输入促销活动ID" value="">
            </div>
            <div>
                <button type="button" class="btn btn btn-primary promotion_search" onclick="initTable()"><span class="glyphicon glyphicon-search"></span> 查询</button>
                <button type="button" class="btn btn btn-primary" onclick="reset()"><span class="glyphicon glyphicon glyphicon-repeat"></span> 重置</button>
                <button class="btn btn-primary" onclick="adds()"><span class="glyphicon glyphicon glyphicon-plus"></span> 增加</button>
                <button  class="btn btn btn-primary" onclick="exportExcel()"><span class="glyphicon glyphicon glyphicon-download"></span> 导出</button>
            </div>

        </form>
    </div>
    <div id="add_promotion_modal" class="modal fade addmodal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <table class="table table-bordered table_add">
                    <tbody>
                    <tr>
                        <th scope="row">促销名称</th>
                        <td><input id="add_salesName" type="text" placeholder="请输入促销名称"></td>
                    </tr>
                    <tr>
                        <th scope="row">限购数量</th>
                        <td class="purchase_nub">
                            <label class="radio-inline">
                                <input type="radio" name="add_nubRadioOptions" id="add_nub_n" value="1" checked> 不限购
                            </label>
<!--                            <label class="radio-inline">-->
<!--                                <input type="radio" name="add_nubRadioOptions" id="add_nub_y" value="0"> 限购-->
<!--                                <input id="add_nub_input"  type="text">-->
<!--                            </label>-->
                            <input id="add_nub" type="hidden" value="1">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">促销状态</th>
                        <td class="promotion_state">
                            <label class="radio-inline">
                                <input type="radio" name="add_stateRadioOptions" id="add_state_on" value="1" checked> 开启
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="add_stateRadioOptions" id="add_state_off" value="0"> 关闭
                            </label>
                            <input id="add_state" type="hidden">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">促销时间</th>
                        <td style="position: relative;">
                            <div class="zhe" style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;"></div>
                            <form class="form-inline">
                                <div class="input-group date form_datetime datetimepicker-inline">
                                    <input id="add_date_start" class="form-control" readonly/>
                                    <span class="input-group-addon" onclick="var date_end=$dp.$('add_date_ends');WdatePicker({el:$dp.$('add_date_start'),onpicked:function(){date_end.click()},dateFmt:'yyyy-MM-dd HH:mm:ss'})"><span class="glyphicon glyphicon-th"></span></span>
<!--                                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>-->
                                </div>
                                -
                                <div class="input-group date form_datetime datetimepicker-inline">
                                    <input id="add_date_end" class="form-control" readOnly/>
                                    <span  id="add_date_ends" class="input-group-addon" onclick="WdatePicker({minDate:'#F{$dp.$D(\'add_date_start\')}',el:$dp.$('add_date_end'),maxDate:'#F{$dp.$D(\'add_date_start\',{M:+6})}',dateFmt:'yyyy-MM-dd HH:mm:ss'})"><span class="glyphicon glyphicon-th"></span></span>
<!--                                    <span  id="add_date_ends" class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>-->
                                </div>
                            </form>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">商品及用户导入</th>
                        <td class="promotion_overlay">
<!--                            <label class="radio-inline">-->
<!--                                <input type="radio" name="add_RadioOptions" id="add_overlay_y" value="1" checked> 可与其他活动叠加使用-->
<!--                            </label>-->
                            <label class="radio-inline">
                                <input type="radio" name="add_RadioOptions" id="add_overlay_n" checked="checked" value="0"> 不可与其他活动叠加使用
                            </label>
                            <input id="add_overlay" type="hidden">
                        </td>
                    </tr>
                    <tr class="add_tr">
                        <th scope="row">促销方式</th>
                        <td class="sales_type">
                            <label class="radio-inline">
                                <input type="radio" name="add_salesRadioOptions" id="add_straightDown" value="1" checked> 直降
                            </label>
<!--                            <label class="radio-inline">-->
<!--                                <input type="radio" name="add_salesRadioOptions" id="add_discount" value="2"> 折扣-->
<!--                            </label>-->
                            <label class="radio-inline">
                                <input type="radio" name="add_salesRadioOptions" id="add_fullCut" value="3"> 满减
                            </label>
                            <input id="add_sales" type="hidden">
                            <div id="straightDown_1" style="display: block">
                                直降：此规则下商品，单一商品在实际售价基础上，再减 <input id="straightDown_1_input" type="text">元销售
                            </div>
                            <div id="discount_2" style="display: none">
                                折扣；此规则下的商品，按照售价的 <input type="text" id="discount_2_input">%销售
                            </div>
                            <div id="fullCut_3" style="display: none">
<!--                                <div class="fullCut">-->
<!--                                    <label class="radio-inline">-->
<!--                                        <input type="radio" name="fullCut_salesRadioOptions" id="fullCut_301" value="301" checked>-->
<!--                                        满减：此规则下商品，单一订单购买金额达到-->
<!--                                    </label>-->
<!--                                    <div class="ww">-->
<!--                                        <div class="mj">-->
<!--                                            <input type="text" class="fullMoney">元，再减-->
<!--                                            <input type="text" class="reduceMoney">元销售-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="fullCutRuleA">-->
<!--                                    <label class="radio-inline">-->
<!--                                        <input type="radio" name="fullCut_salesRadioOptions" id="fullCut_302" value="302">-->
<!--                                        梯度满减a：此规则下商品:<br/>-->
<!--                                    </label>-->
<!--                                    <div class="ww">-->
<!--                                        <div class="mj">-->
<!--                                            满<input type="text" class="fullMoney">元，-->
<!--                                            减<input type="text" class="reduceMoney">元；-->
<!--                                        </div>-->
<!--                                        <div class="mj">-->
<!--                                            满<input type="text" class="fullMoney">元，-->
<!--                                            减<input type="text" class="reduceMoney">元；-->
<!--                                        </div>-->
<!--                                        <span class="add_append"></span>-->
<!--                                        <button class="fullCut_add" onclick="add(this)" name="fullCut_302">-->
<!--                                            <span class="glyphicon glyphicon-plus"></span>-->
<!--                                        </button><br/>-->
<!--                                    </div>-->
<!--                                    <div class="mj">-->
<!--                                        超过<input type="text" class="fullMoney">元部分，-->
<!--                                        只减<input type="text" class="reduceMoney">元-->
<!--                                    </div>-->
<!---->
<!--                                </div>-->
<!--                                <div class="fullCutRuleB">-->
<!--                                    <label class="radio-inline">-->
<!--                                        <input type="radio" name="fullCut_salesRadioOptions" id="fullCut_303" value="303">-->
<!--                                        梯度满减b：此规则下商品:<br/>-->
<!--                                    </label>-->
<!--                                    <div class="ww">-->
<!--                                        <div class="mj">-->
<!--                                            满<input type="text" class="fullMoney">元，-->
<!--                                            减<input type="text" class="reduceMoney">元；-->
<!--                                        </div>-->
<!--                                        <div class="mj">-->
<!--                                            满<input type="text" class="fullMoney">元，-->
<!--                                            减<input type="text" class="reduceMoney">元；-->
<!--                                        </div>-->
<!--                                        <div class="mj">-->
<!--                                            满<input type="text" class="fullMoney">元，-->
<!--                                            减<input type="text" class="reduceMoney">元；-->
<!--                                        </div>-->
<!--                                        <span class="add_append"></span>-->
<!--                                        <button class="fullCut_add" onclick="add(this)" name="fullCut_303">-->
<!--                                            <span class="glyphicon glyphicon-plus"></span>-->
<!--                                        </button>-->
<!--                                    </div>-->
<!--                                </div>-->
                                <div class="fullCutRuleB">
                                    <label class="radio-inline">
                                        <input type="radio" name="fullCut_salesRadioOptions" id="fullCut_303" value="303">
                                        满减：此规则下商品，单购买金额达到:<br/>
                                    </label>
                                    <div class="ww">
                                        <div class="mj">
                                            满<input type="text" class="fullMoney">元，
                                            减<input type="text" class="reduceMoney">元；
                                        </div>
                                        <span class="add_append"></span>
                                        <button class="fullCut_add" onclick="add(this)" name="fullCut_303">
                                            <span class="glyphicon glyphicon-plus"></span>
                                        </button>
                                    </div>
                                </div>
                                <input id="add_rulesDetail" type="hidden">
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button  id="add_save" type="button" class="btn btn-primary" onclick="addPromotion(this)" name="add">保存</button>
                </div>
            </div>
        </div>
    </div>
    <div class="bs-callout bs-callout-danger" id="callout-tables-striped-ie8">
        <div class="bs-example" data-example-id="bordered-table">
            <table class="table table-bordered promotion_tb">
                <thead>
                <tr class="add_list">
                    <th><input type="checkbox" id="box_all" /></th>
                    <th>促销活动ID</th>
                    <th>创建时间</th>
                    <th>促销名称</th>
                    <th>促销方式</th>
                    <th>促销规则</th>
                    <th>开始时间</th>
                    <th>结束时间</th>
                    <th>过期状态</th>
                    <th>限购状态</th>
                    <th>促销状态</th>
                    <!--<th>适用用户</th>-->
                    <!--<th>状态</th>-->
                    <th>操作员</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody class="text-center"></tbody>
            </table>
            <!--分页-->
<!--            <div class="paganition">-->
<!--                <div class="left">-->
<!--                    <span>每页显示条数:</span>-->
<!--                    <select class="pageSize" style="width: 70px;">-->
<!--                        <option value="15">15</option>-->
<!--                        <option value="30">30</option>-->
<!--                        <option value="50">50</option>-->
<!--                    </select>-->
<!--                </div>-->
<!--                <div class="right">-->
<!--                    <ul class="pager">-->
<!--                        <li class="pro_next"><a>首页</a><input type="hidden" value="1"/></li>-->
<!--                        <li class="pro_next"><a>上页</a><input type="hidden" value=""/></li>-->
<!--                        <li class="pro_next"><a>下页</a><input type="hidden" value=""/></li>-->
<!--                        <li class="pro_next"><a>末页</a><input type="hidden" value=""/></li>-->
<!--                    </ul>-->
<!--                </div>-->
<!--                <p style="display: inline-block;float: right;margin: 26px 20px 0px 0px;">-->
<!--                    共<span class="page_num">0</span>页-->
<!--                </p>-->
<!--            </div>-->
        </div>
        <div class="modal fade addCommModal" tabindex="-1" role="dialog" aria-labelledby="addCommModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form class="form-inline">
                        <div class="form-group">
                            <label for="addComm_id">促销活动ID</label>
                            <input type="text" class="form-control" id="addComm_id"  value="" readonly>
                        </div>



                        <div class="form-group">
                            <label for="addComm_creat">创建时间</label>
                            <input type="text" class="form-control" id="addComm_creat"  value="" readonly>
                        </div>

                        <div class="form-group">
                            <label for="addComm_name">促销名称</label>
                            <input type="text" class="form-control" id="addComm_name" readonly>
                        </div>
                        <div class="form-group">
                            <label for="addComm_mode">促 销 方 式</label>
                            <input type="email" class="form-control" id="addComm_mode"  value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="addComm_start">开始时间</label>
                            <input type="email" class="form-control" id="addComm_start"  value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="addComm_end">结束时间</label>
                            <input type="email" class="form-control" id="addComm_end" value="" readonly>
                        </div>



                    </form>


                    <div class="add_comm_div">
                        <form id= "uploadForm">
                            <p> <input type="hidden" id="up_mode" name="promotionMode" value= ''/></p>
                            <p> <input type="hidden" id="up_code" name="secondLeveCode" value= ''/></p>
                            <p> <input type="hidden" id="up_rule" name="rulesDetail" value= ''/></p>
                            <p> <input type="hidden" id="up_id" name="promotionId" value= ''/></p>
                            <p>上传文件： <input type="file" name="file"/></p>
                            <input type="button" value="上传" onclick="doUpload()" />
                        </form>
                        <!--<p>批量导入</p>-->
                        <!--<input type="file" lay-ext="xlxs|xls" name="file" lay-title="导入" id="upload" class="btn btn-default">-->
                    </div>
                    <div class="add_comm_div">
                        <p>单个产品导入</p>
                        <div class="form-group form-inline">
                            <label for="">产品分类</label>
                            <select   class="form-control goods_type">
                                <option value="">- 请选择产品分类 -</option>
                                <option value="1">民宿</option>
                                <option value="2">精品酒店</option>
                                <option value="3">旅游</option>
                            </select>
                            <select   class="form-control" id="goods_type_travel" >
                                <option value="301">线路</option>
                                <option value="302">活动</option>
                                <option value="303">向导</option>
                                <option value="304">游记</option>
                                <option value="305">印象</option>
                            </select>
                        </div>
                        <div class="form-group  form-inline">
                            <label for="">产 品 I D </label>
                            <input type="text" id="goods_id" class="form-control" >
                            <button class="btn btn-default addPromotion" onclick="imports(this)" name="only">添加</button>

                        </div>

                    </div>
                    <div class="add_comm_div">
                        <span>产品名录</span>
                        <button class="btn btn-default pull-right goods_export_excel" onclick="goodsExportExcel()">下载</button>
                    </div>
                    <table class="table table-bordered list_tb">
                        <thead>
                        <tr>
                            <th><input type="checkbox" id="list_tb_all"></th>
                            <th>商品ID</th>
                            <th>商品名称</th>
                            <th>商品分类</th>
                            <th>商品价格</th>
                            <th>操作</th>

                        </tr>
                        </thead>
                        <tbody class="text-center">

                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</body>
</html>