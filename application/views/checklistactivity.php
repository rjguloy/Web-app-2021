<?php include 'head.php'; ?>
<?php include 'header.php'; ?>
<div class="wrapper d-flex align-items-stretch" id="wrapper">
	<?php include 'nav.php'; ?>
	<div class="page-content-wrapper mb-0"> <!-- All content of the page must be inside this div -->
		<div class="container-fluid">
			<div class="col-lg-12">
				<div class="page-title pb-2">
					<h3>Checklist Activity Settings</h3>
				</div>
				<!-- STATUS MESSAGES -->
				<div class="alert alert-success" role="alert">
				<p id="msg-prompt-success"><?php echo $this->session->flashdata('msg')?></p>
				</div>
				<div class="alert alert-warning" role="alert">
				<p id="msg-prompt-warning"><?php echo $this->session->flashdata('msg')?></p>
				</div>
				<div class="alert alert-danger" role="alert">
				<p id="msg-prompt-error"><?php echo $this->session->flashdata('msg')?></p>
				</div>
				<div class="add-new-activity text-right my-4">
					<button type="button" class="btn btn-primary py-1 mt-3 mt-md-0" id="add-activity" data-toggle="modal" 
					data-target="#modalAddActivity">Add Checklist Activity Date</button>
				</div>
				<div class="modal fade" id="modalAddActivity" tabindex="-1" role="dialog" aria-labelledby="addBuilding" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="addBuilding">Add Activity</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="input-group my-3">
									<div class="input-group-prepend">
										<span class="input-group-text" id="activity-date">Activity Date</span>
									</div>
									<input type="date" class="form-control flatpickr flatpickr-input" aria-label="activity-date" aria-describedby="activity-date" id="activityDate">
									<div id="cad-error-msg-div" class="error-msg w-100 px-3">
										<p id="cad-error-msg">Required.</p>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-cancel" data-clear data-dismiss="modal">Close</button>
								<button type="button" class="btn btn-add" onclick="addActivityDate()">Save</button>
							</div>
						</div>
					</div>
				</div>
				<div class="activity-list">
					<h4 class="mb-2">Activity List</h4>
					<table class="table table-striped" id="cadTable">
						<thead>
							<tr>
								<th>No.</th>
								<th>Date Conducted</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>	
							<?php
								$i=0;
								foreach($activity as $a){

								++$i;
							?>
							<tr>
								<td><?=$i;?></td>
								<td><?=$a->date;?></td>
								<td>
									<button type="button" class="btn btn-delete px-2 py-1" 
									onclick="deleteActivityDate('<?=$a->id;?>')" 
									data-toggle="tooltip" title="Delete">
										<img src="./assets/images/icons/delete.svg">
									</button> 
								</td>
							</tr>
							<?php
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'footer.php'; ?>

<script>

$(document).ready(function() {
	$('#cadTable').DataTable();

	$('#add-activity').click(function(e){
		$('#activityDate').val('');
		$("#cad-error-msg").html("");
		$("#cad-error-msg-div").removeClass("d-block");
	});
} );	


function addActivityDate(){
	var date = $('#activityDate').val();
	if (date==""){
		$("#cad-error-msg").html("Required.");
		$("#cad-error-msg-div").addClass("d-block");
		return;
	}

	$.ajax({
		type:'POST',
		url:'checklistActivity/addActivityDate',
		data:{date:date},
		dataType:'json',
		success:function(data){
			
			window.scrollTo(0,0);
			
			$('#modalAddActivity').modal('toggle');

			if (data.error == 1) {
			$('#msg-prompt-warning').text(data.msg)
			.parent().addClass("show");
			} else if (data.error == 2) {
			$('#msg-prompt-danger').text(data.msg)
			.parent().addClass("show");
			} else {
			$('#msg-prompt-success').text(data.msg)
			.parent().addClass("show");
			}

			
			setTimeout(
				window.location.reload(),
				1500
			);  
		}
	});

}


function deleteActivityDate(cad_id){
	if (cad_id==""){
		return;
	}
	if(confirm("Are you sure you want to delete this checklist activity date?")){
		$.ajax({
		type:'POST',
		url:'checklistActivity/deleteActivityDate',
		data:{cad_id:cad_id},
		dataType:'json',
			success:function(data){
				
				window.scrollTo(0,0);
				if (data.error == 1) {
				$('#msg-prompt-warning').text(data.msg)
				.parent().addClass("show");
				} else if (data.error == 2) {
				$('#msg-prompt-danger').text(data.msg)
				.parent().addClass("show");
				} else {
				$('#msg-prompt-success').text(data.msg)
				.parent().addClass("show");
				}

				setTimeout(
					window.location.reload(),
					1500
				);  
			}
		});

	}
}



</script>