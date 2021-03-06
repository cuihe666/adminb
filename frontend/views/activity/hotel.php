<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>各分会场-酒店类</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/stay.css">
    <script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
  </head>
  <style media="screen">
    html,body{
      background-color:#a521fe;
    }
    .jz_main .jz_top{
      background-color:#8c0ce2;
      padding-bottom:5%;
    }

  </style>

  <body>
    <div class="jz_main">
      <div class="nav">
        <img src="<?= Yii::$app->request->baseUrl ?>/images/fanhui.png" alt="" class="fanhui">
        <span>棠果旅居节 优惠嗨不停</span>
        <?php if($_GET['type']=='app'){ ?>
        <img src="<?= Yii::$app->request->baseUrl ?>/images/share.png" alt="" class="share">
        <?php } ?>
      </div>
      <div class="jz_top">
        <img src="<?= Yii::$app->request->baseUrl ?>/images/hotel_top.jpg" alt="">
      </div>
      <div class="jz_content">
        <div class="bj_content">
          <h2>酒店</h2>
          <ul class="house_id">
            <?php foreach($hotel as $k=>$v): ?>
              <li house_id="<?php echo $v['id']; ?>">
                <img src="http://img.tgljweb.com/<?php echo $v['cover_img']; ?>?imageView2/1/w/200/h/150" alt="">
                <p><?php echo $v['title']; ?></p>
                <span>¥<?php echo $v['price']; ?><b>起</b></span>
              </li>
            <?php endforeach; ?>
          </ul>
          <div style="clear:both"></div>
        </div>
<!--        <div class="bj_content">-->
<!--          <h2>丽江</h2>-->
<!--          <ul class="house_id">-->
<!--            <li house_id="1767210">-->
<!--              <img src="http://img.tgljweb.com/landlord_1767210_149924612311799.jpg?imageView2/1/w/200/h/150" alt="">-->
<!--              <p>丽江铂尔曼度假酒店豪华大床房</p>-->
<!--              <span>¥1485<b>起</b></span>-->
<!--            </li>-->
<!--            <li class="li01" house_id="1767212">-->
<!--              <img src="http://img.tgljweb.com/landlord_1767212_149924760619505.jpg?imageView2/1/w/200/h/150" alt="">-->
<!--              <p>丽江金茂君悦酒店君悦客房</p>-->
<!--              <span>¥1550<b>起</b></span>-->
<!--            </li>-->
<!--            <li house_id="1767216">-->
<!--              <img src="http://img.tgljweb.com/landlord_1767216_149924852172003.jpg?imageView2/1/w/200/h/150" alt="">-->
<!--              <p>和府洲际度假酒店高级房大床</p>-->
<!--              <span>¥1600<b>起</b></span>-->
<!--            </li>-->
<!--            <li class="li01" house_id="1767251">-->
<!--              <img src="http://img.tgljweb.com/landlord_1767251_149931890680270.jpg?imageView2/1/w/200/h/150" alt="">-->
<!--              <p>丽江王府饭店豪华单人间</p>-->
<!--              <span>¥490<b>起</b></span>-->
<!--            </li>-->
<!--          </ul>-->
<!--          <div style="clear:both"></div>-->
<!--        </div>-->
      </div>
    </div>
    <input type="hidden" value="<?php echo isset($_GET['uid']) ? $_GET['uid'] : 0; ?>" class="uid">
    <input type="hidden" value="<?php echo $_GET['type'] ?>" class="mode">
    <input type="hidden" value="<?php echo $status; ?>" class="status">
    <input type="hidden" value="<?php echo $last_url; ?>" class="last_url">
    <input type="hidden" value="<?php echo $url; ?>" class="url">
  </body>
</html>
<script>
  function login(url){
    var u = navigator.userAgent;
    var isAndroid = u.indexOf('Android') > -1; //android终端
    var isdiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
    if(isdiOS){
      function showIosToast(){
        window.webkit.messageHandlers.userLogin.postMessage(url);
      }
      showIosToast();
    }
    if(isAndroid){
      function showAndroidToast() {
//                javascript:jsandroid.alipay();
        window.h5Interface.toLogin();
      }
      showAndroidToast();
    }
  }


  function detail(str){
    var u = navigator.userAgent;
    var isAndroid = u.indexOf('Android') > -1; //android终端
    var isdiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
    if(isdiOS){
      function showIosDetail(){
        window.webkit.messageHandlers.showDetail.postMessage(str);
      }
      showIosDetail();
    }
    if(isAndroid){
      function showAndroidDetail() {
        if(str.type==1){
          window.h5Interface.toDetailActivity(str.type,str.house_id);
        }
        if(str.type==2){
          window.h5Interface.toDetailActivity(str.type,str.local_id);
        }
        if(str.type==3){
          window.h5Interface.toDetailActivity(str.type,str.higo_id);
        }
      }
      showAndroidDetail();
    }
  }
  $(function(){
    $('.fanhui').click(function () {
      var uid = $('.uid').val();
      var type=$('.mode').val();
      if(type=='app'){
        history.back();
      }else{
        if(uid==0){
          window.location.href="/activity/baofa?type="+type;
        }else{
          window.location.href="/activity/baofa?type="+type+'&uid='+uid;
        }
      }
    })

    $('.house_id li').click(function(){
      var house_id=$(this).attr('house_id');
      var uid = $('.uid').val();
      var type = $('.mode').val();
      if (uid == 0) {
        if (type == 'h5') {
          location.href = "http://www.xywykj.com/";
          return;
        }else{
          var url = window.location.href;
          login(url);
        }
      }else{
        if(type=='h5'){
          location.href = "http://www.xywykj.com/";
          return;
        }else{
          var str={house_id:house_id,type:1};
          detail(str);
        }
      }
    })

    $('.share').click(function(){
      var url=$('.url').val()+'?type=h5';
      var img='share__78.png';
      var title='棠果旅居节';
      var content='5亿红包狂撒一夏，超值东南亚线路999元起';
      var str={shareImgUrl:img,shareContent:content,shareTitle:title,shareUrl:url};
      var u = navigator.userAgent;
      var isAndroid = u.indexOf('Android') > -1; //android终端
      var isdiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
      if(isdiOS){
        function showIosDetail(){
          window.webkit.messageHandlers.share.postMessage(str);
        }
        showIosDetail();
      }
      if(isAndroid){
        function showAndroidShare() {
          window.h5Interface.share(title,content,url,img);
        }
        showAndroidShare();
      }
    })


  })
</script>
