<?php
$concatType = '';
$concatStatus = '';
																
$generateRow = function($item, $type, $status, $htype) use (&$concatType, &$concatStatus) {

	$concatType = '';
	$concatStatus = '';

	$idType 	= [];
	$idStatus 	= [];

	if ($htype == 'CAPACITY') {
		
		$idType 	= ['3','4','5'];
		$idStatus 	= ['5','6','7','8'];
	} else { 
		// This is HAZARD or OTHERS
		$idType 	= ['1','2'];
		$idStatus 	= ['1','2','3','4'];
	}

	foreach ($type as $k => $v) {
		if (in_array($v->id, $idType)) {
			if ($v->id == $item->hazardtype_id) {
				$concatType .= '<option value="'.$v->id.'" selected>'.$v->name.'</option>';
			} else {
				$concatType .= '<option value="'.$v->id.'">'.$v->name.'</option>';
			}
		} 
	}
	
	foreach ($status as $k => $v) {
		if (in_array($v->id, $idStatus)) {
			if ($v->id == $item->hazardstatus_id) {
				$concatStatus .= '<option value="'.$v->id.'" selected>'.$v->name.'</option>';
			} else {
				$concatStatus .= '<option value="'.$v->id.'">'.$v->name.'</option>';
			}
		} 
	}
}
?>
<?php include 'head.php'; ?>
<?php include 'header.php'; ?>
<div class="wrapper d-flex align-items-stretch" id="wrapper">
	<?php include 'nav.php'; ?>
	<div class="page-content-wrapper mb-0">
		<div class="container-fluid">
			<div class="col-lg-12">
				<div class="page-title pb-2">
					<h3>Reports - Summary</h3>
				</div>
				<!-- STATUS MESSAGES -->
		        <div class="alert alert-success" role="alert">
		          <p id="msg-prompt-success"></p>
		        </div>
		        <div class="alert alert-warning" role="alert">
		          <p id="msg-prompt-warning"></p>
		        </div>
		        <div class="alert alert-danger" role="alert">
		          <p id="msg-prompt-danger"></p>
		        </div>

				<div class="input-group p-3" style="max-width: 527px;">
					<div class="input-group-prepend">
						<span class="input-group-text" id="reports-summary-date">Checklist Date</span>
					</div>
					<select id="summary-date" class="form-control">
						<option value="">Please select date</option>
						<?php foreach ($dates as $row) : ?>
							<option value="<?php echo $row->id?>"<?php echo isset($dateID) && $dateID == $row->id ? ' selected' : ''?>>
								<?php echo $row->date ?>
							</option>
						<?php endforeach ?>
						?>
					</select>
					<input type="hidden" id="dateID" value="<?php echo isset($dateID) ? $dateID : '' ?>" />
				</div>
				<div class="accordion" id="reports-summary">
					<div class="card">
						<button class="card-header text-left font-weight-bold border-0 collapsed" id="HeadingHazard" 
						data-toggle="collapse" data-target="#hazard" aria-expanded="false" aria-controls="hazard">
							Hazard
							<svg xmlns="http://www.w3.org/2000/svg" width="17.184" height="9.666" viewBox="0 0 17.184 9.666">
							  <path id="Path_8" data-name="Path 8" d="M93.167,180.018a1.074,1.074,0,0,0,1.519,0L102.2,172.5a1.074,1.074,0,1,0-1.519-1.519l-6.759,6.759-6.759-6.759a1.074,1.074,0,0,0-1.519,1.519Z" transform="translate(-85.334 -170.667)" fill="#2a5f9d"/>
							</svg>
						</button>
						<div id="hazard" class="collapse" aria-labelledby="HeadingHazard">
							<div class="card-body">
								<table id="table-hazard" class="table table-striped">
									<thead>
										<tr>
											<th>Item</th>
											<th>Count</th>
											<th>Hazard Type</th>
											<th>Timeframe From</th>
											<th>Timeframe To</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php if (isset($records) && is_array($records)) : ?>
											<?php $index = 0; ?>
											<?php foreach ($records as $item) : ?>
												<?php if ($item->type != 'HAZARD') continue; ?>
												<?php $generateRow($item, $type, $status, 'HAZARD') ?>
												<tr>
													<td class="align-middle"><?php echo $item->name ?></td>
													<td class="align-middle"><?php echo $item->hazard_count ?></td>
													<td class="align-middle">
														<div class="input-group">
															<select class="custom-select" id="selectType<?php echo $index ?>">
																<option value="">Select Type</option>
																<?php echo $concatType ?>
															</select>
														</div>
													</td>
													<td class="align-middle">
														<div class="input-group my-3">
															<div class="input-group-prepend">
																<span class="input-group-text" id="summary-date">From</span>
															</div>
															<input type="date" class="form-control" aria-label="summary-date-from" 
															aria-describedby="summary-date-from" id="summaryDateFrom<?php echo $index ?>" 
															value="<?php echo $item->from ?>">
														</div>
													</td>
													<td class="align-middle">
														<div class="input-group my-3">
															<div class="input-group-prepend">
																<span class="input-group-text" id="summary-date">To</span>
															</div>
															<input type="date" class="form-control" aria-label="summary-date-to" 
															aria-describedby="summary-date-to" id="summaryDateTo<?php echo $index ?>" 
															value="<?php echo $item->to ?>">
														</div>
													</td>
													<td class="align-middle">
														<div class="input-group">
															<select class="custom-select" id="selectStatus<?php echo $index ?>">
																<option value="" selected>Select Status</option> 
																<?php echo $concatStatus ?>
															</select>
														</div>
													</td>
													<td class="align-middle"><button class="btn btn-add btn-save py-0" data-index="<?php echo $index ?>" 
													data-id="<?php echo $item->hazard_id ?>" data-name="<?php echo $item->name ?>" 
													data-count="<?php echo $item->hazard_count ?>" data-type="'<?php echo $item->type ?>" 
													data-toggle="tooltip" title="Save">
													<img src="./assets/images/icons/correct.svg"></button></td>
												</tr>
												<?php $index++ ?>
											<?php endforeach ?>
										<?php endif ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="card">
						<button class="card-header text-left font-weight-bold border-0 collapsed" id="HeadingCapacity" 
						data-toggle="collapse" data-target="#capacity" aria-expanded="false" aria-controls="capacity">
							Capacity
							<svg xmlns="http://www.w3.org/2000/svg" width="17.184" height="9.666" viewBox="0 0 17.184 9.666">
							  <path id="Path_8" data-name="Path 8" d="M93.167,180.018a1.074,1.074,0,0,0,1.519,0L102.2,172.5a1.074,1.074,0,1,0-1.519-1.519l-6.759,6.759-6.759-6.759a1.074,1.074,0,0,0-1.519,1.519Z" transform="translate(-85.334 -170.667)" fill="#2a5f9d"/>
							</svg>
						</button>
						<div id="capacity" class="collapse" aria-labelledby="HeadingCapacity">
							<div class="card-body">
								<table id="table-capacity" class="table table-striped">
									<thead>
										<tr>
											<th>Item</th>
											<th>Count</th>
											<th>Hazard Type</th>
											<th>Timeframe From</th>
											<th>Timeframe To</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php if (isset($records) && is_array($records)) : ?>
											<?php // $index = 0; ?>
											<?php foreach ($records as $item) : ?>
												<?php if ($item->type != 'CAPACITY') continue; ?>
												<?php $generateRow($item, $type, $status, 'CAPACITY') ?>
												<tr>
													<td class="align-middle"><?php echo $item->name ?></td>
													<td class="align-middle"><?php echo $item->hazard_count ?></td>
													<td class="align-middle">
														<div class="input-group">
															<select class="custom-select" id="selectType<?php echo $index ?>">
																<option value="">Select Type</option>
																<?php echo $concatType ?>
															</select>
														</div>
													</td>
													<td class="align-middle">
														<div class="input-group my-3">
															<div class="input-group-prepend">
																<span class="input-group-text" id="summary-date">From</span>
															</div>
															<input type="date" class="form-control" aria-label="summary-date-from" 
															aria-describedby="summary-date-from" id="summaryDateFrom<?php echo $index ?>" 
															value="<?php echo $item->from ?>">
														</div>
													</td>
													<td class="align-middle">
														<div class="input-group my-3">
															<div class="input-group-prepend">
																<span class="input-group-text" id="summary-date">To</span>
															</div>
															<input type="date" class="form-control" aria-label="summary-date-to" 
															aria-describedby="summary-date-to" id="summaryDateTo<?php echo $index ?>" 
															value="<?php echo $item->to ?>">
														</div>
													</td>
													<td class="align-middle">
														<div class="input-group">
															<select class="custom-select" id="selectStatus<?php echo $index ?>">
																<option value="" selected>Select Status</option> 
																<?php echo $concatStatus ?>
															</select>
														</div>
													</td>
													<td class="align-middle"><button class="btn btn-add btn-save py-0" data-index="<?php echo $index ?>" 
													data-id="<?php echo $item->hazard_id ?>" data-name="<?php echo $item->name ?>" 
													data-count="<?php echo $item->hazard_count ?>" data-type="'<?php echo $item->type ?>" 
													data-toggle="tooltip" title="Save">
													<img src="./assets/images/icons/correct.svg"></button></td>
												</tr>
												<?php $index++ ?>
											<?php endforeach ?>
										<?php endif ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="card">
						<button class="card-header text-left font-weight-bold border-0 collapsed" id="HeadingOthers" 
						data-toggle="collapse" data-target="#others" aria-expanded="false" aria-controls="others">
							Others
							<svg xmlns="http://www.w3.org/2000/svg" width="17.184" height="9.666" viewBox="0 0 17.184 9.666">
							  <path id="Path_8" data-name="Path 8" d="M93.167,180.018a1.074,1.074,0,0,0,1.519,0L102.2,172.5a1.074,1.074,0,1,0-1.519-1.519l-6.759,6.759-6.759-6.759a1.074,1.074,0,0,0-1.519,1.519Z" transform="translate(-85.334 -170.667)" fill="#2a5f9d"/>
							</svg>
						</button>
						<div id="others" class="collapse" aria-labelledby="HeadingOthers">
							<div class="card-body">
								<table id="table-others" class="table table-striped">
									<thead>
										<tr>
											<th>Item</th>
											<th>Count</th>
											<th>Hazard Type</th>
											<th>Timeframe From</th>
											<th>Timeframe To</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									<?php if (isset($records) && is_array($records)) : ?>
											<?php // $index = 0; ?>
											<?php foreach ($records as $item) : ?>
												<?php if ($item->type != 'ADDITIONAL') continue; ?>
												<?php $generateRow($item, $type, $status, 'ADDITIONAL') ?>
												<tr>
													<td class="align-middle"><?php echo $item->name ?></td>
													<td class="align-middle"><?php echo $item->hazard_count ?></td>
													<td class="align-middle">
														<div class="input-group">
															<select class="custom-select" id="selectType<?php echo $index ?>">
																<option value="">Select Type</option>
																<?php echo $concatType ?>
															</select>
														</div>
													</td>
													<td class="align-middle">
														<div class="input-group my-3">
															<div class="input-group-prepend">
																<span class="input-group-text" id="summary-date">From</span>
															</div>
															<input type="date" class="form-control" aria-label="summary-date-from" 
															aria-describedby="summary-date-from" id="summaryDateFrom<?php echo $index ?>" 
															value="<?php echo $item->from ?>">
														</div>
													</td>
													<td class="align-middle">
														<div class="input-group my-3">
															<div class="input-group-prepend">
																<span class="input-group-text" id="summary-date">To</span>
															</div>
															<input type="date" class="form-control" aria-label="summary-date-to" 
															aria-describedby="summary-date-to" id="summaryDateTo<?php echo $index ?>" 
															value="<?php echo $item->to ?>">
														</div>
													</td>
													<td class="align-middle">
														<div class="input-group">
															<select class="custom-select" id="selectStatus<?php echo $index ?>">
																<option value="" selected>Select Status</option> 
																<?php echo $concatStatus ?>
															</select>
														</div>
													</td>
													<td class="align-middle"><button class="btn btn-add btn-save py-0" data-index="<?php echo $index ?>" 
													data-id="<?php echo $item->hazard_id ?>" data-name="<?php echo $item->name ?>" 
													data-count="<?php echo $item->hazard_count ?>" data-type="'<?php echo $item->type ?>" 
													data-toggle="tooltip" title="Save">
													<img src="./assets/images/icons/correct.svg"></button></td>
												</tr>
												<?php $index++ ?>
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

