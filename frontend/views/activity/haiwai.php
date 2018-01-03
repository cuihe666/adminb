<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>各分会场-出境类</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/stay.css">
    <script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
  </head>
  <body>
    <div class="jz_main">
      <div class="nav" style="">
        <img src="<?= Yii::$app->request->baseUrl ?>/images/fanhui.png" alt="" class="fanhui">
        <span>棠果旅居节 优惠嗨不停</span>
        <?php if($_GET['type']=='app'){ ?>
        <img src="<?= Yii::$app->request->baseUrl ?>/images/share.png" alt="" class="share">
        <?php } ?>
      </div>
      <div class="jz_top">
        <img src="<?= Yii::$app->request->baseUrl ?>/images/haiwai_top.png" alt="">
      </div>
      <div class="line-con">
        <?php foreach($higo as $k=>$v): ?>
          <div class="div1" higo_id="<?php echo $v['id'] ?>">
            <img src="<?php echo $v['title_pic'][$v['first_pic']] . '?imageView2/1/w/350/h/260' ?>" alt="">
            <p class="first_p"><?php echo $v['name']; ?></p>
            <p class="p1">
              <em>¥<?php echo $v['price']; ?>起</em>
            </p>
          </div>
        <?php endforeach; ?>
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
      var status = $('.status').val();
      var uid = $('.uid').val();
      if (uid == 0) {
        if (status == 2) {
          window.location.href = $('.last_url').val();
        } else {
          history.back();
        }
      } else {
        if (status == 1) {
          window.location.href = $('.last_url').val();
        } else {
          window.location.href = $('.last_url').val() + '&uid=' + uid;
        }
      }
    })

    $('.div1').click(function(){
      var higo_id=$(this).attr('higo_id');
      var uid = $('.uid').val();
      var type = $('.mode').val();
      if(type=='app'){
        var str={higo_id:higo_id,type:3};
        detail(str);
      }else{
//        var url="http://lvcheng.tgljweb.com/indexdk/detail?higo_id="+higo_id+'&resource=78';
        var url="http://106.14.16.252:8088/indexdk/detail?higo_id="+higo_id+'&resource=78';
        location.href =url;
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
