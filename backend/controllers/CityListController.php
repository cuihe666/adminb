<?php

namespace backend\controllers;


use backend\models\DtCitySeas;
use backend\models\DtCitySeasQuery;
use backend\models\PinYin;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * TravelOrderController implements the CRUD actions for TravelOrder model.
 */
class CityListController extends Controller
{

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
     * Lists all TravelOrder models.
     *  @ 国家列表入口
     */
    public function actionIndex()
    {
        $searchModel = new DtCitySeasQuery();
        $searchModel['level'] = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $city_name = '国家名称';
        $add_name  = '添加国家';
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'city_name' => $city_name,
            'add_name'  => $add_name,
            'code'      => 'country',
            'level_note'  => 'country',
            'name'      => '',
        ]);
    }
    /**
     * Lists all TravelOrder models.
     *  @ 国家下级列表入口
     */
    public function actionView()
    {
        $code = Yii::$app->request->get('id');
        //查询等级
        $city_level = DtCitySeas::find()
            ->where(['code' => $code])
            ->select(['level', 'name'])
            ->asArray()
            ->one();
        $searchModel = new DtCitySeasQuery();
        if ($code != 10001 && $city_level['level'] === '0') {//省份级别-国外
            $searchModel['abroad_note'] = 'abroad_note';
        } else {
            $searchModel['parent'] = $code;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if ($city_level['level'] === '0') {
            if ($code != 10001) {
                $city_name = '城市名称';
                $add_name = '添加城市';
                $level_note = 'city';
            } else {
                $add_name = '添加省份';
                $city_name = '省份名称';
                $level_note = 'province';
            }
        } else if ($city_level['level'] === '1') {
            $add_name = '添加城市';
            $city_name = '城市名称';
            $level_note = 'city';
        } else {
            $add_name = '添加区域';
            $city_name = '区域名称';
            $level_note = 'area';
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'city_name' => $city_name,
            'add_name'  => $add_name,
            'code'      => $code,
            'level_note' => $level_note,
            'name'      => $city_level['name'],
        ]);
    }
    /**
     *
     * @修改城市显示状态
     **/
    public function actionShow_hidden()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post('data');
            $code = $data['code'];
            $display = $data['display'];
            $code_data = DtCitySeas::find()
                ->where(['code' => $code])
                ->select(['parent', 'level'])
                ->asArray()
                ->one();
            if ($data['type'] == 'tour') {//旅游
                if ($display == 1) {//显示
                    $parent_code = $code_data['parent'];
                    while (!empty($parent_code)) {
                        $info = DtCitySeas::find()
                            ->where(['code' => $parent_code])
                            ->select(['parent'])
                            ->asArray()
                            ->one();
                        Yii::$app->db->createCommand("UPDATE `dt_city_seas` SET `display`=1 WHERE `code`={$parent_code}")->execute();
                        $parent_code = $info['parent'];
                    }
                } else {//隐藏
                    $parent_code = $code_data['parent'];
                    for ($i = 0; $code_data['level'] > $i; $code_data['level']--) {//3
                        $code_info = DtCitySeas::find()
                            ->where(['parent' => $parent_code, 'display' => 1])
                            ->andWhere(['<>', 'code', $code])
                            ->select(['code'])
                            ->asArray()
                            ->all();
                        if (empty($code_info)) {//所有都已隐藏
                            Yii::$app->db->createCommand("UPDATE `dt_city_seas` SET `display`=0 WHERE `code`={$parent_code}")->execute();
                        }
                        $info = DtCitySeas::find()
                            ->where(['code' => $parent_code])
                            ->select(['parent'])
                            ->asArray()
                            ->one();
                        $parent_code = $info['parent'];
                    }
                }

            } else {//住宿
                if ($display == 1) {//显示
                    $parent_code = $code_data['parent'];
                    while (!empty($parent_code)) {
                        $info = DtCitySeas::find()
                            ->where(['code' => $parent_code])
                            ->select(['parent'])
                            ->asArray()
                            ->one();
                        Yii::$app->db->createCommand("UPDATE `dt_city_seas` SET `is_visiable`=1 WHERE `code`={$parent_code}")->execute();
                        $parent_code = $info['parent'];
                    }
                } else {//隐藏
                    $parent_code = $code_data['parent'];
                    for ($i = 0; $code_data['level'] > $i; $code_data['level']--) {//3
                        $code_info = DtCitySeas::find()
                            ->where(['parent' => $parent_code, 'is_visiable' => 1])
                            ->andWhere(['<>', 'code', $code])
                            ->select(['code'])
                            ->asArray()
                            ->all();
                        if (empty($code_info)) {//所有都已隐藏
                            Yii::$app->db->createCommand("UPDATE `dt_city_seas` SET `is_visiable`=0 WHERE `code`={$parent_code}")->execute();
                        }
                        $info = DtCitySeas::find()
                            ->where(['code' => $parent_code])
                            ->select(['parent'])
                            ->asArray()
                            ->one();
                        $parent_code = $info['parent'];
                    }
                }
            }
            if ($data['type'] == 'tour') {
                $sql = "UPDATE `dt_city_seas` SET `display`={$display} WHERE `code`={$code}";
            } else {
                $sql = "UPDATE `dt_city_seas` SET `is_visiable`={$display} WHERE `code`={$code}";
            }
            Yii::$app->db->createCommand($sql)->execute();
            echo $display;
        }
    }
    /**
     *
     * @ajax 区域添加
     **/
    public function actionArea_add()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post('data');
            $info = DtCitySeas::find()
                ->where(['name' => $data['area_name']])
                ->select(['code'])
                ->asArray()
                ->all();
