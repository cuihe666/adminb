
var id=GetRequest("id").id||8;
var type=window.localStorage.getItem("types")||1;
$(".tite").html("首页明星达人");
//获取达人列表
$(".loading").css("display","none");
function getStarList(){
    $(".loading").css("display","block");
    var param= {
        id:id
    }
    $.ajax({
        type: "POST",
        contentType:"application/json;charset=UTF-8",
        url:http_url + "/api/operate/editBannerById",
        data:JSON.stringify(param),
        success: function(data){
            if(data.code==0){
                $(".loading").css("display","none");
                $(".star_con").html("");
                if(data.code==0){
                    var starList=data.data;
                    for(var i=0;i<starList.length;i++){
                        $(".star_con").append(
                            "<tr>"+
                            "<td class='id'>"+(i+1)+"</td>"+
                            " <td>"+starList[i].masterId+"</td>"+
                            "<td><img alt='达人' src=http://img.tgljweb.com/"+(starList[i].pic?(starList[i].pic+"?imageView2/1/w/150/h/100"):"")+"></td>"+
                            " <td>"+starList[i].sort+"</td>"+
                            "<td>"+((starList[i].enabled==1)?'已使用':'禁用')+"</td>"+
                            "<td>"+getDateDiff(starList[i].updateTime)+"</td>"+
                            "<td>" + starList[i].userName + "</td>"+
                            "<td class='edit_star'><a class='changeState' onclick='changeState("+i+","+starList[i].enabled+")'>"+((starList[i].enabled==1)?'禁用':'使用')+"</a><a onclick='editStar("+i+")'>编辑</a><a onclick='delStar("+i+")'>删除</a></td>"+
                            "</tr>");
                    }
                }
            }else{
                layer.alert("加载数据失败");
                return false;
            }

        }
    })
}
getStarList();


//禁用、使用
function changeState(curIndex,curStatus){
    var enablesTest;
    if(curStatus){
        enablesTest="禁用"
    }else{
        enablesTest="使用"
    }
    $.beamDialog({
        title:'',
        content:'确定'+enablesTest+'该条数据吗?',
        showCloseButton:false,
        otherButtons:["确定","取消"],
        otherButtonStyles:['btn-primary yes','btn-primary no'],
        bsModalOption:{keyboard: true},
        clickButton:function(sender,modal,index){
           // console.log('选中第'+index+'个按钮：'+sender.html());
            if(index==0){
                tochangeState(curIndex);
               // tochangeState(897346550768861184,curStatus);
            }else if(index==1){
                //console.log("点击了取消按钮");
            }
            $(this).closeDialog(modal);
        }
    });
}
function tochangeState(curIndex){
    $.ajax({
        type: "POST",
        contentType: "application/json;charset=UTF-8",
        url: http_url + "/api/operate/editBannerById",
        data: JSON.stringify({id:id}),
        success: function (data) {
           if(data.code==0){
               var curStarList=data.data;
               var curStarId=curStarList[curIndex].id;
               var curStatus=curStarList[curIndex].enabled;
               var enabled;
               if(curStatus==1){
                   enabled=0
               }else{
                   enabled=1
               }
               var param={
                   id:curStarId,
                   enabled:parseInt(enabled)
               }
               $.ajax({
                   type: "POST",
                   contentType:"application/json;charset=UTF-8",
                   url:http_url + "/api/operate/disablebyid",
                   data:JSON.stringify(param),
                   success: function(data){
                       if(data.code==0){
                          getStarList();
                       }else{
                           if(curStatus==1){
                               layer.alert("禁用无效");
                               return false;
                           }else{
                               layer.alert("使用无效");
                               return false;
                           }

                       }

                   }
               })
           }

        }
    })
}

//删除达人
function delStar(curIndex){
    $.ajax({
        type: "POST",
        contentType: "application/json;charset=UTF-8",
        url: http_url + "/api/operate/editBannerById",
        data: JSON.stringify({id: id}),
        success: function (data) {
            if (data.code == 0) {
                var curStarConId = data.data[curIndex].id;
                var param={
                    id:curStarConId
                }

                $.beamDialog({
                    title:'',
                    content:'确定删除该条数据吗?',
                    showCloseButton:false,
                    otherButtons:["确定","取消"],
                    otherButtonStyles:['btn-primary yes','btn-primary no'],
                    bsModalOption:{keyboard: true},
                    clickButton:function(sender,modal,index){
                        // console.log('选中第'+index+'个按钮：'+sender.html());
                        if(index==0){
                            //console.log("点击了确认按钮");
                            $.ajax({
                                type: "POST",
                                contentType:"application/json;charset=UTF-8",
                                url:http_url + "/api/operate/deleteByid",
                                data:JSON.stringify(param),
                                success: function(data){
                                    if(data.code==0){
                                        getStarList();
                                    }else{
                                        layer.alert("删除无效");
                                        return false;
                                    }

                                }
                            })
                        }else if(index==1){
                           // console.log("点击了取消按钮");
                        }
                        $(this).closeDialog(modal);
                    }
                });


            }
        }
    })
}


