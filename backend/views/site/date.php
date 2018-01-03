<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
    <link href="<?= Yii::$app->request->baseUrl ?>/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="<?= Yii::$app->request->baseUrl ?>/css/bootstrap-datetimepicker.min.css" rel="stylesheet"
          media="screen">
    <script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/js/bootstrap-datetimepicker.min.js"
            charset="UTF-8"></script>
    <script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/js/bootstrap-datetimepicker.zh-CN.js"
            charset="UTF-8"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            text-decoration: none;
        }

        .cont {
            width: 30%;
            margin: 30px auto 0;
            margin-top: 200px;
        }

        .header {
            width: 100%;
            height: 30px;
        }

        .header p {
            width: 33%;
            font-size: 16px;
            height: 120px;
            text-align: center;
            line-height: 30px;
            float: left;
            cursor: pointer;
        }

        table {
            width: 100%;
            text-align: center;
            padding: 10px;
            margin-top: 40px;
        }

        table td {
            padding: 30px;
        }

        .on {
            display: block !important;
        }

        .active div {
            display: none;
        }
    </style>
</head>

<body>
<div class="form-group">
    <label for="dtp_input1" class="col-md-2 control-label">DateTime Picking</label>
    <input type="text" id="datetimepicker" class="start_time" name="start_time">
    <input type="hidden" id="dtp_input1" value=""/><br/>
</div>
<div class="form-group">
    <label for="dtp_input1" class="col-md-2 control-label">DateTime Picking</label>
    <input type="text" id="datetimepicker1" class="end_time" name="end_time">
    <input type="hidden" id="dtp_input1" value=""/><br/>
</div>
<div class="form-group">
    <button class="btn btn-primary btn-date">提交</button>
</div>
<div class="cont">

    <div class="header">
        <p class="p1">
            2016年10月
        </p>
        <p>
            2016年11月
        </p>
        <p>
            2016年12月
        </p>
    </div>
    <div class="active">
        <div>
            <table border="0" cellspacing="10" cellpadding="0">
                <tr>

                    <th>1日</th>
                    <th>一</th>
                    <th>二</th>
                    <th>三</th>
                    <th>四</th>
                    <th>五</th>
                    <th>六</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                    <td>5</td>
                    <td>6</td>

                    <td>7</td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>9</td>
                    <td>10</td>
                    <td>11</td>
                    <td>12</td>
                    <td>13</td>
                    <td>14</td>
                </tr>
                <tr>
                    <td>15</td>
                    <td>16</td>
                    <td>17</td>
                    <td>18</td>
                    <td>19</td>
                    <td>20</td>
                    <td>21</td>
                </tr>
                <tr>
                    <td>22</td>
                    <td>23</td>
                    <td>24</td>
                    <td>25</td>
                    <td>26</td>
                    <td>27</td>
                    <td>28</td>
                </tr>
                <tr>
                    <td>29</td>
                    <td>30</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>
        <!--第二个-->
        <div>
            <table border="0" cellspacing="10" cellpadding="0">
                <tr>
                    <th>2日</th>
                    <th>一</th>
                    <th>二</th>
                    <th>三</th>
                    <th>四</th>
                    <th>五</th>
                    <th>六</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                    <td>5</td>
                    <td>6</td>
                    <td>7</td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>9</td>
                    <td>10</td>
                    <td>11</td>
                    <td>12</td>
                    <td>13</td>
                    <td>14</td>
                </tr>
                <tr>
                    <td>15</td>
                    <td>16</td>
                    <td>17</td>
                    <td>18</td>
                    <td>19</td>
                    <td>20</td>
                    <td>21</td>
                </tr>
                <tr>
                    <td>22</td>
                    <td>23</td>
                    <td>24</td>
                    <td>25</td>
                    <td>26</td>
                    <td>27</td>
                    <td>28</td>
                </tr>
                <tr>
                    <td>29</td>
                    <td>30</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>
        <!--第三个-->
        <div>
            <table border="0" cellspacing="10" cellpadding="0">
                <tr>
                    <th>3日</th>
                    <th>一</th>
                    <th>二</th>
                    <th>三</th>
                    <th>四</th>
                    <th>五</th>
                    <th>六</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                    <td>5</td>
                    <td>6</td>
                    <td>7</td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>9</td>
                    <td>10</td>
                    <td>11</td>
                    <td>12</td>
                    <td>13</td>
                    <td>14</td>
                </tr>
                <tr>
                    <td>15</td>
                    <td>16</td>
                    <td>17</td>
                    <td>18</td>
                    <td>19</td>
                    <td>20</td>
                    <td>21</td>
                </tr>
                <tr>
                    <td>22</td>
                    <td>23</td>
                    <td>24</td>
                    <td>25</td>
                    <td>26</td>
                    <td>27</td>
                    <td>28</td>
                </tr>
                <tr>
                    <td>29</td>
                    <td>30</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
</div>
</body>
<script>
    $(document).ready(function () {
        $(".active div").eq(0).addClass("on")
        $(".header p").click(function () {
            $(".active div").eq($(".header p").index(this)).addClass("on").siblings().removeClass('on');
        });
    })
</script>
<script type="text/javascript">
    $('#datetimepicker').datetimepicker({
        language: 'zh-CN',
        format: 'yyyy-mm-dd',
        setDate: new Date(),
        weekStart: 1,
//todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('#datetimepicker1').datetimepicker({
        language: 'zh-CN',
        format: 'yyyy-mm-dd',
        setDate: new Date(),
        weekStart: 1,
//todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });
    $('.form_date').datetimepicker({
        language: 'fr',
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('.form_time').datetimepicker({
        language: 'fr',
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 1,
        minView: 0,
        maxView: 1,
        forceParse: 0
    });
</script>
<script>
    $(function () {
        $('.btn-date').click(function () {
            var date1 = $('.start_time').val();
            var date2 = $('.end_time').val();
            $.ajax({
                type: 'post',
                url: "<?php echo \yii\helpers\Url::to(['datepick']) ?>",
                data: {start_time: date1, end_time: date2},
                success: function (data) {

                }
            })
        })
    })
</script>
</html>