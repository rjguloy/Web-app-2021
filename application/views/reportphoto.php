<?php
$checkDate = function($rowID) use ($dateID) {
	if ($dateID && $dateID == $rowID) return 'selected';
	return null;
};
?>
<?php include 'head.php'; ?>
<?php include 'header.php'; ?>
<div class="wrapper d-flex align-items-stretch" id="wrapper">
	<?php include 'nav.php'; ?>
	<div class="page-content-wrapper mb-0">
		<div class="container-fluid">
			<div class="col-lg-12">
				<div class="page-title pb-2">
					<h3>Reports - Hazard Photos</h3>
				</div>
				<!-- STATUS MESSAGES -->
		        <div class="alert alert-success" role="alert">
		          <p id="msg-prompt-success"></p>
		        </div>
		        <div class="alert alert-warning" role="alert">
		          <p id="msg-prompt-warning"></p>
		        </div>
		        <div class="alert alert-danger" role="alert">
		          <p id="msg-prompt-error"></p>
		        </div>
		        <form method="post" action="reportPhoto" id="form-event">
					<div class="input-group p-3" style="max-width: 527px;">
						<div class="input-group-prepend">
							<span class="input-group-text" id="reports-summary-date">Checklist Date</span>
						</div>
						<select name="dateID" id="report-date" class="form-control">
							<option value="">Please select date</option>
							<?php foreach ($dates as $row) : ?>
								<option value="<?php echo $row->id?>"<?php echo $checkDate($row->id)?>>
									<?php echo $row->date ?>
								</option>
							<?php endforeach ?>
							?>
						</select>
					</div>
				</form>
				<table id="table-photos" class="table table-striped position-relative">
					<thead>
						<tr>
							<th>Item</th>
							<th>Images</th>
							<th>Description</th>
							<th>Planned Action</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php if ($records) : ?>
							<?php $count = 0 ?>
							<?php foreach ($records as $row) : ?>
								<tr>
									<td class="align-middle">
										<?php // echo $row['record_id'].' ' ?>
										<?php echo $row['hazard_name'] ?></td>
									<td class="align-middle">
										<div class="galleryWrapper">
											<div class="imageContainer clearfix">
												<?php foreach ($row['photo'] as $file) : ?>
													<?php // echo $file['id']?>
													<?php if ( ! $file['image']) continue; ?>
													<a href="data:image/jpeg;base64,<?php echo base64_encode($file['image'])?>" class="imageLink" title="">
														<img src="data:image/jpeg;base64,<?php echo base64_encode($file['image'])?>" align="">
													</a>
												<?php endforeach ?>
											</div>
											<div class="overlayContainer">
												<div class="imageBox">
													<div class="relativeContainer">
														<img class="largeImage" src="" alt="">
														<p class="imageCaption"></p>
													</div>
												</div>
											</div>
										</div>
									</td>
									<td class="align-middle">
										<div class="form-group m-0">
											<input type="hidden" id="action-id-<?php echo $count?>" 
											value="<?php echo $row['action_id'] ? $row['action_id'] : 0 ?>">
											<textarea class="form-control" id="report-photo-desc-<?php echo $count?>" rows="3"><?php echo $row['desc']?></textarea>
										</div>
									</td>
									<td class="align-middle">
										<div class="form-group m-0">
											<textarea class="form-control" id="report-photo-action-<?php echo $count?>" rows="3"><?php echo $row['action']?></textarea>
										</div>
									</td>
									<td class="align-middle">
										<button class="btn btn-add py-0 btn-save" data-record="<?php echo $row['record_id'] ?>" data-index="<?php echo $count ?>" data-toggle="tooltip" title="Save">
											<img src="./assets/images/icons/correct.svg">
										</button>
										<button class="btn btn-delete py-0" data-record="<?php echo $row['record_id'] ?>" data-index="<?php echo $count ?>" data-toggle="tooltip" title="Delete">
											<img src="./assets/images/icons/delete.svg">
										</button>
									</td>
								</tr>
								<?php $count++ ?>
							<?php endforeach ?>
						<?php endif ?>

					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php include 'footer.php'; ?>

<script>
$(document).ready( function() {

	$('#table-photos').DataTable();

	$('#report-date').on('change', function(e) {
		
		var dateID = $(this).children("option:selected").val();

		if (dateID === '') return false; 

		$('#form-event').submit();
	});

	$(document).on('click', '.btn-save', function(e) {

		var index 		= $(this).data('index');
		var recId 		= $(this).data('record');

		var actionId 	= $('#action-id-'+index).val();
		var desc 		= $('#report-photo-desc-'+index).val();
		var action 		= $('#report-photo-action-'+index).val();

		if ( ! desc || ! action) {
			alert('Error: You need to fill up the textfields');
			return;
		}

		$.ajax({
			type: 		'POST',
			url: 		'reportPhoto/save',
			data: 		{
							recordId: recId,
							actionId: actionId,
							hazardDesc: desc, 
							hazardAction: action
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
		            // window.location.reload(false);
		            window.location.href = window.location.href;
		          },
		          1500
		        );  
			},
			error: 	function(data) {
				console.log(data.responseText);
			}
		});
	});

	$(document).on('click', '.btn-delete', function(e) {

		var x = confirm('Are you sure you want to delete these images?');

		if ( ! x) return false;

		var index 		= $(this).data('index');
		var recId 		= $(this).data('record');

		$.ajax({
			type: 		'POST',
			url: 		'reportPhoto/delete/',
			data: 		{ recordId: recId },
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
		            window.location.href = window.location.href;
		          },
		          1500
		        );  
			},
			error: 	function(data) {
				console.log(data.responseText);
			}
		});
	});
});
</script>