/**
 * Created by lucky on 2017/4/27.
 */
var options = {
    timePicker: true,
    timePicker24Hour: true,
    timePickerSeconds: true,
    buttonClasses : [ 'btn btn-default' ],
    applyClass : 'btn-small btn-primary',
    cancelClass : 'btn-small btn-danger',
    ranges : {
        //'最近1小时': [moment().subtract('hours',1), moment()],
        '今日': [moment().startOf('day'), moment()],
        '昨日': [moment().subtract('days', 1).startOf('day'), moment().subtract('days', 1).endOf('day')],
        '最近7日': [moment().subtract('days', 6), moment()],
        '最近30日': [moment().subtract('days', 29), moment()]
    },
    locale : {
        format: "YYYY-MM-DD HH:mm:ss",
        separator: " 至 ",
        applyLabel : '确定',
        cancelLabel : '取消',
        fromLabel : '起始时间',
        toLabel : '结束时间',
        customRangeLabel : '自定义',
        daysOfWeek : [ '日', '一', '二', '三', '四', '五', '六' ],
        monthNames : [ '一月', '二月', '三月', '四月', '五月', '六月',
            '七月', '八月', '九月', '十月', '十一月', '十二月' ],
        firstDay : 1
    }
};

