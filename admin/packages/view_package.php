<?php
require_once('../../config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `event_list` where id = '{$_GET['id']}'");
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
        display:none !important;
    }
</style>
<div class="container-fluid">
    <dl>
        <dt class="text-muted"><i class="fas fa-file-signature"></i> Название мероприятие: </dt>
        <dd class='pl-4 fs-4 fw-bold'><?= isset($name) ? $name : '' ?></dd>
        <dt class="text-muted"><i class="fas fa-file-contract"></i> Описание: </dt>
        <dd class='pl-4'>
            <p class=""><small><?= isset($description) ? ($description) : '' ?></small></p>
        </dd>
        <dt class="text-muted"><i class="fas fa-exclamation-triangle"></i> Состояние: </dt>
        <dd class='pl-4 fs-4 fw-bold'>
            <?php 
            $status = isset($status) ? $status : 0;
                switch($status){
                    case 0:
                        echo '<span class="badge badge-danger bg-gradient-danger px-3 rounded-pill"><i class="fas fa-times-circle"></i> Неактивный </span>';
                        break;
                    case 1:
                        echo '<span class="badge badge-primary bg-gradient-primary px-3 rounded-pill"><i class="fas fa-check-circle"></i> Активный </span>';
                        break;
                    default:
                        echo '<span class="badge badge-default border px-3 rounded-pill">N/A</span>';
                            break;
                }
            ?>
        </dd>
    </dl>
    <div class="col-12 text-right">
        <button class="btn btn-sm btn-danger" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Закрыть </button>
    </div>
</div>