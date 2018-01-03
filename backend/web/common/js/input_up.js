$(function () {
    // $(".filepath").on("change", function () {
    //     // str = $(".filepath").val();
    //     // alert(1)
    //     // console.log(str)
    //     var srcs = getObjectURL(this.files[0]);   //获取路径
    //     console.log(srcs)
    //     $(".img2").show();
    //     $(".img2").attr("src", srcs);
    //     // $(this).val('');    //必须制空
    //     // var root = $(".row_model .img2_root").val();
    //     $(".row_model .img2_root").val(srcs)
    // });

    // 编辑页面提交保存按钮点击提示信息
    $(".footer .btn-save").click(function () {
        var definition = $("input[name='definition']").val();
        if (definition == "") {
            $(".message_tip").text("请填写信息");
            return false;
        } else {
            $(".message_tip").text("")
        }
    })

    // model 确定按钮点击时候的提示语

    // model ×号关闭
    $(".modal-header .close").click(function () {
        $("#myModal").hide()
    })

    $(".foot_model .btn-sure").click(function () {
        var title = $("input[name='title']").val();
        var date_start = $("input[name='date_start']").val();
        var date_end = $("input[name='date_end']").val();
        var root = $("input[name='root']").val();

        // 标题提示
        if (title == "") {
            $(".tips").text("请填写信息")
        } else {
            $(".tips").text("");
        }

        // 时间提示
        if (date_start == "" || date_end == "") {
            $(".tips_time").text("请填写信息")
        } else {
            $(".tips_time").text("")
        }

        //图片提示
        if (root == "") {
            $(".tips_img").text("请填写信息")
        } else {
            $(".tips_img").text("")
        }

    })
})
// function getObjectURL(file) {
//     var url = null;
//     if (window.createObjectURL != undefined) {
//         url = window.createObjectURL(file)
//     } else if (window.URL != undefined) {
//         url = window.URL.createObjectURL(file)
//     } else if (window.webkitURL != undefined) {
//         url = window.webkitURL.createObjectURL(file)
//     }
//     return url
// };




