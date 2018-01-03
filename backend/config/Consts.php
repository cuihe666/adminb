<?php
namespace backend\config;

/**
 * 常量定义类
 *
 * @author hongcq
 *
 */
class Consts
{

    //图片前缀地址
    const DOMAIN_FACE = 'http://img.tgljweb.com/';
    const QINIU_ACCESS_KEY = '7Mz8kyvhYyyehoz1PLC93xRQtUpR5C9RTSGMG6L0';
    const QINIU_SECRET_KEY = 'XbRaXfaFk-fokfn7yKzth5_8w-DIZWWy8Ir2OOzx';
    //253短信平台
    const USER_GUONEI='N5879106';
    const PWD_GUONEI='UnLQ0ykXSua0b0';
    const USER_GUOWAI='I1708198';
    const PWD_GUOWAI='Lk18BwNmpTbd2f';
    //支付宝
    const ALIPAY_PRIVATE_KEY='MIICXgIBAAKBgQD+gPUg/+mZstwoR17UKoQA38avNE4olsFvh1FpxaD04/7ZE9qj
X2Ul/Lct3/Chr/CsQXuwueHV52alkTL+5Xv0uYb7C4ZtFk/DhUFy1+fNot0Bb8qM
npjhqJyF6R8KNbhMx50s0Ps1NoadAwL4bJrmaPZTcpBqtifMsyewbBdM+QIDAQAB
AoGBANAy1NV7JTHMRRhaUnREl5pTdiksI+hGc9X2IB7kQqkzvu78s/bEem2aEIxh
z2umD8ALDdHkLqCbXbiCUPJ+72gBod2AeAR35adtQXb+hlppl2zWLKMamF62ZGCt
IGSB9nSzm7qIgfYB4fVoNJt2rkr3qvsJ4Hy1Pqd0IaqIAWmBAkEA/6iDRkc/3oPo
jhrMytD4k2cLMluB//6TKp+Nez3zRMNrVnb+7g9svZYT0MPx4rfd5iVQUBI56eMr
+SYbp8PU8QJBAP7YDLbaQhSF6P/dpJ+bcpO7lpvlAW03xN/GL902QLc2j9P6rvZH
+IdDv28stKHgnmlbSrAuwGbBZO0OAdaP2IkCQQCIj7vni2GLe4x6c8hWwf81xYIO
mSC83IBB8U5CuZm7bmNkoVWVVjnwnzzgc/o975chO2dGDiZPT+CKSpfVKl8RAkEA
3Q1soeNaNFEflWmdVXDSBwFNl7Yh8anRVMWlWP2pTwK96YLl5uzwz+vdDsM5f7zF
y9+LPp2e+MLCF7nxsDqf+QJAD8Fo8IsMJXHtY8SU1wyu88jhaukuHRQGvFCeymLV
w3RkVKWPd6uaUVzrN7DIlOYAXAwguU3skfRdHE5b+Dbnpw==';
    const ALIPAY_PUBLIC_KEY='MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDI6d306Q8fIfCOaTXyiUeJHkrIvYISRcc73s3vF1ZT7XN8RNPwJxo8pWaJMmvyTn9N4HQ632qJBVHf8sxHi/fEsraprwCtzvzQETrNRwVxLO5jVmRGi60j8Ue1efIlzPXV9je9mkjzOmdssymZkh2QhUrCmZYI/FCEa3/cNMW0QIDAQAB';
    const ORDER_CANCEL='【棠果旅居】%s经房东确认%s至%s入住%s晚已无房，您可选择其他民宿或其他日期入住。棠果客服：4006-406-111。';
    const ORDER_CONFIRM='【棠果旅居】%s房东已经确认%s至%s入住%s晚可入住，请于30分钟内完成支付，以便房东保留房间。棠果客服：4006-406-111。';
    const HOTEL_CONFIRM_CODE = '【棠果旅居】您提交%s%s至%s入住%s晚的预订已成功，酒店地址：%s，T：%s。棠果客服：4006-406-111。';//确认短信提醒
    const HOTEL_DENY_CODE = '【棠果旅居】%s经酒店确认%s至%s入住%s晚已无房，您可选择其他酒店或其他日期入住。棠果客服：4006-406-111。';//拒单短信提醒

}
