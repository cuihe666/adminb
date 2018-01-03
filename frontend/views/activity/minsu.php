<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>各分会场-住宿类</title>
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
        <img src="<?= Yii::$app->request->baseUrl ?>/images/tese_minsu.jpg" alt="">
      </div>
      <div class="jz_content">
        <div class="bj_content">
          <h2>北京</h2>
          <ul class="house_id">
            <?php foreach($beijing as $k=>$v): ?>
            <li house_id="<?php echo $v['id']; ?>">
              <img src="http://img.tgljweb.com/<?php echo $v['cover_img']; ?>?imageView2/1/w/200/h/150" alt="">
              <p><?php echo $v['title']; ?></p>
              <span>¥<?php echo $v['price']; ?><b>起</b></span>
            </li>
            <?php endforeach; ?>
          </ul>
          <div style="clear:both"></div>
        </div>
        <div class="bj_content">
          <h2>成都</h2>
          <ul class="house_id">
            <?php foreach($chengdu as $k=>$v): ?>
              <li house_id="<?php echo $v['id']; ?>">
                <img src="http://img.tgljweb.com/<?php echo $v['cover_img']; ?>?imageView2/1/w/200/h/150" alt="">
                <p><?php echo $v['title']; ?></p>
                <span>¥<?php echo $v['price']; ?><b>起</b></span>
              </li>
            <?php endforeach; ?>
          </ul>
          <div style="clear:both"></div>
        </div>
        <div class="bj_content">
          <h2>沈阳</h2>
          <ul class="house_id">
            <?php foreach($shenyang as $k=>$v): ?>
              <li house_id="<?php echo $v['id']; ?>">
                <img src="http://img.tgljweb.com/<?php echo $v['cover_img']; ?>?imageView2/1/w/200/h/150" alt="">
                <p><?php echo $v['title']; ?></p>
                <span>¥<?php echo $v['price']; ?><b>起</b></span>
              </li>
            <?php endforeach; ?>
          </ul>
          <div style="clear:both"></div>
        </div>
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
