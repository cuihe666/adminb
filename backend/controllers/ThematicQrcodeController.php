<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/7/5
 * Time: 9:52
 */

namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\helpers\Url;

use backend\models\ThematicActivity;
use backend\models\ThematicQrcode;
use backend\models\ThematicQrcodeQuery;
use backend\models\TravelOrderQuery;

class ThematicQrcodeController extends Controller
{
    //统计模板所使用的参数
    private $_totalViewParams = [
        //标记是哪个页面需要使用的统计代码
        'tag' => '',
    ];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * 首页-列表数据页
     */
    public function actionIndex(){
        //通过url提交过来的参数
        $tid = (int)Yii::$app->request->get('tid',0);

        $thematicActivityModel  = new ThematicActivity();

        $searchModel            = new ThematicQrcodeQuery();
        //通过表单提交过来的参数
        $searchModelParams      = Yii::$app->request->queryParams;
        //其他要处理的参数
        $otherParams            = [
            'tid'   => $tid,
        ];
        $dataProvider           = $searchModel->search($searchModelParams,$otherParams);

        $thematicActivityInfo   = $thematicActivityModel->getDataById($tid);
        if( empty($thematicActivityInfo) ){
            throw new \Exception('请求的专题活动数据已不存在');
        }

        //添加完二维码后的跳转url地址,
        $refreshUrl = Url::toRoute(['thematic-qrcode/index','tid'=>$tid]);

        return $this->render('index', [
            'searchModel'           => $searchModel,
            'dataProvider'          => $dataProvider,
            'thematicActivityInfo'  => $thematicActivityInfo,
            'refreshUrl'            => $refreshUrl,
            'tid'                   => $tid,
        ]);
    }

