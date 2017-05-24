/**
 * Created by lucky on 2017/4/27.
 */

//设置bootstrap validator FEEDBACK 样式
var faIcon = {
    valid: 'fa fa-check-circle fa-lg text-success',
    invalid: 'fa fa-times-circle fa-lg',
    validating: 'fa fa-refresh'
}

/**
 * 操作成功提示
 * @param msg 提示语句
 */
function completeMsg(msg) {
    $.niftyNoty({
        type: 'purple',
        icon: 'fa fa-check',
        message: msg,
        container: 'floating',
        timer: 5000
    });
}

/**
 * 操作失败提示
 * @param msg
 */
function errorMsg(msg) {
    $.niftyNoty({
        type: 'danger',
        icon: 'pli-cross icon-2x',
        message: msg,
        container: 'floating',
        timer: 5000
    });
}

/**
 * 日期数据格式化
 * @param value 值
 * @param row 行模型
 * @returns {string}
 */
function dateFormatter(value, row) {
    //var icon = row.id % 2 === 0 ? 'fa-star' : 'fa-user';
    return '<span class="text-muted"><i class="fa fa-clock-o"></i> ' + value + '</span>';
}

/**
 * 验证函数
 */
function ValidateAddInfo() {
    $('#addform').data('bootstrapValidator').validate();
    if (!$('#addform').data('bootstrapValidator').isValid()) {
        return false;
    }

    return true;
}

/**
 * 显示新增或者编辑页面
 * @param url 调用新增或者编辑的html页面
 * @param title 操作框标题
 * @param func 保存操作返回函数
 * @param id 操作数据ID，用于编辑保存用
 */
function showEditPage(url, title, func, id) {
    return showEditPageDefault(url, title, func, id, true);
}

/**
 * 显示详细信息页面
 * @param url 调用的html页面
 * @param title 操作框标题
 */
function showDetail(url, title) {
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {

            bootbox.dialog({
                title: title,
                message: data,
                buttons: {
                    cancel: {
                        label: "关闭",
                        className: "btn-primary",
                        callback: function () {
                        }
                    }
                }
            });
        }
    });
}

/**
 * 显示新增或者编辑页面
 * @param url 调用新增或者编辑的html页面
 * @param title 操作框标题
 * @param func 保存操作返回函数
 * @param id 操作数据ID，用于编辑保存用
 * @param isValid 是否启用验证
 */
function showEditPageDefault(url, title, func, id, isValid) {
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {

            bootbox.dialog({
                size: 'large',
                title: title,
                message: data,
                buttons: {
                    success: {
                        label: "保存",
                        className: "btn-primary",
                        callback: function () {
                            if (isValid) {
                                var validResult = ValidateAddInfo();
                                if (validResult == false)
                                    return false;
                            }

                            func(id);
                        }
                    },
                    cancel: {
                        label: "取消",
                        className: "btn-danger",
                        callback: function () {
                        }
                    }
                }
            });
        }
    });
}

/**
 * 提交异步保存
 * @param method ajax的HTTPMETHOD
 * @param url ajax的api路径
 * @param data ajax提交的data数据
 */
function saveInfo(method, url, data) {
    //异步保存
    $.ajax({
        cache: true,
        type: method,
        url: url,
        data: data,
        async: false,
        error: function () {
            alert("连接错误");
        },
        success: function (data) {
            if (data.code == 0) {
                completeMsg("保存成功");
                $("#table").bootstrapTable("refresh");
            } else {
                errorMsg(data.msg);
            }
        }
    });
}

/**
 * 显示删除对话框
 * @param msg 删除提示语句
 * @param url 删除的api地址
 * @param id 删除的id标识
 */
function showDeleteInfo(msg, url, id) {
    bootbox.setDefaults("locale", "zh_CN");
    bootbox.confirm(msg, function (result) {
        if (result) {
            var res = deleteInfo(url, id);
            if (res.code == 0) {
                completeMsg("删除成功");
            }
            else {
                errorMsg("删除失败，" + res.msg);
            }
            $("#table").bootstrapTable("refresh");
        }
    });
}

/**
 * 异步删除数据
 * @param url 删除的api地址
 * @param id 删除的id标识
 * @returns {*} api返回值
 */
function deleteInfo(url, id) {
    var returnVal = null;
    //异步delete
    $.ajax({
        cache: true,
        type: "DELETE",
        url: url + id,
        async: false,
        error: function (request) {
            alert("连接错误");
        },
        success: function (data) {
            returnVal = data;
        }
    });

    return returnVal;
}

/**
 * 启用状态
 * @param url 启用状态的api地址
 * @param id 启用状态的id标识
 */
function showStartInfo(url, id) {

    var res = statusInfo(url, id, '/activate');
    if (res.code == 0) {
        completeMsg("设置成功");
    }
    else {
        errorMsg("设置失败，" + res.msg);
    }
    $("#table").bootstrapTable("refresh");
}

/**
 * 停用状态
 * @param msg 停用状态的提示语句
 * @param url 停用状态的api地址
 * @param id 停用状态的id标识
 */
function showStopInfo(msg, url, id) {
    bootbox.setDefaults("locale", "zh_CN");
    bootbox.confirm(msg, function (result) {
        if (result) {
            var res = statusInfo(url, id, '/deactivate');
            if (res.code == 0) {
                completeMsg("设置成功");
            }
            else {
                errorMsg("设置失败，" + res.msg);
            }
            $("#table").bootstrapTable("refresh");
        }
    });
}

/**
 * 异步设置状态
 * @param url 设置状态的api地址
 * @param id 设置态的id标识
 * @param type 设置状态类型
 * @returns {*}
 */
function statusInfo(url, id, type) {
    var returnVal = null;
    //异步put
    $.ajax({
        cache: true,
        type: "PUT",
        url: url + id + type,
        async: false,
        error: function (request) {
            alert("连接错误");
        },
        success: function (data) {
            returnVal = data;
        }
    });

    return returnVal;
}
