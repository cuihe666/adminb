<?php

namespace backend\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "shop_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $des
 * @property integer $pid
 * @property string $create_time
 */
class ShopCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid'], 'required'],
            [['pid'], 'integer'],
            ['title', 'required', 'message' => '分类标题不能为空'],
            ['rate', 'integer', 'message' => '费率必须为整数'],
            ['rate', 'required', 'message' => '费率不能为空'],

            [['create_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => '标题名称',
            'pid' => '上级分类',
            'rate' => '费率'
        ];
    }



    public function getData()
    {
        $cates = self::find()->all();
        $cates = ArrayHelper::toArray($cates);
        return $cates;
    }

    public function getTree($cates, $pid = 0)
    {
        $tree = [];
        foreach ($cates as $cate) {
            if ($cate['pid'] == $pid) {
                $tree[] = $cate;
                $tree = array_merge($tree, $this->getTree($cates, $cate['id']));
            }
        }

        return $tree;
    }

    public function setPrefix($data, $p = "|-----")
    {
        $tree = [];
        $num = 1;
        $prefix = [0 => 1];
        while ($val = current($data)) {
            $key = key($data);
            if ($key > 0) {
                if ($data[$key - 1]['pid'] != $val['pid']) {
                    $num++;
                }
            }
            if (array_key_exists($val['pid'], $prefix)) {
                $num = $prefix[$val['pid']];
            }
            $val['title'] = str_repeat($p, $num) . $val['title'];
            $prefix[$val['pid']] = $num;
            $tree[] = $val;
            next($data);
        }
        return $tree;
    }

    public function getOptions()
    {
        $data = $this->getData();
        $tree = $this->getTree($data);
        $tree = $this->setPrefix($tree);

        $options = ['添加顶级分类'];
        foreach ($tree as $cate) {
            $options[$cate['id']] = $cate['title'];
        }

        return $options;
    }

    public function getTreeList()
    {
        $data = $this->getData();
        $tree = $this->getTree($data);
        return $tree = $this->setPrefix($tree);
    }
}
