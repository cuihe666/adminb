<?php
/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/7/18
 * Time: 下午2:38
 */
return [
//    商品状态0=>待申请上架,10=>审核中,11=>拒绝，12=>待上架,20=>在售中,30=>仓库中(已下架),40=>‘锁定’
    //商品状态列表
    "goods_status_list" => [
        "0" => '待申请上架',
        '10' => '审核中',
        '11' => '拒绝',
        '12' => '待上架',
        '20' => '在售中',
        '30' => '仓库中',
        '40' => '锁定'
    ],
    //品牌列表
    "brand_list" => array (
        0 =>
            array (
                'label' => '迪士尼',
                'value' => '迪士尼',
            ),
        1 =>
            array (
                'label' => 'KingSton/金士顿',
                'value' => 'KingSton/金士顿',
            ),
        2 =>
            array (
                'label' => ' HP/惠普 ',
                'value' => ' HP/惠普 ',
            ),
        3 =>
            array (
                'label' => 'PNY/必恩威',
                'value' => 'PNY/必恩威',
            ),
        4 =>
            array (
                'label' => '茶花',
                'value' => '茶花',
            ),
        5 =>
            array (
                'label' => '虎牌/tiger',
                'value' => '虎牌/tiger',
            ),
        6 =>
            array (
                'label' => '科沃斯（Ecovacs）',
                'value' => '科沃斯（Ecovacs）',
            ),
        7 =>
            array (
                'label' => '飞利浦（PHILIPS）',
                'value' => '飞利浦（PHILIPS）',
            ),
        8 =>
            array (
                'label' => '美的（Midea）',
                'value' => '美的（Midea）',
            ),
        9 =>
            array (
                'label' => '小米（MI）',
                'value' => '小米（MI）',
            ),
        10 =>
            array (
                'label' => '小狗（puppy）',
                'value' => '小狗（puppy）',
            ),
        11 =>
            array (
                'label' => '戴森（DYSON）',
                'value' => '戴森（DYSON）',
            ),
        12 =>
            array (
                'label' => '烽火狼',
                'value' => '烽火狼',
            ),
        13 =>
            array (
                'label' => '菲尼克斯Fenix',
                'value' => '菲尼克斯Fenix',
            ),
        14 =>
            array (
                'label' => '冠云',
                'value' => '冠云',
            ),
        15 =>
            array (
                'label' => '塔通卡（TATONKA）',
                'value' => '塔通卡（TATONKA）',
            ),
        16 =>
            array (
                'label' => '德美果',
                'value' => '德美果',
            ),
        17 =>
            array (
                'label' => '田野',
                'value' => '田野',
            ),
        18 =>
            array (
                'label' => 'uini',
                'value' => 'uini',
            ),
        19 =>
            array (
                'label' => '优斯漫',
                'value' => '优斯漫',
            ),
        20 =>
            array (
                'label' => '花色',
                'value' => '花色',
            ),
        21 =>
            array (
                'label' => '多彩',
                'value' => '多彩',
            ),
        22 =>
            array (
                'label' => '暖爸爸',
                'value' => '暖爸爸',
            ),
    ),
    //产地列表
    'local_list' => array (
        0 =>
            array (
                'label' => '杭州',
                'value' => '杭州',
            ),
        1 =>
            array (
                'label' => '苏州',
                'value' => '苏州',
            ),
        2 =>
            array (
                'label' => '丽江',
                'value' => '丽江',
            ),
        3 =>
            array (
                'label' => '西双版纳',
                'value' => '西双版纳',
            ),
        4 =>
            array (
                'label' => '焦作',
                'value' => '焦作',
            ),
        5 =>
            array (
                'label' => '静宁',
                'value' => '静宁',
            ),
        6 =>
            array (
                'label' => '平凉',
                'value' => '平凉',
            ),
        7 =>
            array (
                'label' => '哈尔滨',
                'value' => '哈尔滨',
            ),
        8 =>
            array (
                'label' => '宁夏',
                'value' => '宁夏',
            ),
        9 =>
            array (
                'label' => '贺兰山',
                'value' => '贺兰山',
            ),
        10 =>
            array (
                'label' => '景德镇',
                'value' => '景德镇',
            ),
        11 =>
            array (
                'label' => '西安',
                'value' => '西安',
            ),
        12 =>
            array (
                'label' => '平遥',
                'value' => '平遥',
            ),
        13 =>
            array (
                'label' => '厦门',
                'value' => '厦门',
            ),
        14 =>
            array (
                'label' => '广州',
                'value' => '广州',
            ),
        15 =>
            array (
                'label' => '北京',
                'value' => '北京',
            ),
        16 =>
            array (
                'label' => '昆明',
                'value' => '昆明',
            ),
        17 =>
            array (
                'label' => '遵义',
                'value' => '遵义',
            ),
        18 =>
            array (
                'label' => '贵阳',
                'value' => '贵阳',
            ),
        19 =>
            array (
                'label' => '怀仁',
                'value' => '怀仁',
            ),
        20 =>
            array (
                'label' => '北海',
                'value' => '北海',
            ),
        21 =>
            array (
                'label' => '桂林',
                'value' => '桂林',
            ),
        22 =>
            array (
                'label' => '南宁',
                'value' => '南宁',
            ),
        23 =>
            array (
                'label' => '海口',
                'value' => '海口',
            ),
        24 =>
            array (
                'label' => '三亚',
                'value' => '三亚',
            ),
        25 =>
            array (
                'label' => '潮州',
                'value' => '潮州',
            ),
        26 =>
            array (
                'label' => '珠海',
                'value' => '珠海',
            ),
        27 =>
            array (
                'label' => '长沙',
                'value' => '长沙',
            ),
    ),
    //交易关闭原因
    'closure_reason' => array (
        0 =>
            array (
                'label' => '取消交易原因',
                'value' => '取消交易原因',
            ),
        1 =>
            array (
                'label' => '没有货了，交易无法完成',
                'value' => '没有货了，交易无法完成',
            ),
        2 =>
            array (
                'label' => '长时间联系不到买家，交易不成功',
                'value' => '长时间联系不到买家，交易不成功',
            ),
        3 =>
            array (
                'label' => '买家购买意向不明确，取消交易',
                'value' => '买家购买意向不明确，取消交易',
            ),
        4 =>
            array (
                'label' => '买家已经通过其他方式付款',
                'value' => '买家已经通过其他方式付款',
            ),
        5 =>
            array (
                'label' => '买家不想购买了',
                'value' => '买家不想购买了',
            ),
        6 =>
            array (
                'label' => '其他理由',
                'value' => '其他理由',
            ),
    ),
    //拒绝退款原因
    'refuse_refund' => array (
        0 =>
            array (
                'label' => '拒绝退款原因',
                'value' => '拒绝退款原因',
            ),
        1 =>
            array (
                'label' => '订单已发货',
                'value' => '订单已发货',
            ),
        2 =>
            array (
                'label' => '非七天无理由退换货产品',
                'value' => '非七天无理由退换货产品',
            ),
        3 =>
            array (
                'label' => '退款理由不明确',
                'value' => '退款理由不明确',
            ),
        4 =>
            array (
                'label' => '食品已开包装且无质量问题',
                'value' => '食品已开包装且无质量问题',
            ),
        5 =>
            array (
                'label' => '商品为人为损坏',
                'value' => '商品为人为损坏',
            ),
        6 =>
            array (
                'label' => '其他原因',
                'value' => '其他原因',
            ),
    ),
    //银行列表
    'bank_list' => array (
        0 =>
            array (
                'label' => '工商银行',
                'value' => '工商银行',
            ),
        1 =>
            array (
                'label' => '农业银行',
                'value' => '农业银行',
            ),
        2 =>
            array (
                'label' => '中国银行',
                'value' => '中国银行',
            ),
        3 =>
            array (
                'label' => '建设银行',
                'value' => '建设银行',
            ),
        4 =>
            array (
                'label' => '交通银行',
                'value' => '交通银行',
            ),
        5 =>
            array (
                'label' => '华夏银行',
                'value' => '华夏银行',
            ),
        6 =>
            array (
                'label' => '光大银行',
                'value' => '光大银行',
            ),
        7 =>
            array (
                'label' => '招商银行',
                'value' => '招商银行',
            ),
        8 =>
            array (
                'label' => '中信银行',
                'value' => '中信银行',
            ),
        9 =>
            array (
                'label' => '兴业银行',
                'value' => '兴业银行',
            ),
        10 =>
            array (
                'label' => '民生银行',
                'value' => '民生银行',
            ),
        11 =>
            array (
                'label' => '深圳发展银行',
                'value' => '深圳发展银行',
            ),
        12 =>
            array (
                'label' => '广东发展银行',
                'value' => '广东发展银行',
            ),
        13 =>
            array (
                'label' => '上海浦东发展银行',
                'value' => '上海浦东发展银行',
            ),
        14 =>
            array (
                'label' => '恒丰银行',
                'value' => '恒丰银行',
            ),
        15 =>
            array (
                'label' => '邮政储蓄银行',
                'value' => '邮政储蓄银行',
            ),
        16 =>
            array (
                'label' => '北京商业银行',
                'value' => '北京商业银行',
            ),
        17 =>
            array (
                'label' => '上海银行',
                'value' => '上海银行',
            ),
        18 =>
            array (
                'label' => '济南商业银行',
                'value' => '济南商业银行',
            ),
    ),
    //物流公司列表
    'logistics_list' => array (
        0 =>
            array (
                'label' => '快递公司',
                'value' => '快递公司',
            ),
        1 =>
            array (
                'label' => '顺丰速运',
                'value' => '顺丰速运',
            ),
        2 =>
            array (
                'label' => '申通快递',
                'value' => '申通快递',
            ),
        3 =>
            array (
                'label' => '圆通速递',
                'value' => '圆通速递',
            ),
        4 =>
            array (
                'label' => '中通快递',
                'value' => '中通快递',
            ),
        5 =>
            array (
                'label' => '韵达快递',
                'value' => '韵达快递',
            ),
        6 =>
            array (
                'label' => '宅急送',
                'value' => '宅急送',
            ),
        7 =>
            array (
                'label' => 'EMS',
                'value' => 'EMS',
            ),
        8 =>
            array (
                'label' => '天天快递',
                'value' => '天天快递',
            ),
        9 =>
            array (
                'label' => '百世快递',
                'value' => '百世快递',
            ),
        10 =>
            array (
                'label' => '优速物流',
                'value' => '优速物流',
            ),
        11 =>
            array (
                'label' => '安能快递',
                'value' => '安能快递',
            ),
        12 =>
            array (
                'label' => '中国邮政',
                'value' => '中国邮政',
            ),
        13 =>
            array (
                'label' => '全峰快递',
                'value' => '全峰快递',
            ),
        14 =>
            array (
                'label' => '国通快递',
                'value' => '国通快递',
            ),
    ),

];