<style>
    .img-thumb-path{
        width:100px;
        height:80px;
        object-fit:scale-down;
        object-position:center center;
    }
</style>
<div class="card card-outline card-primary rounded-0 shadow">
	<div class="card-header">
		<h3 class="card-title"><b><i class="fas fa-cubes"></i> Список пакетов </b></h3>
		<div class="card-tools">
			<a href="javascript:void(0)" id="create_new" class="btn btn-sm btn-primary"><b><span class="fas fa-plus"></span> Добавить новые пакеты </b></a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-bordered table-hover table-striped">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="20%">
					<col width="25%">
					<col width="15%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr class="bg-gradient-primary text-center">
						<th> ID: </th>
						<th> Дата создания: </th>
						<th> Название пакета: </th>
						<th> Описание: </th>
						<th> Состояние: </th>
						<th> Действие: </th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;
						$qry = $conn->query("SELECT * from `package_list` where delete_flag = 0 order by `name` asc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td class="text-center"><?php echo $row['name'] ?></td>
							<td class="text-center"><p class="m-0 truncate-1"><?php echo strip_tags(html_entity_decode($row['description'])) ?></p></td>
							<td class="text-center">
								<?php 
									switch($row['status']){
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
							</td>
							<td align="center">
								 <button type="button" class="btn btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown"><i class="fas fa-exclamation-triangle"></i> Действие <span class="sr-only">Toggle Dropdown</span></button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item view_data" href="javascript:void(0)" data-id ="<?php echo $row['id'] ?>"><span class="fa fa-eye text-light"></span> Посмотреть </a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item edit_data" href="javascript:void(0)" data-id ="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Редактировать </a>
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
        $('#create_new').click(function(){
			uni_modal("Добавить новый пакет","packages/manage_package.php",'mid-large')
		})
        $('.edit_data').click(function(){
			uni_modal("Обновить сведения о пакете","packages/manage_package.php?id="+$(this).attr('data-id'),'mid-large')
		})
		$('.delete_data').click(function(){
			_conf("Вы уверены, что хотите навсегда удалить этот пакет?","delete_package",[$(this).attr('data-id')])
		})
		$('.view_data').click(function(){
			uni_modal("Подробная информация о пакете","packages/view_package.php?id="+$(this).attr('data-id'))
		})
		$('.table td, .table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 5 }
            ],
        });
	})
	function delete_package($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_package",
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