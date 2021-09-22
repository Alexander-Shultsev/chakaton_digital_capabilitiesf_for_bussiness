<html>
<head>
    <meta charset="UTF-8">
    <title>Users info</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>

<div class="container-fluid w-75 mb-5 mt-5">
    
    <h3 class="text-center">Статистика по сотрудникам</h3>
    
    
    
    <form id="selectUser" class="mb-5">
        <div class="form-group mb-3">
            <label for="userSelector p-3">Выберите пользователя</label>
            <select title="Выбор пользователя" class="form-control selectpicker" id="userSelector">
                <option value=0>Все пользователи</option>
            </select>
        </div>
        
        <div class="form-group mb-3">
            <label for="inputDate">Введите дату:</label>
            <input type="date" class="form-control" id="dateSelector">
     </div>
     
      <button type="submit" class="btn btn-primary w-100">Поиск</button>
    </form>

    <div class="mb-5" id="thisMonth"></div>
    
    <div class="mb-5" id="lastMonth"></div>
    
    <div class="mb-5" id="diff"></div>
    
    <div class="mb-5" id="predictedSum"></div>
    
    <div class="mb-5" id="debtors"></div>
</div>

<script>
    $(function(){
        $.ajax({    
            type: "GET",
            url: "http://grisha4c.beget.tech/api/all_users_id.php",
            dataType: "json", 
            success: function(response){
                    jQuery.each(response, function(key, val) {
                        $("#userSelector").append("<option value=" + val.id +">"+val.id+". "+val.first_name+" "+val.surname+"</option>");
                    });
            }
        });
    })
    
    $("#selectUser").submit(function(event){
        event.preventDefault();
       
        var user_id = $("#userSelector").val();
        var date = $("#dateSelector").val();
        
        var data = user_id != 0 ? {'date': date, 'user_id': user_id} : {'date': date};
        
        if (!date) {
            return false;
        }
        
    //Заполнение таблицы на этот месяц
        $.ajax({    
            type: "GET",
            url: "http://grisha4c.beget.tech/api/users_month.php",
            data: data,
            dataType: "json", 
            success: function(response){
                    var data_m = response;
                    $("#thisMonth").html("<h5 class='text-center'>За выбранный месяц</h5><table class='table table-bordered mb-5' id='thisMonthTable'><thead class='table-primary'><tr><th scope='col'>Средняя сумма за выбранный месяц</th><th scope='col'>Итого за выбранный месяц</th><th scope='col'>Средняя сумма чека за день</th></tr></thead><tbody></tbody></table>");
                    jQuery.each(response, function(key, val) {
                        var avg_sum_m = val.avg_sum !== null ? Math.floor(val.avg_sum) : "Данные не найдены";
                        var sum_sum_m = val.sum_sum !== null ? Math.floor(val.sum_sum) : "Данные не найдены";
                        var avg_sum_day_m = val.avg_sum_day !== null ? Math.floor(val.avg_sum_day) : "Данные не найдены";
                       $("#thisMonthTable").append("<tr class='table-light'><td class='col-4'>"+avg_sum_m+"</td><td class='col-3'>"+sum_sum_m+"</td><td>"+avg_sum_day_m+"</td class='col-4'></tr>");
                    });
                    
            
                
                    //Заполнение таблицы на предыдущий месяц
        $.ajax({    
            type: "GET",
            url: "http://grisha4c.beget.tech/api/users_last_month.php",
            data: data,
            dataType: "json", 
            success: function(response){
                    var data_lm = response;
                    $("#lastMonth").html("<h5 class='text-center'>За предыдущий месяц</h5><table class='table table-bordered mb-5' id='lastMonthTable'><thead class='table-primary'><tr><th scope='col'>Средняя сумма за предыдущий месяц</th><th scope='col'>Итого за предыдущий месяц</th><th scope='col'>Средняя сумма чека за день прошлого месяца</th></tr></thead><tbody></tbody></table>");
                    $("#diff").html("<h5 class='text-center'>Разница между выбранным и предыдущим месяцом</h5><table class='table table-bordered mb-5' id='diffTable'><thead class='table-primary'><tr><th scope='col'>Разница средних сумм</th><th scope='col'>Разница сумм</th><th scope='col'>Разница сумм за день</th></tr></thead><tbody></tbody></table>");
                    $("#predictedSum").html("<h5 class='text-center'>Прогнозируемая сумма</h5><ul id='predSumList' class='list-group'></ul>");
                    jQuery.each(response, function(key, val) {
                        var avg_sum_lm = val.avg_sum !== null ? Math.floor(val.avg_sum) : "Данные не найдены";
                        var sum_sum_lm = val.sum_sum !== null ? Math.floor(val.sum_sum) : "Данные не найдены";
                        var avg_sum_day_lm = val.avg_sum_day !== null ? Math.floor(val.avg_sum_day) : "Данные не найдены";
                       $("#lastMonthTable").append("<tr class='table-light'><td class='col-4'>"+avg_sum_lm+"</td><td class='col-3'>"+sum_sum_lm+"</td><td>"+avg_sum_day_lm+"</td class='col-4'></tr>");
                       $("#predSumList").append("<li class='list-group-item list-group-item-primary text-center'>"+avg_sum_lm+"</li>");
                    });
            
                
                
                for (let i = 0; i < data_m.length; i++) {
                  $("#diffTable").append("<tr class='table-light'><td class='col-4'>"+(Math.abs(Math.floor(data_m[i].avg_sum) - Math.floor(data_lm[i].avg_sum)))+"</td><td class='col-3'>"+(Math.abs(Math.floor(data_m[i].sum_sum) - Math.floor(data_lm[i].sum_sum)))+"</td><td>"+(Math.abs(Math.floor(data_m[i].avg_sum_day) - Math.floor(data_lm[i].avg_sum_day)))+"</td class='col-4'></tr>");
                }
                
            }
        });
                
                
                
            } //success
        });
        
        
        //список должников месяца
        $.ajax({    
            type: "GET",
            url: "http://grisha4c.beget.tech/api/month_limit.php",
            data: {'date': date},
            dataType: "json", 
            success: function(response){
                    $("#debtors").html("<h5 class='text-center'>Список сотрудников, превысивших лимит трат в месяц</h4><ul id='debtorList' class='list-group'></ul>");
                    jQuery.each(response, function(key, val) {
                        if (parseInt(val.l) < 0) {
                            $("#debtorList").append("<li class='list-group-item list-group-item-danger text-center'>"+val.first_name+"</li>");
                        }
                    });
                    
                    console.log($('#debtorList').length);
            }
        });
        
    });
</script>
</body>
</html>