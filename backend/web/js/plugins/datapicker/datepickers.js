$(function(){
	$("#data_1 .input-group.date").datepicker({
        todayBtn: "linked",
        keyboardNavigation: !1,
        forceParse: !1,
        calendarWeeks: !0,
        autoclose: !0
    }),
    $("#data_2 .input-group.date").datepicker({
        startView: 1,
        todayBtn: "linked",
        keyboardNavigation: !1,
        forceParse: !1,
        autoclose: !0,
        format: "yyyy-mm-dd"
    }),
    $("#data_3 .input-group.date").datepicker({
        startView: 2,
        todayBtn: "linked",
        keyboardNavigation: !1,
        forceParse: !1,
        autoclose: !0
    }),
    $("#data_4 .input-group.date").datepicker({
        minViewMode: 1,
        keyboardNavigation: !1,
        forceParse: !1,
        autoclose: !0,
        todayHighlight: !0
    }),
    $("#data_5 .input-daterange").datepicker({
        keyboardNavigation: !1,
        forceParse: !1,
        autoclose: !0
    }), 
	$("#data_6 .input-daterange").datepicker({
		minViewMode: 1,
        keyboardNavigation: !1,
        forceParse: !1,
        autoclose: !0
    }); 
});

