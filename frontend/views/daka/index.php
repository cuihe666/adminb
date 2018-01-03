<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>大咖邀你游世界</title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="pragma" content="no-cache" />
	<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" name="viewport" id="viewport" />
	<link rel="stylesheet" type="text/css" href="<?= Yii::$app->request->baseUrl ?>/css/tg_mobile_reset.css">
	<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/index.css">
	<script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/js/rem.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/js/base.js"></script>
	<script type="text/javascript" src="<?= Yii::$app->request->baseUrl ?>/js/index.js"></script>
	<script type="text/javascript">
		$(function(){
			$(document).on('scroll',function(){
				if($("body").scrollTop()>=44){
					$(".gotop").addClass('show');
				}else{
					$(".gotop").removeClass("show");
				}
			})
			// gotop
			$(".gotop").on("click",function(){
				$("body").stop().animate({"scrollTop":0},1000);
			})
			$(".download").on("click",".close",function(){
				$(this).parents(".download").hide();
			})
//			分享页面有下载
			function zcGetLocationParm(argu_name,curr_str) { //获取url参数argu_name的值,如果未获取到则返回空,原生JS完成,不依赖$,获取不到时返回空串''
				var i=0;
				var url = curr_str||window.location.href;
				var arguStr = url.split('?')[1];
				var key_val_s = [];
				var len = 0;
				var result='';
				if(arguStr) {
					key_val_s = arguStr.split('&');
					len = key_val_s.length;
					for(i=0;i<len;i++) {
						if(argu_name==key_val_s[i].split('=')[0]) {
							result=key_val_s[i].split('=')[1];
							break;
						}
					}
				}
				return result? result=='null'?'':result :'';
			}
			var parm = zcGetLocationParm("share") ;
			if(parm){
				$(".download").show();
			}
		})
	</script>
