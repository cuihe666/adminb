<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use backend\assets\HotelAsset;


//
$this->title = '酒店供应商';
$this->params['breadcrumbs'][] = $this->title;
HotelAsset::register($this);
\backend\assets\ScrollAsset::register($this);
?>


<!-- Main content -->



<section class="content">
    <div class="rummery_top">
        //公共头部
        <?= \backend\widgets\HotelSupplierListWidget::widget([
            'current_url' => $current
        ]) ?>

        <div class="rummery_con">
            <div class="rummery_item suppy_detail" style="display: none;">
                <ul class="suppy_box">
                    <li><label for=""><span>*</span>供应商名称：</label><input type="text" id="suppy_name" onblur="suppy_name()"><i>请输入完整供应商名称</i></li>
                    <li class="address clearfix">
                        <label for="" class="fl"><span>*</span>地&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;址：</label>
                        <div class="address_box fl">
                            <div class="address_con">
                                <select name="">
                                    <option value="">国家</option>
                                </select>
                                <select name="">
                                    <option value="">省份</option>
                                </select>
                                <select name="">
                                    <option value="">城市</option>
                                </select>
                            </div>
                            <input type="text" placeholder="详细地址" class="add_detail" id="add_detail" onblur="add_detail()">
                        </div>
                        <i>请填写地址</i>
                    </li>
                    <li><label for=""><span></span>邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;编：</label><input type="" name="" id="" value=""></li>
                    <li><label for=""><span>*</span>供应商类型：</label>
                        <select name="" id="">
                            <option value="">个体工商</option>
                            <option value="">集团连锁</option>
                            <option value="">管理公司</option>
                            <option value="">平台供应商</option>
                        </select>
                    </li>
                    <li><label for=""><span></span>供应商品牌：</label><input type="text"></li>
                    <li><label for=""><span>*</span>&nbsp;&nbsp;结算周期：</label>
                        <select name="" id="">
                            <option value="">周结</option>
                            <option value="">月结</option>
                        </select>
                    </li>
                </ul>
                <button class="btn btn-primary add_person">添加联系人</button>
                <div class="contact_box">
                    <dl class="contact_title content_item clearfix">
                        <dd class="type">联系人</dd>
                        <dd class="name">姓名</dd>
                        <dd class="job">职务</dd>
                        <dd class="mobile">手机号码</dd>
                        <dd class="email">E-mail</dd>
                        <dd class="phone">电话</dd>
                        <dd class="operate">操作</dd>
                    </dl>
                    <ul class="content_item content_con clearfix">
                        <li class="li_item"><span>业务联系人</span><input type="text" placeholder="请输入联系人"></li>
                        <li class="li_item"><span>王小毛</span><input type="text" placeholder="请输入姓名"></li>
                        <li class="li_item"><span>店长</span><input type="text" placeholder="请输入职务"></li>
                        <li class="li_item"><span>18888888888</span><input type="text" placeholder="请输入手机号码" maxlength="11"></li>
                        <li class="li_item"><span>asd@qq.com</span><input type="text" placeholder="请输入E-mail"></li>
                        <li class="li_item"><span>010-12345678</span><input type="text" placeholder="请输入电话"></li>
                        <li class="li_item"><div class="op_eds"><p class="edit">编辑</p><p class="save">保存</p></div><p class="delete">删除</p></li>
                    </ul>
                </div>
                <div class="suppy_btn">
                    <button class="btn btn-primary suppy_detail_btn">保存设置</button>
                </div>
            </div>
            <div class="rummery_item rummery_policy" style="display: block;">
                <div class="xhh_conent">
                    <ul class="conent-message">
                        <li>
                            <i>*&nbsp;&nbsp;</i>
                            <span>财务联系人：</span>
                            <input type="" name="" id="hinese" value="" onblur="hinese($('#hinese'),$('.hinese_b'));">
                            <i class="hinese_b"></i>
                        </li>
                        <li>
                            <i>*&nbsp;&nbsp;</i>
                            <span>联系人手机：</span>
                            <input type="" name="" id="cellNumber" value="" onblur="cellNumber($('#cellNumber'),$('.cellNumber_b'));">
                            <i class="cellNumber_b"></i>
                        </li>
                        <li>
                            <i>&nbsp;&nbsp;&nbsp;</i>
                            <span>联系人邮箱：</span>
                            <input type="" name="" id="checkMail" value="" onblur="checkmail($('#checkMail'),$('.checkMail_b'));">
                            <i class="checkMail_b"></i>
                        </li>
                        <li class="bank-name">
                            <i>*&nbsp;&nbsp;</i>
                            <span>银行名称：</span>
                            <input type="" name="" id="bankname" value="" onblur="bankname($('#bankname'),$('.bankname_b'));">
                            <i class="bankname_b">请确保开户银行名称填写正确，否则无法正常打款</i>
                        </li>
                        <li>
                            <i>*&nbsp;&nbsp;</i>
                            <span>开户支行名称：</span>
                            <input type="" name="" id="openingbank" value="" onblur="openingbank();">
                            <i class="openingbank_b">请确保支行名称填写正确，否则无法正常打款</i>
                        </li>
                        <li>
                            <i>*&nbsp;&nbsp;</i>
                            <span>户名：</span>
                            <input type="" name="" id="username" value="" onblur="hinese($('#username'),$('.username'));">
                            <i class="username"></i>
                        </li>
                        <li>
                            <i>*&nbsp;&nbsp;</i>
                            <span>银行账号：</span>
                            <input type="" name="" id="account_number" value="" onblur="luhmCheck(this)">
                            <i class="account_number_b"></i>
                        </li>
                        <li>
                            <i>&nbsp;&nbsp;&nbsp;</i>
                            <span>支付宝账号：</span>
                            <input type="" name="" value="">
                        </li>
                        <li>
                            <i>*&nbsp;&nbsp;</i>
                            <span>账户类型：</span>
                            <select name="" class="conent-account">
                                <option value="对公账户">对公账户</option>
                                <option value="对私账户">对私账户</option>
                                <option value="集团账号">集团账号</option>
                            </select>
                        </li>
                    </ul>
                    <div class="message-footer">
                        <input class="message-footer-save" type="button" name="" id="" value="保存设置" onclick="next()">
                        <!--<input class="message-footer-cancel" type="button" name="" id="" value="取消" />-->
                    </div>
                </div>
            </div>
            <div class="rummery_item rummery_sevice" style="display: none;">
                资质管理
                <!--<ul class="suppy_box">
                    <li><label for=""><span>*</span>供应商名称：</label><input type="text" id="suppy_name2" onblur="suppy_name2()"/><i>请输入完整供应商名称</i></li>
                    <li class="protocol_time clearfix">
                        <label for="" class="fl"><span>*</span>协议有效期：</label>
                        <div class="protocol_box fl">
                            <div class="protocol_con">
                                <input type="text" />
                                <span>至</span>
                                <input type="text" />
                            </div>
                        </div>
                        <i>请选择日期</i>
                  </li>
                  <li><label for=""><span>*</span>营业执照：</label>

                        <div id="uploader-demo">
                            <div id="fileList" class="uploader-list"></div>
                            <div id="filePicker">选择图片</div>
                        </div>
                  </li>
                  <li><label for=""><span>*</span>特种行业许可证：</label></li>
                  <li><label for=""><span>*</span>合作协议：</label><input type="text" /></li>
                  <li><label for=""><span></span>其他：</label></li>
                </ul>
                <p class="notice">可上传的文件类型包括：图片、word、Excel、PPT、压缩文件等</p>-->

                <!--<ul class="conent-message">
                <li>
                    <i>*&nbsp;&nbsp;</i>
                    <span style="width:152px;">供应商名称：</span>
                    <input type="" name="" id="gys_hinese" value="" placeholder="北京哲人酒店管理有限公司" onblur="gys_hinese();" />
                    <i class="gys_hinese_b"></i>
                </li>
                <li>
                    <p class="left" style="width:131px;">
                        <i style="color:red;">*&nbsp;&nbsp;</i>
                        <span>协议有效期：</span>
                    </p>
                    <div class="input-append date left uplist" id="rili" data-date="2012-12-02" data-date-format="yyyy-dd-mm">
                        <input id="d422" name="TravelActivity[start_time]" value="" class="Wdate" type="text" onfocus="var d4312=$dp.$('d4312');WdatePicker({readOnly:true,minDate:'%y-%M-{%d}',onpicked:function(){d4312.focus()}})" placeholder="请设置起始日期" />至
                            <input id="d4312" class="Wdate" name="TravelActivity[end_time]" value="" type="text" placeholder="请设置结束日期" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'d422\')}',readOnly:true,maxDate:'#F{$dp.$D(\'d422\',{M:+6})}'})" />
                            <input type="hidden" class="sxh-hidden">
                            <em id="date-em" style="color:red;margin-left: 20px;font-style: normal;"></em>
                    </div>
                </li>
                <li style="height:auto;">
                    <p class="left" style="width:131px;">
                        <i style="color:red;">*&nbsp;&nbsp;</i>
                        <span >营业执照：</span>
                    </p>
                    <div id="wrapper" class="left uplist">
                        <div id="container">
                            <div id="uploader" class="uploader">
                                <div class="queueList">
                                    <div id="dndArea" class="placeholder">
                                        <div id="filePicker_clc1"></div>
                                    </div>
                                </div>
                                <div class="statusBar" style="display:none;">
                                    <div class="progress">
                                        <span class="text">0%</span>
                                        <span class="percentage"></span>
                                    </div>
                                    <div class="info"></div>
                                    <div class="btns">
                                        <div id="filePicker_str1"></div>
                                        <div class="uploadBtn">开始上传</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <i class="zhizhao"></i>
                    <div style="clear: both;"></div>
                </li>
                <li style="height:auto;">
                    <p class="left" style="width:131px;">
                        <i style="color:red;">*&nbsp;&nbsp;</i>
                        <span>特种行业许可证：</span>
                    </p>
                    <div id="wrapper2" class="left uplist">
                        <div id="container2">

                            <div id="uploader2" class="uploader">
                                <div class="queueList">
                                    <div id="dndArea2" class="placeholder">
                                        <div id="filePicker_click2"></div>
                                    </div>
                                </div>
                                <div class="statusBar" style="display:none;">
                                    <div class="progress">
                                        <span class="text">0%</span>
                                        <span class="percentage"></span>
                                    </div>
                                    <div class="info"></div>
                                    <div class="btns">
                                        <div id="filePicker_start2"></div>
                                        <div class="uploadBtn">开始上传</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <i class="xukezheng"></i>
                    <div style="clear: both;"></div>
                </li>

                <li style="height:auto;">
                    <p class="left" style="width:131px;">
                        <i style="color:red;">*&nbsp;&nbsp;</i>
                        <span>合作协议：</span>
                    </p>
                    <div id="wrapper3" class="left uplist">
                        <div id="container3">

                            <div id="uploader3" class="uploader">
                                <div class="queueList">
                                    <div id="dndArea3" class="placeholder">
                                        <div id="filePicker_click3"></div>
                                    </div>
                                </div>
                                <div class="statusBar" style="display:none;">
                                    <div class="progress">
                                        <span class="text">0%</span>
                                        <span class="percentage"></span>
                                    </div>
                                    <div class="info"></div>
                                    <div class="btns">
                                        <div id="filePicker_start3"></div>
                                        <div class="uploadBtn">开始上传</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <i class="xieyi"></i>
                    <div style="clear: both;"></div>
                </li>
                <li style="height:auto;">
                    <p class="left" style="width:131px;">
                        <i style="color:red;">&nbsp;&nbsp;</i>
                        <span>其他：</span>
                    </p>
                    <div id="wrapper4" class="left uplist">
                        <div id="container4">
                            <div id="uploader4" class="uploader">
                                <div class="queueList">
                                    <div id="dndArea4" class="placeholder">
                                        <div id="filePicker_click4"></div>
                                    </div>
                                </div>
                                <div class="statusBar" style="display:none;">
                                    <div class="progress">
                                        <span class="text">0%</span>
                                        <span class="percentage"></span>
                                    </div>
                                    <div class="info"></div>
                                    <div class="btns">
                                        <div id="filePicker_start4"></div>
                                        <div class="uploadBtn">开始上传</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="clear: both;"></div>
                </li>
            </ul>
            <div>
                <input type="button" class="zizhi_button message-footer-save" value="保存设置" onclick="baocun()" />
            </div>



            </div>
            <div class="rummery_item rummery_house" style="display: none;">关联酒店列表</div>
            <div class="rummery_item rummery_price" style="display: none;">
                <div class="cont">
                    <div class="financial_header">
                        <ul>
                            <li class="bac">
                                账户信息
                            </li>
                            <li>
                                供应商结算
                            </li>
                        </ul>
                    </div>
                    <div class="active">
                        <div class="active_one on">
                            <ul class="bank_information">
                                <li>
										<span>
											户名：
										</span>
                                    北京棠果管理有限公司
                                </li>
                                <li>
										<span>
											开户银行：
										</span>
                                    中国人民银行北京车公庄支行
                                </li>
                                <li>
										<span>
											银行账号：
										</span>
                                    1234567890123456
                                </li>
                                <li>
										<span>
											账户类型：
										</span>
                                    对公账户
                                </li>
                                <div style="clear: both;"></div>
                            </ul>
                            <ul class="bank_information bank_accunt">
                                <li>
										<span>
											支付宝账号：
										</span>
                                    xxxxxx@aliyun.com
                                </li>

                                <div style="clear: both;"></div>
                            </ul>
                            <ul class="bank_information bank_accunt">
                                <li>
										<span>
											财务联系人：
										</span>
                                    王小毛
                                </li>
                                <li>
										<span>
											联系人邮箱：
										</span>
                                    xxxxx@xxxx.com
                                </li>
                                <li>
										<span>
											联系人手机：
										</span>
                                    18866668888
                                </li>
                                <li>
										<span>
											账户类型：
										</span>
                                    对公账户
                                </li>
                                <div style="clear: both;"></div>
                            </ul>
                        </div>
                        <!--供应商结算-->
                        <div class="active_one">
                            <ul class="active_one_close">
                                <li>
                                    <span>结算周期:</span>
                                    2017.02.01-2017.02.28
                                </li>
                                <li>
										<span>
											已出账单：
										</span>
                                    <p class="price">
                                        ￥9900.00
                                    </p>
                                    <input type="button" name="" id="" value="查看">
                                    <input type="button" name="" id="" value="未查看">
                                    <input type="button" name="" id="" value="未开票">
                                </li>
                                <li>
										<span>
											未出账单：
										</span>
                                    <p class="price price_size">
                                        ￥18000.00
                                        <i>2017.03.01-2017.03.25</i>
                                    </p>
                                    <input type="button" name="" id="" value="查看">
                                </li>
                            </ul>
                            <div class="suppy_list">
                                以下为列表
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Your Page Content Here -->

</section>
