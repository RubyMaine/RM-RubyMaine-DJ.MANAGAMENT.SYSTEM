<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title"><b><i class="nav-icon fas fa-clipboard-list"></i> Список бронирований </b></h3>
		<div class="card-tools">
			<button class="btn  btn-sm btn-primary" id="create_new"><i class="fa fa-plus"></i> Добавить новое бронирование </button>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-bordered table-hover table-striped">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="20%">
					<col width="20%">
					<col width="20%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr class="bg-gradient-primary text-center">
						<th> ID: </th>
						<th> Реферальный коды: </th>
						<th> Планировать: </th>
						<th> Событие: </th>
						<th> Клиенты: </th>
						<th> Состояние: </th>
						<th> Действие: </th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;
						$qry = $conn->query("SELECT b.*,e.name as `event` from `booking_list` b inner join `event_list` e on b.event_id = e.id order by b.status asc, unix_timestamp(b.`date_created`) desc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?= $i++; ?></td>
							<td class="text-center"><?php echo ($row['code']) ?></td>
							<td class="text-center"><?php echo date("Y-m-d H:i",strtotime($row['event_schedule'])) ?></td>
							<td class="text-center"><?= $row['event'] ?></td>
							<td class="text-center"><?= $row['client_name'] ?></td>
							<td class="text-center">
								<?php 
									switch ($row['status']){
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
											echo '<span class="rounded-pill badge badge-default bg-gradient-default border px-3"><i class="fas fa-exclamation-triangle"></i> N/A </span>';
											break;
									}
								?>
							</td>
							<td align="center">
								 <button type="button" class="btn btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown"><i class="fas fa-exclamation-triangle"></i> Действие <span class="sr-only">Toggle Dropdown</span></button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-white"></span> Посмотреть </a>
									<?php if($row['status'] != 2): ?>
									<div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Удалить </a>
									<?php endif; ?>
				                  </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#create_new').click(function(){
			uni_modal("Добавить новое бронирование","bookings/manage_booking.php",'mid-large')
		})
		$('.view_data').click(function(){
			uni_modal("Информация о бронировании","bookings/view_details.php?id="+$(this).attr('data-id'),"mid-large")
		})
		$('.delete_data').click(function(){
			_conf("Вы уверены, что хотите удалить эту книгу навсегда?","delete_book",[$(this).attr('data-id')])
		})
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 5 }
            ],
        });
	})
	function delete_book($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_book",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>