</head>
<body>
<!--<div id="pt_wp" class="h_top">-->
<!--	<div class="header color333">-->
<!--		<div class="goback"></div>-->
<!--		<div class="titleTxt">大咖邀你游世界</div>-->
<!--		<div class="head_right">-->
<!--			<div class="theme_share"></div>-->
<!--		</div>-->
<!--	</div>-->
<!--</div>-->
	<div class="wrap">
		<div class="banner po_re"></div>
		<div class="content">
			<p class="description">用最酷的方式打开旅行，让每个地方都具有心跳和温度，棠果旅居通过共享的方式，让更多的人体验到了不一样的旅行方式，也因此获得了多国政要及组织机构负责人的集体热捧。我想，只有深入当地生活，跟着对当地的每个角落每种玩法都聊熟于心的人，才能找到最有趣最好玩的乐趣吧。你看，就连这些高高在上的政要们也都坚定的选择了这些线路，毕竟，他们是见惯了美景阅尽天下走在最前端的人！快来看看他们最喜欢的地方，来一场说走就走的新鲜惊喜的旅行吧。<p>
			<div class="title po_re">
				<div class="line po_ab"></div>
				<div class="word po_ab">线下预订</div>
			</div>
			<div class="item w345">
				<img src="<?= Yii::$app->request->baseUrl ?>/img/daka1.jpg" alt="" />
				<p class="title clearfix"><em class="fl"></em><span class="fl">泰国副总理披尼</span></p>
				<p class="des">别看日理万机，泰国前副总理披尼可是个追剧小达人呢，他说最近有计划带上爱人去一趟普吉岛，因为小包总和安迪实在太有爱了。宽阔美丽的海滩、洁白无瑕的沙粒、碧绿翡翠的海水，作为印度洋安达曼海上的一颗“明珠”，普吉岛确实是情侣们必去了。</p>
				<div class="price_box po_re">
					<img src="<?= Yii::$app->request->baseUrl ?>/img/item_pic1.jpg" alt="" class="po_ab" />
					<div class="price po_ab">¥4599起</div>
				</div>
				<div class="item_pic_des w345">
					<p>锦绣普吉-穿的美美的邂逅你的小包总OR安迪</p>
					<span>上海出发－普吉岛七日游</span>
					<em>预订电话：400-640-6111</em>
				</div>
			</div>
			
			<div class="item w345">
				<img src="<?= Yii::$app->request->baseUrl ?>/img/daka3.jpg" alt="" />
				<p class="title clearfix"><em class="fl"></em><span class="fl">爱尔兰前总理布赖恩·科恩</span></p>
				<p class="des">自和金东哲先生相识以来，爱尔兰前总理布赖恩·科恩一直看好棠果旅居的发展，尤其是对棠果旅行所推出的线路颇有好感，他建议棠果的粉丝们去欧洲游玩不能错过腐国英国，这里有英超的激情和田园牧歌，这里有前卫时尚和绅士风度，值得品味的英伦世界，对了，还有习大大点名要品尝的国菜炸鱼薯条。</p>
				<div class="price_box po_re">
					<img src="<?= Yii::$app->request->baseUrl ?>/img/item_pic3.jpg" alt="" class="po_ab" />
					<div class="price po_ab">¥12000起</div>
				</div>
				<div class="item_pic_des w345">
					<p>去尝尝习大大点名要品尝的英国国菜—炸鱼薯条  </p>
					<span>上海出发－英国</span>
					<em>预订电话：400-640-6111</em>
				</div>
			</div>
			<div class="item w345">
				<img src="<?= Yii::$app->request->baseUrl ?>/img/daka4.jpg" alt="" />
				<p class="title clearfix"><em class="fl"></em><span class="fl">荷兰前首相维姆·科克</span></p>
				<p class="des">风车、郁金香、河流纵横，荷兰前首相维姆·科克对自己的国家尤其骄傲，除了荷兰，他推荐憧憬着有朝一日能来到童话世界的棠果用户，不要错过北欧的童话之旅。每当夏季的到来，24小时的阳光取代了冬季的漫漫长夜，这样的强烈反差也吸引着来自各国的游客。壮观辽阔的冰川、奇特的黄金圈、北欧式的建筑、熙熙攘攘的滑雪胜地、和多姿多彩的极光……</p>
				<div class="price_box po_re">
					<img src="<?= Yii::$app->request->baseUrl ?>/img/item_pic4.jpg" alt="" class="po_ab" />
					<div class="price po_ab">¥28500起</div>
				</div>
				<div class="item_pic_des w345">
					<p> 童话之旅，斯堪的纳维亚四国风情体验</p>
					<span>上海出发－北欧－冰岛</span>
					<em>预订电话：400-640-6111</em>
				</div>
			</div>
			<div class="item w345">
				<img src="<?= Yii::$app->request->baseUrl ?>/img/daka5.jpg" alt="" />
				<p class="title clearfix"><em class="fl"></em><span class="fl">罗马尼亚前总理彼得·罗曼</span></p>
				<p class="des">印度尼西亚是令世人无比向往的天然旅游度假地，罗马尼亚前总理彼得.罗曼也不例外。处处青山绿水，四季皆夏，人们称印尼为“赤道上的翡翠”。这里对世界开放同时完整的保留了自己的传统，这里向全世界提供最休闲的度假环境以及美食，这里有叮叮咚咚的音乐，这里有近万个大大小小的岛屿,如同珍珠撒落在印度洋上，这里每个地域文化各不相同,从东到西千变万化……</p>
				<div class="price_box po_re">
					<img src="<?= Yii::$app->request->baseUrl ?>/img/item_pic5.jpg" alt="" class="po_ab" />
					<div class="price po_ab">¥12800起</div>
				</div>
				<div class="item_pic_des w345">
					<p> 印度尼西亚—爬山涉水异国双享  </p>
					<span>北京出发－查亚峰</span>
					<em>预订电话：400-640-6111</em>
				</div>
			</div>
			<div class="item w345">
				<img src="<?= Yii::$app->request->baseUrl ?>/img/daka6.jpg" alt="" />
				<p class="title clearfix"><em class="fl"></em><span class="fl">棠果战略投资股东奥地利前总理维尔纳·法伊曼</span></p>
				<p class="des">作为山水间的音乐之城，除了可以听一场音乐会、看一场歌剧，在古堡之间流连忘返、体验童话小镇的静谧美好也是奥地利不可错过的玩法了，不过，棠果战略投资股东奥地利前总理维尔纳·法伊曼却推荐了丹麦乐高乐园。这个被称为“小积木搭成的大世界”是用 4450 万块乐高积木搭建而成的，小到人物、动物、汽车船舶，大到高楼大厦、宫殿、教堂，设计建筑师们充分发挥他们的想象力，每一处都让人惊叹，都令人雀跃不已！</p>
				<div class="price_box po_re">
					<img src="<?= Yii::$app->request->baseUrl ?>/img/item_pic6.jpg" alt="" class="po_ab" />
					<div class="price po_ab">¥18900起</div>
				</div>
				<div class="item_pic_des w345">
					<p> 丹麦—乐高乐园Legoland亲子游</p>
					<span>北京出发－乐高主题公园     </span>
					<em>预订电话：400-640-6111</em>
				</div>
			</div>
			<div class="item w345">
				<img src="<?= Yii::$app->request->baseUrl ?>/img/daka7.jpg" alt="" />
				<p class="title clearfix"><em class="fl"></em><span class="fl">波兰前副总理莱舍克·巴尔采罗维奇</span></p>
				<p class="des">提起波兰，你会想起什么？奥斯维辛集中营、肖邦小夜曲、足球……在波兰前副总理莱舍克·巴尔采罗维奇看来，仅仅玩了这些还不够，最地道的玩法恐怕要数登上一列火车，来一场漫无目的的说走就走来得自在。和国内不同，波兰的火车站干净整洁，满满的欧式风情，单凭这一点就不虚此行了，更何况火车不仅可以自由行走波兰，还可随意前往捷克、奥地利等周边国家，想必屏幕前的你也已经按捺不住了吧？</p>
				<div class="price_box po_re">
					<img src="<?= Yii::$app->request->baseUrl ?>/img/item_pic7.jpg" alt="" class="po_ab" />
					<div class="price po_ab">￥23800起</div>
				</div>
				<div class="item_pic_des w345">
					<p>波捷奥三国深度之旅14日游</p>
					<span>古城寻踪－仙境湖畔 </span>
					<em>预订电话：158-1049-2011</em>
				</div>
			</div>
			<div class="item w345">
			    <img src="<?= Yii::$app->request->baseUrl ?>/img/daka2.jpg" alt="" />
			    <p class="title clearfix"><em class="fl"></em><span class="fl">中国驻日本使馆宋耀明公使</span></p >
			    <p class="des">读万卷书不如行万里路，孩子总是在不知不觉中慢慢长大，中国驻日本使馆宋耀明公使认为暑假正是享受亲子时光的好时机，趁着大把时间，带着孩子来一场乐园主题游也是不错的呢。不但能够在日本迪斯尼乐园、富士急乐园、HELLOKUTTY乐园和环球影城四大主题乐园畅爽一夏，感受最佳的亲子体验，还能在京都宇治抹茶diy、品尝日本国粹相扑专用美食、欣赏日式传统艺术表演</p >
			        <div class="price_box po_re">
			            <img src="<?= Yii::$app->request->baseUrl ?>/img/item_pic2.jpg" alt="" />
			            <div class="price po_ab">￥7880起</div>
			        </div>
			        <div class="item_pic_des w345">
			            <p>四大主题乐园亲子游</p >
			            <span>日本本州东阪7天6晚4园自由亲子游</span>
						<em>预订电话：158-1049-2011</em>
			        </div>
			</div>
			<div class="item w345">
				<img src="<?= Yii::$app->request->baseUrl ?>/img/daka8.jpg" alt="" />
				<p class="title clearfix"><em class="fl"></em><span class="fl">赞比亚前总统卢潘多·努瓦佩</span></p>
				<p class="des">对于中国人来说，非洲是一个很神秘的地方，大迁徙大沙漠大瀑布大峡谷，似乎非要加个大字才能体现出它的壮丽，赞比亚前总统卢潘多.努瓦佩极力推荐大家体验非洲4国16日巅峰之旅，不仅可以乘直升机俯瞰赞比亚境内的维多利亚大瀑布，惊叹世界自然奇迹的无比震撼，还能观赏到赞比西河的落日、动物大迁徙、东非大峡谷的宏伟……</p>
				<div class="price_box po_re">
					<img src="<?= Yii::$app->request->baseUrl ?>/img/item_pic8.jpg" alt="" class="po_ab" />
					<div class="price po_ab">￥68800起</div>
				</div>
				<div class="item_pic_des w345">
					<p>肯尼亚、坦桑尼亚、津巴布韦、赞比亚4国16日游</p>
					<span>乞力马扎罗山－维多利亚瀑布－赞比西河－东非大裂谷</span>
					<em>预订电话：158-1049-2011</em>
				</div>
			</div>
			<div class="item w345">
				<img src="<?= Yii::$app->request->baseUrl ?>/img/daka9.jpg" alt="" />
				<p class="title clearfix"><em class="fl"></em><span class="fl">柬埔寨亲王诺罗敦·查克拉朋</span></p>
				<p class="des">古老寺庙里的低声吟语，穿越千年的神秘微笑，柬埔寨是一个静谧古老的神奇国度，柬埔寨亲王诺罗敦·查克拉朋透露，他在闲暇的时候喜欢去吴哥窟，吴哥窟是世界上最大的庙宇，被称作柬埔寨的国宝，1992年，联合国教科文组织将吴哥古迹列入世界文化遗产。此后吴哥窟作为吴哥古迹的重中之重，成为了柬埔寨一张亮丽的旅游名片。</p>
				<div class="price_box po_re">
					<img src="<?= Yii::$app->request->baseUrl ?>/img/item_pic9.jpg" alt="" class="po_ab" />
					<div class="price po_ab">￥4980起</div>
				</div>
				<div class="item_pic_des w345">
					<p>奢华越柬-享受五星豪华酒店度假村</p>
					<span>北京出发－胡志明市－美托－吴哥窟</span>
					<em>预订电话：158-1049-2011</em>
				</div>
			</div>
			<div class="item w345">
				<img src="<?= Yii::$app->request->baseUrl ?>/img/daka10.jpg" alt="" />
				<p class="title clearfix"><em class="fl"></em><span class="fl">塞尔维亚前总统鲍里斯塔迪奇</span></p>
				<p class="des">作为第一个对中国免签的欧洲国家，塞尔维亚的旅游资源也是不容小觑，塞尔维亚前总统鲍里斯塔迪奇对各种玩法也是如数家珍，多瑙河深度感受这座城市的历史沧桑，木头村乘坐山区小火车将优美的山区景色尽收眼底，卡莱梅格丹城堡、圣沙瓦教堂、Mileseva修道院，难怪被《孤独星球》和《悦游全球旅行网》评为“年度十大最佳旅行国家”和“年度最值得去的15个目的地”。</p>
				<div class="price_box po_re">
					<img src="<?= Yii::$app->request->baseUrl ?>/img/item_pic10.jpg" alt="" class="po_ab" />
					<div class="price po_ab">￥14800起</div>
				</div>
				<div class="item_pic_des w345">
					<p>塞尔维亚－地9天－前南斯拉夫的记忆</p>
					<span>四、五星酒店－赠送Wi-Fi</span>
					<em>预订电话：158-1049-2011</em>
				</div>
			</div>
			<div class="item w345">
				<img src="<?= Yii::$app->request->baseUrl ?>/img/daka11.jpg" alt="" />
				<p class="title clearfix"><em class="fl"></em><span class="fl">西班牙前首相何塞·路易斯·萨帕特罗</span></p>
				<p class="des">西班牙人太会玩，西班牙前首相何塞·路易斯·萨帕特罗在向棠果旅居推荐最值得玩的项目时，竟然推荐了番茄节！和奔牛节一样，西红柿节也是西班牙闻名世界的传统节日，每年秋季的丰收都会让西班牙人们喜上眉梢，他们为了表达对西红柿丰收的喜悦和热爱，于是选择了——砸西红柿。</p>
				<div class="price_box po_re">
					<img src="<?= Yii::$app->request->baseUrl ?>/img/item_pic11.jpg" alt="" class="po_ab" />
					<div class="price po_ab">￥24800起</div>
				</div>
				<div class="item_pic_des w345">
					<p>西红柿节嗨翻天 西班牙深度12日游</p>
					<span>西班牙－激情狂欢</span>
					<em>预订电话：158-1049-2011</em>
				</div>
			</div>
		</div>
		<div class="download">
			<span class="close"></span>
			<a href="http://www.xywykj.com/">下载</a>
		</div>
	</div>
	<div class="gotop"></div>
</body>
</html>