<?php include 'head.php'; ?>
<?php include 'header.php'; ?>
<div class="wrapper d-flex align-items-stretch" id="wrapper">
	<?php include 'nav.php'; ?>
	<div class="page-content-wrapper mb-0"> <!-- All content of the page must be inside this div -->
		<div class="container-fluid">
			<div class="col-lg-12">
				<div class="page-title pb-2">
					<h3>Comparative Data</h3>
				</div>
				<div class="accordion my-4" id="checklist-tables">
					<div class="card">
						<button class="card-header text-left font-weight-bold border-0 collapsed" id="heading-hazards" data-toggle="collapse" data-target="#hazards" aria-expanded="false" aria-controls="hazards">
							Hazards
							<svg xmlns="http://www.w3.org/2000/svg" width="17.184" height="9.666" viewBox="0 0 17.184 9.666">
							  <path id="Path_8" data-name="Path 8" d="M93.167,180.018a1.074,1.074,0,0,0,1.519,0L102.2,172.5a1.074,1.074,0,1,0-1.519-1.519l-6.759,6.759-6.759-6.759a1.074,1.074,0,0,0-1.519,1.519Z" transform="translate(-85.334 -170.667)" fill="#2a5f9d"/>
							</svg>
						</button>
						<div id="hazards" class="collapse" aria-labelledby="heading-hazards">
							<div class="card-body">
								<table class="table table-striped" id="hazards-table" width="100%">
									<thead>
										<tr>
											<th scope="col" rowspan="2" class="align-middle">No.</th>
											<th scope="col" rowspan="2" class="align-middle">Item</th>
											<th scope="col" colspan="5" class="text-center">Checklist Activity Dates</th>
											<tr>
												<?php foreach ($cad as $date){ ?>
													<th class="text-center" scope="col"><?php echo $date->date; ?></th>
												<?php } ?>
											</tr>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($list as $i=>$hazard){ 
												if($hazard->type=="HAZARD"){?>
												<tr>
													<td><?php echo ++$i; ?></td>
													<td class="item"><?php echo $hazard->name; ?></td>
													<?php if(count($cad) > 2){ ?> <td class="item text-center"><?php echo $hazard->firstdate; ?></td> <?php } ?>
													<?php if(count($cad) > 1){ ?> <td class="item text-center"><?php echo $hazard->seconddate; ?></td> <?php } ?>
													<?php if(count($cad) > 0){ ?> <td class="item text-center"><?php echo $hazard->thirddate; ?></td> <?php } ?>
												</tr>
										<?php }} ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="card">
						<button class="card-header text-left font-weight-bold border-0 collapsed" id="heading-capacity" data-toggle="collapse" data-target="#capacity" aria-expanded="false" aria-controls="capacity">
							Capacity
							<svg xmlns="http://www.w3.org/2000/svg" width="17.184" height="9.666" viewBox="0 0 17.184 9.666">
							  <path id="Path_8" data-name="Path 8" d="M93.167,180.018a1.074,1.074,0,0,0,1.519,0L102.2,172.5a1.074,1.074,0,1,0-1.519-1.519l-6.759,6.759-6.759-6.759a1.074,1.074,0,0,0-1.519,1.519Z" transform="translate(-85.334 -170.667)" fill="#2a5f9d"/>
							</svg>
						</button>
						<div id="capacity" class="collapse" aria-labelledby="heading-capacity">
							<div class="card-body">
								<table class="table table-striped" id="capacity-table" width="100%">
									<thead>
										<tr>
											<th scope="col" rowspan="2" class="align-middle">No.</th>
											<th scope="col" rowspan="2" class="align-middle">Item</th>
											<th scope="col" colspan="5" class="text-center">Checklist Activity Dates</th>
											<tr>
												<?php foreach ($cad as $date){ ?>
													<th class="text-center" scope="col"><?php echo $date->date; ?></th>
												<?php } ?>
											</tr>
										</tr>
									</thead>
									<tbody>
										<?php
											$i = 0;
											foreach ($list as $hazard){ 
												if($hazard->type=="CAPACITY"){?>
												<tr>
													<td><?php echo ++$i; ?></td>
													<td class="item"><?php echo $hazard->name; ?></td>
													<?php if(count($cad) > 2){ ?> <td class="item text-center"><?php echo $hazard->firstdate; ?></td> <?php } ?>
													<?php if(count($cad) > 1){ ?> <td class="item text-center"><?php echo $hazard->seconddate; ?></td> <?php } ?>
													<?php if(count($cad) > 0){ ?> <td class="item text-center"><?php echo $hazard->thirddate; ?></td> <?php } ?>
												</tr>
										<?php }} ?>
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
	$(document).ready(function() {
	    $('#hazards-table,#capacity-table').DataTable();
	} );	
</script>
