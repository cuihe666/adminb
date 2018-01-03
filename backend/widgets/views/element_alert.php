<?php
/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/5/4
 * Time: 下午6:29
 */
\backend\assets\VueAsset::register($this);
$unique_id = uniqid();
$alert_msg = Yii::$app->session->getFlash('c_message',null);



$alert_msg = $alert_msg ? json_encode($alert_msg) : '{}';

?>



<div id="el_<?= $unique_id ?>"></div>


<script>

    vm_<?= $unique_id ?> = new Vue({
        el: '#el_<?= $unique_id ?>',
        data: {
            alert_body: <?= $alert_msg ?>
        },
        methods:{
            notifyAlert: function(title,message,type){
                this.$notify({
                    title: title,
                    message: message,
                    type: type
                });
            },
            msgAlert: function(content,title){
                this.$alert(content,title,{
                    closeOnPressEscape: true
                })
            }

        },
        mounted: function(){
//            this.notifyAlert('title','message','success');
//            this.msgAlert('error messge','提示');
            if(this.alert_body.message){
                switch(this.alert_body.method){
                    case 'alert':
                        this.msgAlert(this.alert_body.message,this.alert_body.type);
                        break;
                    case 'notify':
                        this.notifyAlert(this.alert_body.title,this.alert_body.message,this.alert_body.type);
                }
            }


        }
    });


</script>