//编辑达人

function editStar(curIndex){
    window.localStorage.removeItem("clickCurIndex")
    window.localStorage.setItem("clickCurIndex",curIndex)
    $(".add").css("display","none");
    $(".edit").css("display","inline-block");
    $(".modal-header").html("编辑");
    $.ajax({
        type: "POST",
        contentType: "application/json;charset=UTF-8",
        url: http_url + "/api/operate/editBannerById",
        data: JSON.stringify({id:id}),
        success: function (data) {
            if(data.code==0){
                var curStarCon=data.data[curIndex];
                var curImgurl=curStarCon.pic;
                var bannerId=curStarCon.id;
                $(".starId").val(curStarCon.masterId); //达人ID
                $(".pic_url").val("http://img.tgljweb.com/" + curImgurl); //图片
                $(".sort").val(curStarCon.sort); //排序

            }
        }
    })
    $('#myModal_add').modal('show');
}


function _editStar(){
    var curIndex=window.localStorage.getItem("clickCurIndex");
    $.ajax({
        type: "POST",
        contentType: "application/json;charset=UTF-8",
        url: http_url + "/api/operate/editBannerById",
        data: JSON.stringify({id:id}),
        success: function (data) {
            if(data.code==0){
                var curStarCon=data.data[curIndex];
                var bannerId=curStarCon.id;

                var  masterId=$(".starId").val(),
                    pic=$(".pic_url").val(),
                    sort=$(".sort").val();
                var errorMsg;
                if(!masterId){
                    errorMsg="请填写达人ID"
                }else if(!pic){
                    errorMsg="请上传图片"
                }else if(!sort){
                    errorMsg="请选择对应的位置"
                }
                if(errorMsg){
                    layer.alert(errorMsg);
                    return false;
                }else {
                    var param= {
                        masterId:masterId,
                        pic:pic.split("http://img.tgljweb.com/")[1].split("?")[0],
                        sort:sort,
                        id:bannerId,
                        type:type
                    }
                    param.createBy=adminId;
                    $.ajax({
                        type: "POST",
                        contentType:"application/json;charset=UTF-8",
                        url:http_url + "/api/operate/updateMasterStar",
                        data:JSON.stringify(param),
                        success: function(date){
                            if(data.code==0){
                                $('#myModal_add').modal('hide');
                                getStarList();
                            }
                        }
                    })

                }
            }
        }
    })

}

//新增达人

function addStar(){
    $(".modal-header").html("新增");
    $(".add").css("display","inline-block");
    $(".edit").css("display","none");

    $(".starId").val(""); //达人ID
    $(".pic_url").val("");  //图片
    $(".sort").val(""); //排序
    $('#myModal_add').modal('show');
    var param= {
        masterId:$(".starId").val(),
        pic:$(".pic_url").val().split("http://img.tgljweb.com/")[1].split("?")[0],
        sort:$(".sort").val(),
        itemId:id
    }
}

function _addStar(){
    var  masterId=$(".starId").val(),
         pic=$(".pic_url").val(),
         sort=$(".sort").val();
    var errorMsg;
    if(!masterId){
        errorMsg="请填写达人ID"
    }else if(!pic){
        errorMsg="请上传图片"
    }else if(!sort){
        errorMsg="请选择对应的位置"
    }
    if(errorMsg){
        layer.alert(errorMsg);
        return false;
    }else{
        var param= {
            masterId:masterId,
            pic:pic.split("http://img.tgljweb.com/")[1].split("?")[0],
            sort:sort,
            itemId:id,
            type:type
        }
        param.createBy=adminId;
        $.ajax({
            type: "POST",
            contentType:"application/json;charset=UTF-8",
            url:http_url + "/api/operate/saveMasterStar",
            data:JSON.stringify(param),
            success: function(data){
                if(data.code==0){
                    $('#myModal_add').modal('hide');
                    getStarList();
                }
            }
        })

    }

}
//初始化图片上传
uploadImg(browse,container,".pic_url");



