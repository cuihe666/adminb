<?php
/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/4/19
 * Time: 下午1:29
 */

namespace backend\traits;


use backend\models\Hotel;
use backend\models\HotelOrder;
use backend\models\HotelOrderDatePrice;
use backend\models\HotelOrderQuery;
use backend\models\HotelSupplier;
use backend\models\HotelSupplierSettlement;
use common\tools\Helper;
use phpDocumentor\Reflection\Types\String_;
use yii\data\ActiveDataProvider;
use yii\web\Response;

trait SupplierTrait
{

    /**
     * 获取总账单(周期内已结算的账单)
     * 如果 mysql 中有记录则直接取出,如果没有则进行统计计算并存储
     * @param HotelSupplier $supplier       供应商模型
     * @param null $type                    结算类型,已结算/未结算
     * @param null $period                  结算周期,周结/月结
     * @return array|static
     */
    public function STGetTotalBill(HotelSupplier $supplier,$type=null,$period=null){
        $condition =  $this->STBuildCondition($type,$period);

        $res = $this->STGetSettlement($supplier,$condition);
        if(is_null($res)){
            $res = $this->dynamicCompute($supplier,'done',$period);
            $res = $this->STSaveSettlement($supplier,$res,$condition);
        }

        return $res;
    }

    //向库中取出结算金额
    protected function STGetSettlement(HotelSupplier $supplier,$condition){
        return  HotelSupplierSettlement::findOne([
            'supplier_id' => $supplier->id,
            'start_time' => $condition[0],
            'end_time' => $condition[1]
        ]);
    }
    //向库中存入结算金额
    protected function STSaveSettlement(HotelSupplier $supplier,$data,$condition){
        $data = [
            'supplier_id' => $supplier->id,
            'start_time' => $condition[0],
            'end_time' => $condition[1],
            'hotel_income' => $data['hotel_income'],
            'status' => 0
        ];

        $model = new HotelSupplierSettlement();
        Helper::loadModel($model,$data);

        if($model->validate()){
            $model->save();
            $this->alertMsg('success','已生成结算日志');
        }else{
            $error = current($model->getErrors());
            $this->alertMsg('error',implode(':',$error));
        }
        return $model;
    }

    //
    /**
     * 动态计算供应商的 总卖价,总佣金,供应商结算总价,总间夜
     * @param string $type   结算类型:已出账单(done) 未出账单(wait)
     * @param string $period 结算周期:周结(week) 月结(month)
     *
     * @return array
     */
    public function dynamicCompute(HotelSupplier $supplier,$type=null,$period=null,HotelOrderQuery $searchQuery=null){


        //如果存在筛选条件(用于供应商查看列表时的筛选),如果没有条件的话是用于 "已结算"和"未结算"的统计信息
        if(!is_null($searchQuery)  && $searchQuery->validate()){
            //如果出现订单查询的情况则直接返回空值不再进行下一步操作
            if($searchQuery->order_num){
                return  [
                    'hotel_income' => '--',
                    'tango_income' => '--',
                    'pay_total' => '--',
                    'order_ids' => [],
                    'order_count' => '--'
                ];
            }
            $hotels = $supplier->getHotels();
            $hotels->andFilterWhere(['id' => $searchQuery->hotel_id]);

            if($searchQuery->start_end){
                $condition = explode('-',$searchQuery->start_end);
                $condition[0] = $condition[0] . ' 00:00:00';
                $condition[1] = $condition[1] . ' 23:59:59';
            }else{
                $condition = $this->STBuildCondition($type,$period);
            }

        }else{
            $hotels = $supplier->getHotels();
            $condition = $this->STBuildCondition($type,$period);
        }


        //获取相关的酒店 id
        $hotels = $hotels->asArray()->all();
        $hotel_ids = array_map(function($item){
            return $item['id'];
        },$hotels);


        //根据酒店 id 查询酒店以下的订单情况,按时间区分
        $orders = HotelOrder::find()
            ->where([
                'hotel_id' => $hotel_ids,
                'status' => [14,15],
            ])
            ->andWhere(['between','out_time',$condition[0],$condition[1]])
            ->select(['id','hotel_income','tango_income','pay_total','out_time'])
            ->all();

        $res = $this->STCountAll($orders);

        //获取订单的总间夜
        $count = HotelOrderDatePrice::find()->where(['oid' => $res['order_ids']])->count();
        $res['order_count'] = $count;


        return $res;
    }


    /**
     * 仅该 trait 中使用的组成条件的方法
     * @param null $type        结算类型 done/wait
     * @param null $period      结算周期 week/month
     * @return array|bool
     */
    protected function STBuildCondition($type=null,$period=null){
        $type = $type ? : \Yii::$app->request->get('type');
        $period = $period ? : \Yii::$app->request->get('period');

        $param = $type . '_' . $period;
        $condition = $this->STSelectType($param);

        if(!$condition){
            $this->alertMsg('error','当月的第一天和当周的第一天结算内容仅作参考');
            $today = date('Y-m-d');
            return [
                $today . ' 00:00:00',
                $today . ' 23:59:59'
            ];
        }

        return $condition;
    }

    /**
     * 根据条件组合筛选出需要的时间段
     * 默认显示  yyyy-mm-dd HH:ii:ss 格式,如果不需要显示时间则 $hours = true
     * @param string $param         组合好的信息
     * @param null $hours    是否显示时分秒
     * @return array|bool
     */
    protected function STSelectType($param,$hours=null){
        switch ($param){
            case 'done_week':
                //周结已结算
                $condition = Helper::lastWeek($hours);
                break;
            case 'done_month':
                //月结已结算
                $condition = Helper::lastMonth($hours);
                break;
            case 'wait_week':
                //周结未结算
                $condition = Helper::thisWeek($hours);
                break;
            case 'wait_month':
                //月结未结算
                $condition = Helper::thisMonth($hours);
                break;
            default:
                $condition = false;

        }

        return $condition;
    }


    /**
     * 将供应商的财务信息统计起来
     * @param $data         由 activeRecord 生成的数组
     * @return array
     */
    protected function STCountAll($data){
        $res = [
            'hotel_income' => 0,
            'tango_income' => 0,
            'pay_total' => 0,
            'order_ids' => []
        ];
        foreach($data as $item){
            $res['hotel_income'] += $item['hotel_income'];
            $res['tango_income'] += $item['tango_income'];
            $res['pay_total'] += $item['pay_total'];
            $res['order_ids'][] = $item['id'];
        }

        return $res;
    }



}