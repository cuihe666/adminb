<?php

namespace backend\controllers;

use backend\models\SearchSql;
use yii\web\Controller;

/**
 * AgentSettlementController implements the CRUD actions for AgentSettlement model.
 */
class AgentPersonHandleController extends Controller
{
    public function actionHandle()
    {
        $settle_sql = "SELECT `id` FROM `agent_user` WHERE `create_time`=111111";
        $settle_data = SearchSql::_SearchAllData($settle_sql);
        if (empty($settle_data)) {
            return 'settlement_info_null';
        }
        $settle_info = [];
        foreach ($settle_data as $key => $val) {
            $settle_info[] = $val;
        }
        $settle_str = implode(',', $settle_info);
        $detail_sql = "SELECT `order_id` FROM `agent_settle_detail` WHERE `settle_id` IN ('.$settle_str.')";
        $detail_data = SearchSql::_SearchAllData($detail_sql);
        $order_str = implode(',', $detail_data);
        echo $order_str;die;
    }
}