//            if (!empty($info)) {
//                echo json_encode('该地区已存在');
//                die;
//            }
            Yii::$app->redis->del('city_new_name');
            if ($data['level_note'] == 'country') {//添加国家
                $status = self::actionAdd_country($data['area_name'], $data['time_area']);
            } else if ($data['level_note'] == 'province') {//添加省份
                self::actionAdd_province($data['code'], $data['area_name'], 'china', $data['time_area']);
                $status = 'success';
            } else if ($data['level_note'] == 'city') {//添加城市
                if (strlen($data['code']) < 6) {//国家-国外
                    $code_type = 'abroad';
                } else {
                    $code_type = 'china';
                }
                $status = self::actionAdd_city($data['code'], $data['area_name'], $code_type, $data['time_area']);
            } else if ($data['level_note'] == 'area') {
                $status = self::actionAdd_area($data['code'], $data['area_name'], $data['time_area']);
            }
            $status = 'success';
            echo json_encode($status);
        }
    }
    /**
     *
     * @添加国家 - static
     **/
    public static function actionAdd_country($area_name, $time_area)
    {
        $country_info = DtCitySeas::find()
            ->where(['level' => 0])
            ->orderBy('code DESC')
            ->select(['code'])
            ->asArray()
            ->all();
        $country_code = $country_info[0]['code'] + 100;
        $pinyin = PinYin::utf8_to($area_name);//拼音
        $Initials = PinYin::utf8_to($area_name, 1);//首字母
        $sql_data = [
            'code'   => $country_code,//code码
            'name'   => $area_name,//城市名
            'parent' => 0,//父级code
            'level'  => 0,//等级
            'pinyin' => $pinyin,//拼音
            'abbre'  => $Initials,//首字母
            'first_letter' => substr($pinyin, 0, 1),//第一个字母
            'seas'   => 1,//国外
            'country_name' => $area_name,//国家名
            'time_zone'    => $time_area,//时区
        ];
        Yii::$app->db->createCommand()->insert('dt_city_seas', $sql_data)->execute();
        return 'success';
    }
    /**
     *
     * @添加省份 - static
     **/
    public static function actionAdd_province($code, $area_name, $country_type, $time_area)
    {
        $country_info = DtCitySeas::find()
            ->where(['parent' => $code])
            ->orderBy('code DESC')
            ->select(['code'])
            ->asArray()
            ->all();
        if (empty($country_info)) {
            //$country_code = $code * 1000 + 100;
            $country_code = $code * 1000 + 100;
        } else {
            //$country_code = $country_info[0]['code'] + 100;
            $country_code = $country_info[0]['code'] + 100000;
        }
        //校验区域编码是否存在
        $country_code = self::checkCode($country_code);
        $pinyin = PinYin::utf8_to($area_name);//拼音
        $Initials = PinYin::utf8_to($area_name, 1);//首字母
        $sql_data = [
            'code'   => $country_code,//code码
            'name'   => $area_name,//城市名
            'parent' => $code,//父级code
            'level'  => 1,//等级
            'pinyin' => $pinyin,//拼音
            'abbre'  => $Initials,//首字母
            'country' => $code,//国家code
            'first_letter' => substr($pinyin, 0, 1),//第一个字母
            'seas'   => 0,//国内
            'time_zone'    => $time_area,//时区
        ];
        if ($country_type != 'china') {
            $sql_data['seas'] = 1;//国外
        }
        $country_name = DtCitySeas::find()
            ->where(['code' => $code])
            ->select(['name'])
            ->asArray()
            ->one();
        $sql_data['country_name'] = $country_name['name'];//国家名
        Yii::$app->db->createCommand()->insert('dt_city_seas', $sql_data)->execute();
        return $country_code;//新的省code
    }
    /**
     *
     * @添加城市 - static
     **/
    public static function actionAdd_city($code, $area_name, $city_type, $time_area)
    {
        if ($city_type == 'abroad') {//国家-国外
            $code = self::actionAdd_province($code, $area_name, 'abroad', $time_area);//覆盖为省份code
        }
        $city_info = DtCitySeas::find()
            ->where(['parent' => $code])
            ->orderBy('code DESC')
            ->select(['code'])
            ->asArray()
            ->all();
        if (empty($city_info)) {
            //$city_code = $code * 10 + 100;
            $city_code = $code + 100;
        } else {
            $city_code = $city_info[0]['code'] + 100;
        }
        //校验区域编码是否存在
        $city_code = self::checkCode($city_code);
        $pinyin = PinYin::utf8_to($area_name);//拼音
        $Initials = PinYin::utf8_to($area_name, 1);//首字母
        $sql_data = [
            'code'   => $city_code,//code码
            'name'   => $area_name,//城市名
            'parent' => $code,//父级code
            'level'  => 2,//等级
            'pinyin' => $pinyin,//拼音
            'abbre'  => $Initials,//首字母
            'first_letter' => substr($pinyin, 0, 1),//第一个字母
            'seas'   => 1,//国外
            'time_zone'    => $time_area,//时区
        ];
        if ($city_type != 'abroad') {
            $sql_data['seas'] = 0;//国内
        }
        $country_name = DtCitySeas::find()
            ->where(['code' => $code])
            ->select(['country_name', 'country'])
            ->asArray()
            ->one();
        $sql_data['country_name'] = $country_name['country_name'];//国家名
        $sql_data['country'] = $country_name['country'];
        Yii::$app->db->createCommand()->insert('dt_city_seas', $sql_data)->execute();
        return 'success';
    }

    /**
     * @添加区 - static
     **/
    public static function actionAdd_area($code, $area_name, $time_area)
    {
        $area_info = DtCitySeas::find()
            ->where(['parent' => $code])
            ->orderBy('code DESC')
            ->select(['code'])
            ->asArray()
            ->all();
        if (empty($area_info)) {
            $area_code = $code + 1;
        } else {
            $area_code = $area_info[0]['code'] + 1;
        }
        $pinyin = PinYin::utf8_to($area_name);//拼音
        $Initials = PinYin::utf8_to($area_name, 1);//首字母
        $sql_data = [
            'code'   => $area_code,//code码
            'name'   => $area_name,//城市名
            'parent' => $code,//父级code
            'level'  => 3,//等级
            'pinyin' => $pinyin,//拼音
            'abbre'  => $Initials,//首字母
            'first_letter' => substr($pinyin, 0, 1),//第一个字母
            'seas'   => 1,//国外
            'time_zone'    => $time_area,//时区
        ];
        $country_name = DtCitySeas::find()
            ->where(['code' => $code])
            ->select(['country_name', 'seas', 'country'])
            ->asArray()
            ->one();
        if ($country_name['seas'] === '0') {
            $sql_data['seas'] = 0;//国内
        }
        $sql_data['country_name'] = $country_name['country_name'];//国家名
        $sql_data['country'] = $country_name['country'];
        Yii::$app->db->createCommand()->insert('dt_city_seas', $sql_data)->execute();
        return 'success';
    }

    /**
     * 校验code码是否存在
     * @param $code
     */
    public static function checkCode($code){
        $info = Yii::$app->db->createCommand("SELECT * FROM dt_city_seas WHERE code = :code")
            ->bindValue(":code",$code)
            ->queryAll();
        //如果数据库中已经存在此code值，则重新生成code值
        if($info){
            $code = $code + 900;   //延迟出现重复的频率
            self::checkCode($code);
        }
        return $code;
    }
}
