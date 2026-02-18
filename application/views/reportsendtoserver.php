<?php include 'head.php'; ?>
<?php include 'header.php'; ?>
<div class="wrapper d-flex align-items-stretch" id="wrapper">
	<?php include 'nav.php'; ?>
	<div class="page-content-wrapper mb-0">
		<div class="container-fluid">
			<div class="col-lg-12">
				<div class="page-title pb-2">
					<h3>Reports - Send To Server</h3>
				</div>
				<div class="alert" role="alert" id="msg-prompt-div">
				  <p id="msg-prompt"></p>
				</div>
				<div class="input-group p-3" style="max-width: 527px;">
					<div class="input-group mb-1">
						<div class="input-group-prepend">
							<label class="input-group-text" for="checklist-activity-date">Checklist Date</label>
						</div>
						<form action="reportSendToServer" id="frm-report-cad" method="POST">
							<select class="custom-select" id="checklist-activity-date" name="checklist-activity-date">
								<option value="0" <?php echo ($selectedCad == 0) ? 'selected' : ''; ?>>Please select date</option>
								<?php foreach($dates as $date){ ?>
									<option value="<?php echo $date->id; ?>" <?php echo ($selectedCad == $date->id) ? 'selected' : ''; ?>><?php echo $date->date; ?></option>
								<?php } ?>
							</select>
						</form>
					</div>
				</div>
				<div class="accordion" id="reports-summary">
					<div class="card">
						<button class="card-header collapsed text-left font-weight-bold border-0" id="HeadingHazard" data-toggle="collapse" data-target="#hazard" aria-expanded="true" aria-controls="hazard">
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
											<th>Timeframe</th>
											<th>Type</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($hazardList as $item){ 
											if($item->type=='HAZARD'){?>
										<tr>
											<td><?php echo $item->name; ?></td>
											<td><?php echo $item->recordcount; ?></td>
											<td><?php echo $item->timeframe; ?></td>
											<td><?php echo $item->type2; ?></td>
											<td><?php echo $item->status; ?></td>
										</tr>
										<?php }} ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="card">
						<button class="card-header collapsed text-left font-weight-bold border-0" id="HeadingCapacity" data-toggle="collapse" data-target="#capacity" aria-expanded="true" aria-controls="capacity">
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
											<th>Timeframe</th>
											<th>Type</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($hazardList as $item){ 
											if($item->type=='CAPACITY'){?>
										<tr>
											<td><?php echo $item->name; ?></td>
											<td><?php echo $item->recordcount; ?></td>
											<td><?php echo $item->timeframe; ?></td>
											<td><?php echo $item->type2; ?></td>
											<td><?php echo $item->status; ?></td>
										</tr>
										<?php }} ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="card">
						<button class="card-header collapsed text-left font-weight-bold border-0" id="HeadingHazardPhotos" data-toggle="collapse" data-target="#hazard-photos" aria-expanded="true" aria-controls="hazard-photos">
							Hazard Photos
							<svg xmlns="http://www.w3.org/2000/svg" width="17.184" height="9.666" viewBox="0 0 17.184 9.666">
								<path id="Path_8" data-name="Path 8" d="M93.167,180.018a1.074,1.074,0,0,0,1.519,0L102.2,172.5a1.074,1.074,0,1,0-1.519-1.519l-6.759,6.759-6.759-6.759a1.074,1.074,0,0,0-1.519,1.519Z" transform="translate(-85.334 -170.667)" fill="#2a5f9d"/>
							</svg>
						</button>
						<div id="hazard-photos" class="collapse" aria-labelledby="HeadingHazardPhotos">
							<div class="card-body">
								<table class="table table-striped" id="tbl-hazardphoto">
									<thead>
										<tr>
											<th>Item</th>
											<th>Image</th>
											<th>Description</th>
											<th>Support Needed</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($photoList as $photo){ ?>
										<tr>
											<td><?php echo $photo->name; ?></td>
											<td>
												<div class="galleryWrapper">
													<div class="imageContainer clearfix">
														<?php if(!is_null($photo->image1)){ ?>
														<a href="data:image/jpeg;base64,<?php echo base64_encode($photo->image1); ?>" class="imageLink" title="">
															<img src="data:image/jpeg;base64,<?php echo base64_encode($photo->image1); ?>" align="">
														</a>
														<?php } ?>

														<?php if(!is_null($photo->image2)){ ?>
														<a href="data:image/jpeg;base64,<?php echo base64_encode($photo->image2); ?>" class="imageLink" title="">
															<img src="data:image/jpeg;base64,<?php echo base64_encode($photo->image2); ?>" align="">
														</a>
														<?php } ?>

														<?php if(!is_null($photo->image3)){ ?>
														<a href="data:image/jpeg;base64,<?php echo base64_encode($photo->image3); ?>" class="imageLink" title="">
															<img src="data:image/jpeg;base64,<?php echo base64_encode($photo->image3); ?>" align="">
														</a>
														<?php } ?>
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
											<td><textarea class="form-control" rows="4" readonly><?php echo $photo->description; ?></textarea></td>
											<td><p><?php echo $photo->action; ?></p></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<button class="btn btn-primary my-3" id="btn-send">Send to Server Now</button>
				<button class="btn btn-primary my-3" id="btn-pdf">Generate PDF</button>
				<button class="btn btn-primary my-3" id="btn-export">Export to Excel</button>
			</div>
		</div>
	</div>
</div>
<?php include 'footer.php'; ?>

<script type="text/javascript">	
	$(function(){
		$('#tbl-hazard, #tbl-capacity, #tbl-hazardphoto').DataTable();	

		$('#checklist-activity-date').on('change', function (e) {
			$('#frm-report-cad').submit();
		});

		$('#btn-pdf').click(function(){
			var cad = $('#checklist-activity-date').val();

			if (cad > 0) {
				var win = window.open('reportSendToServer/generatePdf/'+cad, '_blank');
				if (win) {
					//Browser has allowed it to be opened
					win.focus();
				} else {
					//Browser has blocked it
					alert('Please allow popups for this web app.');
				}
			} else {
				alert("Checklist Date required.");
			}
		});

		$('#btn-send').click(function() {
			var cadId = $('#checklist-activity-date').val();

			if(cadId > 0){
				if(confirm("Are you sure you want to transmit data from the selected checklist date?")){
					clearTable();

					$.ajax({
						type:'POST',
						url:'reportSendToServer/sendToCOServer',
						data:{cadid:cadId},
						dataType:'json',
						success:function(data){
							$('#msg-prompt-div').addClass("alert-success show");
		                    $('#msg-prompt').html("Successfully sent record/s to central office server.");
							setTimeout(
								function(){
									window.location.href = 'reportSendToServer';
								},
								1500
							);	
						},
						error:function(data){		
		                    $('#msg-prompt-div').addClass("alert-danger show");
		                    $('#msg-prompt').html(data.responseText);
		                    console.log(data);
							setTimeout(
								function(){
									window.location.href = 'reportSendToServer';
								},
								2000
							);
						}
					});	
				}
			}else{
				alert("Checklist Date required.");
			}
		});

		$('#btn-export').click(function() {
			var cadId = $('#checklist-activity-date').val();

			if(cadId > 0){
				if(confirm("Are you sure you want to export data to excel?")){
					$('#frm-report-cad').attr('action', 'reportSendToServer/export');
					$('#frm-report-cad').submit();	
					$('#frm-report-cad').attr('action', 'reportSendToServer');
				}
			}else{
				alert("Checklist Date required.");
			}
		});
	});

	function clearTable(){
		$("#tbl-hazard tbody").empty();
		$("#tbl-capacity tbody").empty();
		$("#tbl-hazardphoto tbody").empty();

		$("#tbl-hazard").dataTable().fnClearTable();
		$("#tbl-capacity").dataTable().fnClearTable();
		$("#tbl-hazardphoto").dataTable().fnClearTable();
	}
</script>	