    /**
     * ajax数据操作-创建二维码
     */
    public function actionCreateqrcode(){
        $res = [
            'status'    => '',
            'info'      => '',
            'data'      => [],
        ];


        $thematicActivityModel  = new ThematicActivity();
        $thematicQrcodeModel    = new ThematicQrcode();

        try{
            if( !Yii::$app->request->isAjax ){
                throw new \Exception('request_method_error');
            }
            $request = Yii::$app->request->post();

            //对象挂钩上post表单数据,表单的name就是数据库的字段名
            $thematicQrcodeModel->load($request,'');

            //自定义参数的二维码url:处理h5_link携带上自定义参数
            if( isset($thematicQrcodeModel->tid) ){
                //获取专题活动数据
                $thematicActivityInfo = $thematicActivityModel->getDataById($thematicQrcodeModel->tid);
                if( empty($thematicActivityInfo) ){
                    throw new \Exception('thematicQrcodeInfo_empty');
                }
                //获取专题活动数据的h5链接
                $h5Link = isset($thematicActivityInfo['h5_link']) ? $thematicActivityInfo['h5_link'] : '';
                if( empty($h5Link) ){
                    throw new \Exception('thematicQrcodeInfo_h5Link_empty');
                }
                //查询该专题活动下的自定义参数是否已存在,已存在,则不能继续添加
                $findThematicQrcode = $thematicQrcodeModel->getDataByOne([
                    'tid'           => $thematicQrcodeModel->tid,
                    'custom_params' => $thematicQrcodeModel->custom_params,
                ]);
                if( !empty($findThematicQrcode) ){
                    throw new \Exception('the_tid_custom_params_exists');
                }

                //处理自定义参数的url的key值
                $urlCustomParams = 'custom='.$thematicQrcodeModel->custom_params;
                //要么是xxx.com?custom=xxx要么是xxx.com?xxx=xxx&custom=xxx
                $thematicQrcodeModel->qrcode_url = stripos($h5Link,'?')===false ? $h5Link.'?'.$urlCustomParams : $h5Link.'&'.$urlCustomParams;
            }

            //创建者
            $thematicQrcodeModel->creator = Yii::$app->user->identity->getId();

            $thematicQrcodeModel->save();
            //若有错误存在,则获取第一个提示的错误
            if( $thematicQrcodeModel->hasErrors() ){
                throw new \Exception(key($thematicQrcodeModel->getFirstErrors()));
            }

            $res['status'] = 'ok';

        }catch(\Exception $e){
            $msg = $e->getMessage();
            $errMap = [
                'request_method_error'                  => '请求方法错误',
                'thematicQrcodeInfo_empty'              => '专题活动数据不存在',
                'thematicQrcodeInfo_h5Link_empty'       => '专题活动数据的H5链接不存在',
                'the_tid_custom_params_exists'          => '该专题活动下已存在[<span style="color:red;">'.$thematicQrcodeModel->custom_params.'</span>]自定义参数,请重新操作',
            ];
            $firstErrors = $thematicQrcodeModel->getFirstErrors();
            $errInfo = '操作失败';

            isset($errMap[$msg]) && ( $errInfo = $errMap[$msg] );
            isset($firstErrors[$msg]) && ( $errInfo = $firstErrors[$msg] );
            $res['info'] = $errInfo;
        }

        echo json_encode($res,JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * 该自定义参数的新增用户统计-列表数据页
     */
    public function actionNewusertotal(){
        $this->_totalViewParams['tag'] = 'newusertotal';
        return $this->_totalView();
    }

    /**
     * 该自定义参数的新增用户统计-列表数据页
     */
    public function actionOrdertotal(){
        $this->_totalViewParams['tag'] = 'ordertotal';
        return $this->_totalView();
    }

    /**
     * 公用处理统计模板
     */
    private function _totalView(){

        //专题活动id
        $tid                    = Yii::$app->request->get('tid',0);
        //专题活动下的二维码数据ID
        $thematicQrcodeId       = Yii::$app->request->get('thematic_qrcode_id',0);

        $searchModel            = new ThematicQrcodeQuery();
        //二维码数据
        $thematicQrcodeInfo     = $searchModel->getDataById($thematicQrcodeId);
        if( empty($thematicQrcodeInfo) ){
            throw new \Exception('请求的专题活动-二维码数据已不存在');
        }

        //是否是该专题活动默认的二维码数据,如果是,则查询的是该专题活动下的所有二维码数据,而不会携带自定义参数查询
        $customDefault = isset($thematicQrcodeInfo['custom_params']) && $thematicQrcodeInfo['custom_params']=='default' ? 1 : 0;

        //通过表单提交过来的参数
        $searchModelParams      = Yii::$app->request->queryParams;
        //其他要处理的参数
        $otherParams            = [
            'tid'                   => $tid,
            'thematic_qrcode_id'    => $thematicQrcodeId,
            'custom_default'        => $customDefault,
        ];

        //要显示的数据列表对象
        $dataProvider = null;
        //跳转到哪的Url
        $toUrl = '';
        //显示哪个模板文件
        $showView = '';
        //要传的模板参数
        $showViewParams = [
            'tid'                   => $tid,
            'thematicQrcodeId'      => $thematicQrcodeId,
            'thematicQrcodeInfo'    => $thematicQrcodeInfo,
        ];
        switch($this->_totalViewParams['tag']){
            case 'newusertotal':
                $dataProvider   = $searchModel->newusertotalSearch($searchModelParams,$otherParams);
                $toUrl          = 'thematic-qrcode/newusertotal';
                $showView       = 'newusertotal';
                $showViewParams['searchModel']  = $searchModel;
            break;
            case 'ordertotal':
                $travelOrderQueryModel = new TravelOrderQuery();
                $travelOrderQueryModel->COMMON_CALLEDTAG    = 'ThematicQrcode_Ordertotal';
                $travelOrderQueryModel->COMMON_THEME_TYPE   = $tid;
                $travelOrderQueryModel->COMMON_QRCODE_ID    = $thematicQrcodeId;
                //如果是专题活动默认二维码的,则不统计该默认二维码数据的
                if( $customDefault==1 ){
                    $travelOrderQueryModel->COMMON_QRCODE_ID    = null;
                }
                $dataProvider   = $travelOrderQueryModel->search($searchModelParams);
                $toUrl          = 'thematic-qrcode/ordertotal';
                $showView       = 'ordertotal';
                $showViewParams['searchModel']  = $travelOrderQueryModel;
            break;
        }

        //存储数据列表对象
        $showViewParams['dataProvider'] = $dataProvider;

        //页面刷新时的url地址
        $showViewParams['refreshUrl'] = Url::toRoute([$toUrl,'thematic_qrcode_id'=>$thematicQrcodeId,'tid'=>$tid]);

        return $this->render($showView,$showViewParams);
    }

}