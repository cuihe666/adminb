<?php

namespace backend\models;

use backend\service\CommonService;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Qrcode;

/**
 * @author fuyanfei
 * @time   2017-3-25 13:23:43
 * @desc   qrcode表模型
 *
 * QrcodeQuery represents the model behind the search form about `backend\models\Qrcode`.
 */
class QrcodeQuery extends Qrcode
{
    public $stime;
    public $activeTheme;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['theme_id', 'city_code','qrcode_url', 'scan_num', 'create_time', 'create_adminid','text','activeTheme','stime'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Qrcode::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        if ($this->stime != '') {

            $start = substr($this->stime, 0, 10) . ' 00:00:00';
            $end = substr($this->stime, 13) . ' 23:59:59';
            $query->andWhere(['between', 'create_time', strtotime($start), strtotime($end)]);
        }


        if ($this->theme_id !="" && intval($this->theme_id)!=0) {
            $query->andWhere([
                'theme_id' => $this->theme_id,
            ]);
        }
        if ($this->city_code !="") {
            $query->andWhere([
                'city_code' => $this->city_code,
            ]);
        }
        $query->orderBy('qrcode_id DESC');

        return $dataProvider;
    }
}
