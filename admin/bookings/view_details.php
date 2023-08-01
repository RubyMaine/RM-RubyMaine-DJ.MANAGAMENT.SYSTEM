<?php
require_once('./../../config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT b.*,e.name as `event`, p.name as package from `booking_list` b inner join `event_list` e on b.event_id = e.id inner join package_list p on b.package_id = p.id where b.id in ({$_GET['id']}) ");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
}
?>
<style>
    #uni_modal .modal-footer{
        display:none;
    }
</style>
<div class="container-fluid">
    <div id="outprint" class="list-group">
        <div class="row">
            <div class="col-4 text-light bg-gradient-primary border"><i class="fas fa-project-diagram"></i> Реферального коды: </div>
            <div class="col-8 text-light border"><?= isset($code) ? $code : "N/A" ?></div>
            <div class="col-4 text-light bg-gradient-primary border"><i class="fas fa-user-check"></i> Имя клиента: </div>
            <div class="col-8 text-light border"><?= isset($client_name) ? $client_name : "N/A" ?></div>
            <div class="col-4 text-light bg-gradient-primary border"><i class="fas fa-mobile-alt"></i> Контактный номер: </div>
            <div class="col-8 text-light border"><?= isset($client_contact) ? $client_contact : "N/A" ?></div>
            <div class="col-4 text-light bg-gradient-primary border"><i class="fas fa-address-card"></i> Адрес: </div>
            <div class="col-8 text-light border"><?= isset($client_address) ? $client_address : "N/A" ?></div>
            <div class="col-4 text-light bg-gradient-primary border"><i class="fas fa-calendar-day"></i> Тип мероприятия: </div>
            <div class="col-8 text-light border"><?= isset($event) ? $event : "N/A" ?></div>
            <div class="col-4 text-light bg-gradient-primary border"><i class="fas fa-cubes"></i> Пакет: </div>
            <div class="col-8 text-light border"><?= isset($package) ? $package : "N/A" ?></div>
            <div class="col-4 text-light bg-gradient-primary border"><i class="fas fa-pallet"></i> Место проведения мероприятия: </div>
            <div class="col-8 text-light border"><?= isset($event_venue) ? $event_venue : "N/A" ?></div>
            <div class="col-4 text-light bg-gradient-primary border"><i class="fas fa-calendar-check"></i> Расписание: </div>
            <div class="col-8 text-light border"><?= isset($event_schedule) ? date("M d, Y h:i A", strtotime($event_schedule)) : "N/A" ?></div>
            <div class="col-4 text-light bg-gradient-primary border"><i class="fas fa-exclamation-triangle"></i> Состояние: </div>
            <div class="col-8 text-light border">
                <?php 
                $status = isset($status) ? $status : "";
                    switch ($status){
                        case 0:
                            echo '<span class="rounded-pill badge badge-secondary bg-gradient-secondary px-3"><i class="fas fa-pen-square"></i> В ожидании </span>';
                            break;
                        case 1:
                            echo '<span class="rounded-pill badge badge-primary bg-gradient-primary px-3"><i class="fas fa-check-square"></i> Подтвержденный </span>';
                            break;
                        case 2:
                            echo '<span class="rounded-pill badge badge-success bg-gradient-success px-3"><i class="fas fa-check-square"></i> Выполнено </span>';
                            break;
                        case 3:
                            echo '<span class="rounded-pill badge badge-danger bg-gradient-danger px-3"><i class="fas fa-window-close"></i> Отменено </span>';
                            break;
                        default:
                            echo '<span class="rounded-pill badge badge-default bg-gradient-default border px-3"><i class="fas fa-ellipsis-h"></i> N/A </span>';
                            break;
                    }
                ?>
            </div>
            <div class="col-4 text-light bg-gradient-primary border"><i class="fas fa-info-circle"></i> Дополнительная информация: </div>
            <div class="col-8 text-light border"><?= isset($remarks) ? $remarks : "N/A" ?></div>
        </div>
    </div>
    <div class="clear-fix my-2"></div>
    <div class="text-right">
        <button class="btn btn-sm btn-primary" type="button" id="edit_booking"><i class="fa fa-edit"></i> Редактировать </button>
        <button class="btn btn-sm btn-danger" type="button" data-dismiss="modal"><i class="far fa-window-close"></i> Закрыть </button>
    </div>
</div>

<script>
   
   $(function(){
        $('#edit_booking').click(function(){
            uni_modal("Update Booking Details - <?= isset($code) ? $code : '' ?>","bookings/manage_booking.php?id=<?= isset($id) ? $id : '' ?>",'mid-large')
        })
   })
    
</script>