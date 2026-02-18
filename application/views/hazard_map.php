<?php include 'head.php'; ?>
<?php include 'header.php'; ?>
<div class="wrapper d-flex align-items-stretch" id="wrapper">
	<?php include 'nav.php'; ?>
	<div class="page-content-wrapper mb-0"> <!-- All content of the page must be inside this div -->
		<div class="container-fluid">
			<div class="col-lg-12">
				<div class="page-title pb-2">
					<h3>Hazard Map</h3>
				</div>
				<div class="input-group p-3" style="max-width: 527px;">
					<div class="input-group-prepend">
						<label class="input-group-text" for="hazard-map-location">Location</label>
					</div>
        			<form method="POST" action="hazardMap" id="form-event">
						<select class="custom-select" name="locationId" id="hazard-map-location">
							<option value="0" selected>Please select location</option>
							<?php foreach($locationList as $location){ ?>
								<option value="<?php echo $location->id; ?>" <?php echo ($locationId == $location->id) ? "selected=''": ""; ?> ><?php echo $location->name; ?></option>
							<?php } ?>
						</select>
					</form>
				</div>
				<div class="accordion">
					<div class="card">
						<button class="card-header text-left font-weight-bold border-0 collapsed" id="HeadingMapTemp" data-toggle="collapse" data-target="#map-template" aria-expanded="false" aria-controls="map-template">
							Building Map Template
							<svg xmlns="http://www.w3.org/2000/svg" width="17.184" height="9.666" viewBox="0 0 17.184 9.666">
							  <path id="Path_8" data-name="Path 8" d="M93.167,180.018a1.074,1.074,0,0,0,1.519,0L102.2,172.5a1.074,1.074,0,1,0-1.519-1.519l-6.759,6.759-6.759-6.759a1.074,1.074,0,0,0-1.519,1.519Z" transform="translate(-85.334 -170.667)" fill="#2a5f9d"/>
							</svg>
						</button>
						<div id="map-template" class="collapse" aria-labelledby="HeadingMapTemp">
							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<div class="imgContainer clearfix" id="div-location-template">	
											<?php if($hasTemplate){ ?>										
											<a href="hm_output/image/template/<?php echo $locationId; ?>.jpg" class="imageLink" title="">
												<img src="hm_output/image/template/<?php echo $locationId; ?>.jpg" class="img-responsive" align="">
											</a>
											<?php }else{?>	
											<i>NO TEMPLATE AVAILABLE</i>							
											<?php } ?>										
										</div>
										<!-- <div class="overlayContainer">
											<div class="imageBox">
												<div class="relativeContainer">
													<img class="largeImage" src="" alt="">
													<p class="imageCaption"></p>
												</div>
											</div>
										</div> -->
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card">
						<button class="card-header text-left font-weight-bold border-0 collapsed" id="HeadingHazardMap" data-toggle="collapse" data-target="#build-map" aria-expanded="false" aria-controls="build-map">
							Building Hazard Map
							<svg xmlns="http://www.w3.org/2000/svg" width="17.184" height="9.666" viewBox="0 0 17.184 9.666">
							  <path id="Path_8" data-name="Path 8" d="M93.167,180.018a1.074,1.074,0,0,0,1.519,0L102.2,172.5a1.074,1.074,0,1,0-1.519-1.519l-6.759,6.759-6.759-6.759a1.074,1.074,0,0,0-1.519,1.519Z" transform="translate(-85.334 -170.667)" fill="#2a5f9d"/>
							</svg>
						</button>
						<div id="build-map" class="collapse" aria-labelledby="HeadingHazardMap">
							<div class="card-body">
								<table class="table table-striped" id="tbl-hazard-map">
									<thead>
										<tr>
											<th>Checklist Activity Date</th>
											<th>Image</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($hazardMaps as $hm){ ?>
										<tr>
											<td><?php echo $hm['date']; ?></td>
											<td>
												<div class="galleryWrapper">
													<div class="imageContainer clearfix">
														<a href="<?php echo $hm['fileName']; ?>" class="imageLink" title="">
															<img src="<?php echo $hm['fileName']; ?>" align="">
														</a>
													</div>
													<!-- <div class="overlayContainer">
														<div class="imageBox">
															<div class="relativeContainer">
																<img class="largeImage" src="" alt="">
																<p class="imageCaption"></p>
															</div>
														</div>
													</div> -->
												</div>
											</td>
										</tr>
										<?php }?>
									</tbody>
								</table>
							</div>
						</div>
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
			</div>
		</div>
	</div>
</div>	
<?php include 'footer.php'; ?>


<script type="text/javascript">	
	$(function(){
		$('#tbl-hazard-map').DataTable();

		$('#hazard-map-location').on('change', function (e) {
			$('#form-event').submit();
		});
	});
</script>	