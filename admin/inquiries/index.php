<style>
    .img-avatar{
        width:45px;
        height:45px;
        object-fit:cover;
        object-position:center center;
        border-radius:100%;
    }
</style>
<div class="card card-outline card-info rounded-0">
	<div class="card-header">
		<h3 class="card-title"><b><i class="nav-icon fas fa-question-circle"></i> Список запросов </b></h3>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-striped">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="20%">
					<col width="30%">
					<col width="15%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr class="bg-gradient-primary text-center">
						<th> ID: </th>
						<th> Запрашивающий: </th>
						<th> Электронная почта: </th>
						<th> Сообщение: </th>
						<th> Состояние: </th>
						<th> Действие: </th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;
						$qry = $conn->query("SELECT * from `message_list`  order by status asc, unix_timestamp(date_created) desc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><?php echo ucwords($row['fullname']) ?></td>
							<td class="text-center"><?php echo ($row['email']) ?></td>
							<td class="text-center"><?php echo ($row['message']) ?></td>
							<td class="text-center">
								<?php if($row['status'] == 1): ?>
									<span class="badge badge-pill badge-success"><i class="fas fa-book-reader"></i> Прочитано </span>
								<?php else: ?>
								<span class="badge badge-pill badge-primary"><i class="fas fa-book-open"></i> Не прочитано </span>
								<?php endif; ?>
							</td>
							<td align="center">
								 <button type="button" class="btn btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown"><i class="fas fa-exclamation-triangle"></i> Действие <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item view_details" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-white"></span> Посмотреть </a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Удалить </a>
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
		$('.delete_data').click(function(){
			_conf("Вы уверены, что хотите удалить этот запрос навсегда?","delete_message",[$(this).attr('data-id')])
		})
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
		$('.view_details').click(function(){
			uni_modal('Inquiry Details',"inquiries/view_details.php?id="+$(this).attr('data-id'),'mid-large')
		})
		$('.table').dataTable();
		$('#uni_modal').on('hide.bs.modal',function(){
			location.reload()
		})
	})
	function delete_message($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_message",
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
	function verify_user($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Users.php?f=verify_inquiries",
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