<script>
$(document).ready( function() {

	

	$('#summary-date').on('change', function(e) {
		
		var dateID = $(this).children("option:selected").val();

		if (dateID === '') return false; 

		$.ajax({
			type: 		'POST',
			url: 		'reportSummary/events/' + dateID,
			data: 		null,
			dataType: 	'json',
			success: 	function(data) {
				// console.log(data);

				$('#dateID').val(data.dateID);

				$("#table-hazard tbody").empty();
				$("#table-capacity tbody").empty();
				$("#table-others tbody").empty();

				$("#table-hazard").dataTable().fnClearTable();
				$("#table-hazard").dataTable().fnDraw();
				$("#table-hazard").dataTable().fnDestroy();

				$("#table-capacity").dataTable().fnClearTable();
				$("#table-capacity").dataTable().fnDraw();
				$("#table-capacity").dataTable().fnDestroy();

				$("#table-others").dataTable().fnClearTable();
				$("#table-others").dataTable().fnDraw();
				$("#table-others").dataTable().fnDestroy();

				var buffer = '';
				// Show Hazards
				$('#table-hazard tbody').html('');
				$.each(data.records, function(index, val) {
						if (val.type == 'HAZARD') 
							// buffer += showHazardTable(index, val, data);
							buffer += showRow(index, val, data, 'HAZARD');
				});

				$('#table-hazard tbody').append(buffer);

				buffer = '';
				// Show Capacities
				$('#table-capacity tbody').html('');
				$.each(data.records, function(index, val) {
						if (val.type == 'CAPACITY') 
							// buffer += showCapacityTable(index, val, data);
							buffer += showRow(index, val, data, 'CAPACITY');
				});

				$('#table-capacity tbody').append(buffer);
				
				buffer = '';
				// Show Others
				$('#table-others tbody').html('');		
				$.each(data.records, function(index, val) {
						if (val.type == 'ADDITIONAL') 
							// buffer += showOthersTable(index, val, data);
							buffer += showRow(index, val, data, 'ADDITIONAL');
				});
				
				$('#table-others tbody').append(buffer);

				$('#table-hazard,#table-capacity,#table-others').DataTable();
			},
			error: 		function(data) {
				alert(data.responseText);
			}
		});
	});

	$(document).on('click', 'button.btn-save', function(e) {

		var index 		= $(this).data('index');
		var id 			= $(this).data('id');
		var name 		= $(this).data('name');
		var count 		= $(this).data('count');
		var type 		= $(this).data('type');
		var htype 		= $('#selectType'+index).find(':selected').val();
		var status 		= $('#selectStatus'+index).find(':selected').val();
		var dateFrom 	= $('#summaryDateFrom'+index).val();
		var dateTo 		= $('#summaryDateTo'+index).val();
		var dateID 		= $('#dateID').val();
				
		if ( ! htype || ! status || ! dateFrom || ! dateTo) {
			alert('Error: You need to fill up the textfields');
			return;
		}

		$.ajax({
			type: 		'POST',
			url: 		'reportSummary/save',
			data: 		{
							hazardID: 		id, 
							HazardName: 	name,
							hazardCount: 	count,
							type: 			type,
							hazardType: 	htype,
							hazardStatus: 	status,
							dateFrom: 		dateFrom,
							dateTo: 		dateTo,
							dateID: 		dateID
						},
			dataType: 	'json',
			success: 	function(data) {
				//console.log(data);
				if (data.error == 1) {
		          $('#msg-prompt-warning')
		          .parent().addClass("show").append(data.msg);
		        } else if (data.error == 2) {
		          $('#msg-prompt-danger')
		          .parent().addClass("show").append(data.msg);
		        } else {
		          $('#msg-prompt-success')
		          .parent().addClass("show").append(data.msg);
		        }
		        setTimeout(
		          function(){
		            window.location.reload(true);
		          },
		          3000
		        );  
			},
			error: 	function(data) {
				console.log(data.responseText);
			}
		});
	});


	function showRow(index, record, data, type) {
		var concatType 		= '';
		var concatStatus 	= '';
		var idType 			= [];
		var idStatus 		= [];

		if (type == 'CAPACITY') {
			
			idType 		= ['3','4','5'];
			idStatus 	= ['5','6','7','8'];
		} else { 
			// This is HAZARD or OTHERS
			idType 		= ['1','2'];
			idStatus 	= ['1','2','3','4'];
		}


		$.each(data.type, function(index, val) {
			if ($.inArray(val.id, idType) != -1) {
				if (val.id == record.hazardtype_id) {
					concatType += '<option value="'+val.id+'" selected>'+val.name+'</option>';
				} else {
					concatType += '<option value="'+val.id+'">'+val.name+'</option>';
				}
			}
		});

		$.each(data.status, function(index, val) {
			if ($.inArray(val.id, idStatus) != -1) {

				if (val.id == record.hazardstatus_id) {
					concatStatus += '<option value="'+val.id+'" selected>'+val.name+'</option>';
				} else {
					concatStatus += '<option value="'+val.id+'">'+val.name+'</option>';
				}
			}
		});
		

		var x = '<tr>\
					<td class="align-middle">'+record.name+'</td>\
					<td class="align-middle">'+record.hazard_count+'</td>\
					<td class="align-middle">\
						<div class="input-group">\
							<select class="custom-select" id="selectType'+index+'">\
								<option value="">Select Type</option>'+
								concatType+'\
							</select>\
						</div>\
					</td>\
					<td class="align-middle">\
						<div class="input-group my-3">\
							<div class="input-group-prepend">\
								<span class="input-group-text" id="summary-date">From</span>\
							</div>\
							<input type="date" class="form-control" aria-label="summary-date-from" aria-describedby="summary-date-from" \
							id="summaryDateFrom'+index+'" value="'+record.from+'">\
						</div>\
					</td>\
					<td class="align-middle">\
						<div class="input-group my-3">\
							<div class="input-group-prepend">\
								<span class="input-group-text" id="summary-date">To</span>\
							</div>\
							<input type="date" class="form-control" aria-label="summary-date-to" aria-describedby="summary-date-to" id="summaryDateTo'+index+'" value="'+record.to+'">\
						</div>\
					</td>\
					<td class="align-middle">\
						<div class="input-group">\
							<select class="custom-select" id="selectStatus'+index+'">\
								<option value="" selected>Select Status</option>'+
								concatStatus
							+'</select>\
						</div>\
					</td>\
					<td class="align-middle"><button class="btn btn-add btn-save py-0" data-index="'+index+'" data-id="'+
					record.hazard_id+'" data-name="'+record.name+'" data-count="'+record.hazard_count+'" data-type="'+type+'" data-toggle="tooltip" title="Save"><img src="./assets/images/icons/correct.svg"></button></td>\
				</tr>';
		
		return x;
	}
});

</script>