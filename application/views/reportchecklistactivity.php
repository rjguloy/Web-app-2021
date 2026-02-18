<?php include 'head.php'; ?>
<?php include 'header.php'; ?>
<div class="wrapper d-flex align-items-stretch" id="wrapper">
	<?php include 'nav.php'; ?>
	<div class="page-content-wrapper mb-0">
		<div class="container-fluid">
			<div class="col-lg-12">
				<div class="page-title pb-2">
					<h3>Reports - Checklist Activity</h3>
				</div>
				<div class="alert" role="alert" id="msg-prompt-div">
				  <p id="msg-prompt"></p>
				</div>
				<div class="row mt-3">
					<div class="col-lg-4 mb-3">
						<div class="input-group mb-3">
							<div class="input-group mb-1">
								<div class="input-group-prepend">
									<label class="input-group-text" for="checklist-activity-date">Checklist Date</label>
								</div>
								<select class="custom-select" id="checklist-activity-date">
									<option value="0" selected>Please select date</option>
									<?php foreach($dates as $date){ ?>
										<option value="<?php echo $date->id; ?>"
										<?php echo (isset($cadId) && $cadId == $date->id) ? ' selected': '' ?>>
										<?php echo $date->date; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="col-lg-4 mb-3">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<label class="input-group-text" for="checklist-activity-location">Location</label>
							</div>
							<select class="custom-select" id="checklist-activity-location"<?php echo isset($cadId) ? '': ' disabled' ?>>
								<option value="0" selected>Please select location</option>
								<?php foreach($locations as $location){ ?>
									<option value="<?php echo $location->id; ?>"
									<?php echo (isset($locationId) && $locationId == $location->id) ? ' selected': '' ?>>
									<?php echo $location->name; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-lg-4 mb-3">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<label class="input-group-text" for="checklist-activity-sub-location">Sub-location</label>
							</div>
							<select class="custom-select" id="checklist-activity-sub-location"<?php echo isset($cadId) ? '': ' disabled' ?>>
								<option value="0" selected>Please select sub-location</option>
								<?php if (isset($sublocations) && is_array($sublocations)) : ?>
									<?php foreach($sublocations as $sub){ ?>
										<option value="<?php echo $sub->id; ?>"
										<?php echo (isset($sublocationId) && $sublocationId == $sub->id) ? ' selected': '' ?>>
										<?php echo $sub->name; ?></option>
									<?php } ?>
								<?php endif ?>
							</select>
						</div>
					</div>
				</div>
				<div class="accordion" id="reports-checklist-activity">
					<div class="card">
						<button class="card-header text-left font-weight-bold border-0 collapsed" id="HeadingHazard" data-toggle="collapse" data-target="#hazard" aria-expanded="false" aria-controls="hazard">
							Hazard
							<svg xmlns="http://www.w3.org/2000/svg" width="17.184" height="9.666" viewBox="0 0 17.184 9.666">
							  <path id="Path_8" data-name="Path 8" d="M93.167,180.018a1.074,1.074,0,0,0,1.519,0L102.2,172.5a1.074,1.074,0,1,0-1.519-1.519l-6.759,6.759-6.759-6.759a1.074,1.074,0,0,0-1.519,1.519Z" transform="translate(-85.334 -170.667)" fill="#2a5f9d"/>
							</svg>
						</button>
						<div id="hazard" class="collapse" aria-labelledby="HeadingHazard">
							<div class="card-body">
								<table class="table table-striped" id="tbl-hazard">
									<thead>
										<tr>
											<th>Item</th>
											<th>Count</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									<?php if (isset($list) && is_array($list)) : ?>
										<?php foreach ($list as $item) : ?>
											<?php if ($item->type != 'HAZARD') continue; ?>
											<tr>
												<td class="align-middle"><?php echo $item->name ?></td>
												<td class="align-middle"><?php echo $item->recordcount ?></td>
												<td class="align-middle">
													<?php if ($item->recordcount != $item->validationdatecount) : ?>
														<button type="button" class="btn btn-add py-0" name="btn-validate" 
														id="<?php echo $item->hazard_id ?>" data-toggle="tooltip" 
														title="Validate"><img src="./assets/images/icons/correct.svg"></button>
													<?php else : ?>
														Already Validated
													<?php endif ?>
												</td>
											</tr>
										<?php endforeach ?>
									<?php endif ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="card">
						<button class="card-header text-left font-weight-bold border-0 collapsed" id="HeadingCapacity" data-toggle="collapse" data-target="#capacity" aria-expanded="false" aria-controls="capacity">
							Capacity
							<svg xmlns="http://www.w3.org/2000/svg" width="17.184" height="9.666" viewBox="0 0 17.184 9.666">
							  <path id="Path_8" data-name="Path 8" d="M93.167,180.018a1.074,1.074,0,0,0,1.519,0L102.2,172.5a1.074,1.074,0,1,0-1.519-1.519l-6.759,6.759-6.759-6.759a1.074,1.074,0,0,0-1.519,1.519Z" transform="translate(-85.334 -170.667)" fill="#2a5f9d"/>
							</svg>
						</button>
						<div id="capacity" class="collapse" aria-labelledby="HeadingCapacity">
							<div class="card-body">
								<table class="table table-striped" id="tbl-capacity">
									<thead>
										<tr>
											<th>Item</th>
											<th>Count</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									<?php if (isset($list) && is_array($list)) : ?>
										<?php foreach ($list as $item) : ?>
											<?php if ($item->type != 'CAPACITY') continue; ?>
											<tr>
												<td class="align-middle"><?php echo $item->name ?></td>
												<td class="align-middle"><?php echo $item->recordcount ?></td>
												<td class="align-middle">
													<?php if ($item->recordcount != $item->validationdatecount) : ?>
														<button type="button" class="btn btn-add py-0" name="btn-validate" 
														id="<?php echo $item->hazard_id ?>" data-toggle="tooltip" 
														title="Validate"><img src="./assets/images/icons/correct.svg"></button>
													<?php else : ?>
														Already Validated
													<?php endif ?>
												</td>
											</tr>
										<?php endforeach ?>
									<?php endif ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="card">
						<button class="card-header text-left font-weight-bold border-0 collapsed" id="HeadingOthers" data-toggle="collapse" data-target="#others" aria-expanded="false" aria-controls="others">
							Others
							<svg xmlns="http://www.w3.org/2000/svg" width="17.184" height="9.666" viewBox="0 0 17.184 9.666">
							  <path id="Path_8" data-name="Path 8" d="M93.167,180.018a1.074,1.074,0,0,0,1.519,0L102.2,172.5a1.074,1.074,0,1,0-1.519-1.519l-6.759,6.759-6.759-6.759a1.074,1.074,0,0,0-1.519,1.519Z" transform="translate(-85.334 -170.667)" fill="#2a5f9d"/>
							</svg>
						</button>
						<div id="others" class="collapse" aria-labelledby="HeadingOthers">
							<div class="card-body">
								<table class="table table-striped" id="tbl-additional">
									<thead>
										<tr>
											<th>Item</th>
											<th>Count</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									<?php if (isset($list) && is_array($list)) : ?>
										<?php foreach ($list as $item) : ?>
											<?php if ($item->type != 'ADDITIONAL') continue; ?>
											<tr>
												<td class="align-middle"><?php echo $item->name ?></td>
												<td class="align-middle"><?php echo $item->recordcount ?></td>
												<td class="align-middle">
													<?php if ($item->recordcount != $item->validationdatecount) : ?>
														<button type="button" class="btn btn-add py-0" name="btn-validate" 
														id="<?php echo $item->hazard_id ?>" data-toggle="tooltip" 
														title="Validate"><img src="./assets/images/icons/correct.svg"></button>
													<?php else : ?>
														Already Validated
													<?php endif ?>
												</td>
											</tr>
										<?php endforeach ?>
									<?php endif ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'footer.php'; ?>

<script type="text/javascript">	
	$(function(){
		$('#checklist-activity-location').on('change', function (e) {
			e.preventDefault();
			clearTable();

		    $.ajax({
				type:'POST',
				url:'sublocation/getList',
				data:{id:this.value},
				dataType:'json',
				success:function(data){
                	$('#checklist-activity-sub-location').html('');
	                $("#checklist-activity-sub-location").append("<option value='0'>Please select sub-location</option>");
	                $.each(data,function(key, value){
	                    $("#checklist-activity-sub-location").append('<option value=' + value.id + '>' + value.name + '</option>');
	                });
				},
				error:function(data){
					alert("System error. Please contact your administrator.");
					console.log(data.responseText);
				}
			});	
		});

		$('#checklist-activity-date').on('change', function (e) {
			if(this.value!=0){
				$('#checklist-activity-location').removeAttr('disabled');
				$('#checklist-activity-sub-location').removeAttr('disabled');
			}else{
				$('#checklist-activity-location').prop("disabled", true);
				$('#checklist-activity-sub-location').prop("disabled", true);
			}

			// clear filters
			$('#checklist-activity-location').val("0");
			$('#checklist-activity-sub-location').val("0");
			$('#checklist-activity-sub-location option').remove();
            $("#checklist-activity-sub-location").append("<option value='0'>Please select sub-location</option>");
            clearTable();
		});

		$('#checklist-activity-sub-location').on('change', function (e) {
			var cadId = $('#checklist-activity-date').val();
			clearTable();

			$.ajax({
				type:'POST',
				url:'reportChecklistActivity/getList',
				data:{cadid:cadId, sublocationid:this.value},
				dataType:'json',
				success:function(data){
					$.each(data.list, function(index, item) {
						appendToTable(item);
					});

					$('#tbl-hazard,#tbl-capacity,#tbl-additional').DataTable();	
				},
				error:function(data){
					alert("System error. Please contact your administrator.");
					console.log(data.responseText);
				}
			});	
		});

		$(document).on('click', 'button[name=btn-validate]', function(e) {
			var cadId = $('#checklist-activity-date').val();			
			var locationId = $('#checklist-activity-location').val();
			var sublocationId = $('#checklist-activity-sub-location').val();

			if(confirm("Are you sure you want to validate record/s?")){
				$.ajax({
					type:'POST',
					url:'reportChecklistActivity/validate',
					data:{
						cadid:cadId, 
						sublocationid:sublocationId, 
						hazardid:this.id, 
						locationid:$('#checklist-activity-location').val()
					},
					dataType:'json',
					success:function(data){
						$('#msg-prompt-div').addClass("alert-success show");
	                    $('#msg-prompt').html("Successfully validated record/s.");
						setTimeout(
							function(){
								window.location.reload(false);
							},
							1500
						);	
					},
					error:function(data){		
	                    $('#msg-prompt-div').addClass("alert-danger show");
	                    $('#msg-prompt').html("System error. Please contact your administrator.");
						setTimeout(
							function(){
								window.location.reload(false);
							},
							1500
						);
					}
				});
			}
		});
	});

	function appendToTable(item){
		var rowData = 
			'<tr>' +
				'<td class="align-middle">' + item.name + '</td>' +
				'<td class="align-middle">' + item.recordcount + '</td>' +
				'<td class="align-middle">';

		if(item.recordcount != item.validationdatecount){
			rowData += 
					'<button type="button" class="btn btn-add py-0" name="btn-validate" id="' + item.hazard_id + '" data-toggle="tooltip" title="Validate"><img src="./assets/images/icons/correct.svg"></button>';
		}else{
			rowData += 'Already Validated';
		}	

		rowData += 
				'</td>' +
			'</tr>';

		switch (item.type){ 
			case "HAZARD":
				$('#tbl-hazard tbody').append(rowData);
				break;
			case "CAPACITY":
				$('#tbl-capacity tbody').append(rowData);
				break;
			case "ADDITIONAL":
				$('#tbl-additional tbody').append(rowData);
				break;
		}
	}

	function clearTable(){
		$("#tbl-hazard tbody").empty();
		$("#tbl-capacity tbody").empty();
		$("#tbl-additional tbody").empty();

		$("#tbl-hazard").dataTable().fnClearTable();
		$("#tbl-hazard").dataTable().fnDraw();
		$("#tbl-hazard").dataTable().fnDestroy();

		$("#tbl-capacity").dataTable().fnClearTable();
		$("#tbl-capacity").dataTable().fnDraw();
		$("#tbl-capacity").dataTable().fnDestroy();

		$("#tbl-additional").dataTable().fnClearTable();
		$("#tbl-additional").dataTable().fnDraw();
		$("#tbl-additional").dataTable().fnDestroy();
	}
</script>	