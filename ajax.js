/******************************/
/*            Л/С             */
/******************************/

/* Добавление Л/С */
$(document).on('click', '#btn-add', function (e) {
    var data = $("#user_form").serialize();
    $.ajax({
        data: data,
        type: "post",
        url: "insert.php",
        success: function (dataResult) {
            var dataResult = JSON.parse(dataResult);
            console.log(dataResult);
            if (dataResult.statusCode == 200) {
                $('#addEmployeeModal').modal('hide');
                alert('Добавлен новый Л/С !');
                location.reload();
            } else if (dataResult.statusCode == 201) {
                alert(dataResult);
            }
        }
    });
});

/* Обновить Л/С */
$(document).on('click', '.update', function (e) {
    var id = $(this).attr("data-id");
    var flatnumber = $(this).attr("data-flatnumber");
    var address = $(this).attr("data-address");
    var owner = $(this).attr("data-owner");
    $('#id_u').val(id);
    $('#flat_number_u').val(flatnumber);
    $('#address_u').val(address);
    $('#owner_u').val(owner);
});

$(document).on('click', '#update', function (e) {
    var data = $("#update_form").serialize();
    $.ajax({
        data: data,
        type: "post",
        url: "update.php",
        success: function (dataResult) {
            var dataResult = JSON.parse(dataResult);
            if (dataResult.statusCode == 200) {
                alert('Данные успешно обновлены !');
                location.reload();
            } else if (dataResult.statusCode == 201) {
                alert(dataResult);
            }
        }
    });
});

/* Удаление Л/С */
$(document).on("click", ".delete", function () {
    var id = $(this).attr("data-id");
    $('#id_d').val(id);

});

$(document).on("click", "#delete", function () {
    $.ajax({
        url: "delete.php",
        type: "POST",
        cache: false,
        data: {
            type: 3,
            id: $("#id_d").val()
        },
        success: function (dataResult) {
            alert('Л/С  удален.');
            location.reload();
            $('#deleteEmployeeModal').modal('hide');
            $("#" + dataResult).remove();

        }
    });
});

/**************************/
/* Динамический выпадающий
 список 
 1. Select list - № Л/C
 2. Select list только тех месяцев, которых нет в системе для insert, update
 */
$(document).ready(function () {
    $('#id_ls_list').on('change', function () {
        var table = $(this).attr("data-table");
        var ls_id = this.value;
        var syear = document.getElementById("syear").value;
        $.ajax({
            url: "dynamic_list.php",
            type: "POST",
            data: {
                ls_id: ls_id,
                table: table,
                syear: syear
            },
            cache: false,
            success: function (result) {
                $("#smonth").html(result);
            }
        });
    });
    
    $('#syear').on('change', function () {
        var table = $(this).attr("data-table");
        var ls_id = this.value;
        var syear = document.getElementById("syear").value;
        $.ajax({
            url: "dynamic_list.php",
            type: "POST",
            data: {
                ls_id: ls_id,
                table: table,
                syear: syear
            },
            cache: false,
            success: function (result) {
                $("#smonth").html(result);
            }
        });
    });
});

/******************************/
/*         Начисления         */
/******************************/

/* Добавление */
$(document).on('click', '#btn-add-nach', function (e) {
    var data = $("#user_form").serialize();
    $.ajax({
        data: data,
        type: "post",
        url: "insert.php",
        success: function (dataResult) {
            var dataResult = JSON.parse(dataResult);
            console.log(dataResult);
            if (dataResult.statusCode == 200) {
                $('#addEmployeeModal').modal('hide');
                alert('Добавлены новые начисления !');
                location.reload();
            } else if (dataResult.statusCode == 201) {
                alert(dataResult);
            }
        }
    });
});

/* Обновить  */
$(document).on('click', '.update_nach', function (e) {
    var idls = $(this).attr("data-idls");
    var smonth = $(this).attr("data-smonth");
    var syear = $(this).attr("data-syear");
    var scount = $(this).attr("data-scount");
    $('#idls_u').val(idls);
    $('#smonth_u').val(smonth);
    $('#syear_u').val(syear);
    $('#scount_u').val(scount);
});

