<?php 
require_once('./config.php');
?>
<div class="container-fluid">
    <form action="" id="book-form">
        <input type="hidden" name="id" value="">
        <div class="row">
            <div class="col-md-6 form-group">
                <label for="client_name" class="control-label"><i class="fas fa-user-edit"></i> Ф.И.О: </label>
                <input type="text" id="client_name" name="client_name" class="form-control form-control-sm form-control-border" placeholder=" Имя Фамилия Отчество ... " required>
            </div>
            <div class="col-md-6 form-group">
                <label for="client_contact" class="control-label"><i class="fas fa-mobile-alt"></i> Контактный телефон номер: </label>
                <input type="text" id="client_contact" name="client_contact" class="form-control form-control-sm form-control-border" placeholder=" Контактный телефон номер ... " required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <label for="client_address" class="control-label"><i class="fas fa-map-marked-alt"></i> Адрес: </label>
                <textarea name="client_address" id="client_address" class="form-control form-control-sm rounded-4" placeholder=" Введите свой адрес ... " rows="3" required></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label for="package_id" class="control-label"><i class="fas fa-cubes"></i> Выбор пакеты: </label>
                <select name="package_id" id="package_id" class="form-control form-control-sm form-control-border select2" placeholder=" Выбор пакеты ... " required>
                    <option value="" disabled="disabled" selected="selected"></option>
                    <?php 
                    $package = $conn->query("SELECT * FROM `package_list` where delete_flag = 0 and status = 1 order by `name` asc");
                    while($row= $package->fetch_assoc()):
                    ?>
                        <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label for="event_id" class="control-label"><i class="fas fa-calendar-alt"></i> Тип мероприятия: </label>
                <select name="event_id" id="event_id" class="form-control form-control-sm form-control-border select2" placeholder=" Тип мероприятия ... " required>
                    <option value="" disabled="disabled" selected="selected"></option>
                    <?php 
                    $event = $conn->query("SELECT * FROM `event_list` where delete_flag = 0 and status = 1 order by `name` asc");
                    while($row= $event->fetch_assoc()):
                    ?>
                        <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label for="event_venue" class="control-label"><i class="fas fa-pallet"></i> Место проведения мероприятия: </label>
                <input type="text" id="event_venue" name="event_venue" class="form-control form-control-sm form-control-border" placeholder=" Место проведения мероприятия ... " required>
            </div>
            <div class="col-md-6 form-group">
                <label for="event_schedule" class="control-label"><i class="fas fa-clock"></i> График мероприятия: </label>
                <input type="datetime-local" id="event_schedule" name="event_schedule" class="form-control form-control-sm form-control-border" placeholder=" График мероприятия ... " required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <label for="remarks" class="control-label"><i class="fas fa-info-circle"></i> Дополнительная информация: </label>
                <textarea name="remarks" id="remarks" class="form-control form-control-sm rounded-5" rows="3" placeholder=" Дополнительная информация ... " required></textarea>
            </div>
        </div>
    </form>
</div>
<script>
    $(function(){
        $('#uni_modal').on('shown.bs.modal',function(){
            $('.select2').select2({
                placeholder:"Пожалуйста, выберите здесь...",
                width:"100%",
                dropdownParent:$('#uni_modal')
            })
        })
        $('#uni_modal #book-form').submit(function(e){
            e.preventDefault();
            var _this = $(this)
            $('.pop-msg').remove()
            var el = $('<div>')
                el.addClass("pop-msg alert")
                el.hide()
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=save_book",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
                success:function(resp){
                    if(resp.status == 'success'){
                        location.reload();
                    }else if(!!resp.msg){
                        el.addClass("alert-danger")
                        el.text(resp.msg)
                        _this.prepend(el)
                    }else{
                        el.addClass("alert-danger")
                        el.text("An error occurred due to unknown reason.")
                        _this.prepend(el)
                    }
                    el.show('slow')
                    $('html,body,.modal').animate({scrollTop:0},'fast')
                    end_loader();
                }
            })
        })
    })
</script>