$(document).on('click', '#update-nach', function (e) {
    var data = $("#update_form").serialize();
    $.ajax({
        data: data,
        type: "post",
        url: "update.php",
        success: function (dataResult) {
            var dataResult = JSON.parse(dataResult);
            if (dataResult.statusCode == 200) {
                alert('Данные успешно обновлены !');
                location.reload();
            } else if (dataResult.statusCode == 201) {
                alert(dataResult);
            }
        }
    });
});

/* Удаление */
$(document).on("click", ".delete-nach", function () {
    var idls = $(this).attr("data-idls");
    var smonth = $(this).attr("data-smonth");
    var syear = $(this).attr("data-syear");
    $('#idls_d').val(idls);
    $('#smonth_d').val(smonth);
    $('#syear_d').val(syear);
});

$(document).on("click", "#delete-nach", function () {
    $.ajax({
        url: "delete.php",
        type: "POST",
        cache: false,
        data: {
            type: 23,
            idls: $("#idls_d").val(),
            smonth: $("#smonth_d").val(),
            syear: $("#syear_d").val()
        },
        success: function (dataResult) {
            alert('Начисление  удалено.');
            location.reload();
            $('#deleteEmployeeModal').modal('hide');
            $("#" + dataResult).remove();

        }
    });
});


/******************************/
/*         Платежи            */
/******************************/

/* Добавление */
$(document).on('click', '#btn-add-plat', function (e) {
    var data = $("#user_form").serialize();
    $.ajax({
        data: data,
        type: "post",
        url: "insert.php",
        success: function (dataResult) {
            var dataResult = JSON.parse(dataResult);
            console.log(dataResult);
            if (dataResult.statusCode == 200) {
                $('#addEmployeeModal').modal('hide');
                alert('Добавлены новые начисления !');
                location.reload();
            } else if (dataResult.statusCode == 201) {
                alert(dataResult);
            }
        }
    });
});

/* Обновить  */
$(document).on('click', '.update_plat', function (e) {
    var idls = $(this).attr("data-idls");
    var smonth = $(this).attr("data-smonth");
    var syear = $(this).attr("data-syear");
    var scount = $(this).attr("data-scount");
    $('#idls_u').val(idls);
    $('#smonth_u').val(smonth);
    $('#syear_u').val(syear);
    $('#scount_u').val(scount);
});

$(document).on('click', '#update-plat', function (e) {
    var data = $("#update_form").serialize();
    $.ajax({
        data: data,
        type: "post",
        url: "update.php",
        success: function (dataResult) {
            var dataResult = JSON.parse(dataResult);
            if (dataResult.statusCode == 200) {
                alert('Данные успешно обновлены !');
                location.reload();
            } else if (dataResult.statusCode == 201) {
                alert(dataResult);
            }
        }
    });
});

/* Удаление */
$(document).on("click", ".delete-plat", function () {
    var idls = $(this).attr("data-idls");
    var smonth = $(this).attr("data-smonth");
    var syear = $(this).attr("data-syear");
    $('#idls_d').val(idls);
    $('#smonth_d').val(smonth);
    $('#syear_d').val(syear);
});

$(document).on("click", "#delete-plat", function () {
    $.ajax({
        url: "delete.php",
        type: "POST",
        cache: false,
        data: {
            type: 33,
            idls: $("#idls_d").val(),
            smonth: $("#smonth_d").val(),
            syear: $("#syear_d").val()
        },
        success: function (dataResult) {
            alert('Платеж  удален.');
            location.reload();
            $('#deleteEmployeeModal').modal('hide');
            $("#" + dataResult).remove();

        }
    });
});

/******************************/
/*         Сальдо             */
/******************************/

/* Расчет */
$(document).on('click', '#btn-add-saldo', function (e) {
    var data = $("#user_form").serialize();
    $.ajax({
        data: data,
        type: "post",
        url: "insert.php",
        success: function (dataResult) {
            var dataResult = JSON.parse(dataResult);
            console.log(dataResult);
            if (dataResult.statusCode == 200) {
                $('#addEmployeeModal').modal('hide');
                alert('Выполнен расчет сальдо на начало и конец года !');
                location.reload();
            } else if (dataResult.statusCode == 201) {
                alert(dataResult);
            }
        }
    });
});