<?php
$roleCheck = function($roles) {

	if ( ! is_array($roles)) {
		if ($roles == $this->session->role) return true;
		return false;
	}

	foreach ($roles as $role) {
		if ($role == $this->session->role) return true;
	}

	return false;
};
?>
<?php include 'head.php'; ?>
<?php include 'header.php'; ?>
<div id="tint" style="z-index:1000; display:none; position:fixed; height:100%; width:100%; text-align:center; background-color:rgba(0, 0, 0, .50);">
	<div id="preloader" style="margin:300px auto 0px; background-color:#FFFFFF; position:relative; display:inline-block; border-radius:10px;">
		<img src="assets/images/preloader01.gif" style="padding:50px; position:relative; display:inline-block" />
	</div>
</div>
<div class="wrapper d-flex align-items-stretch" id="wrapper">
	<?php include 'nav.php'; ?>
	<div class="page-content-wrapper mb-0">
		<div class="container-fluid">
			<div class="col-lg-12">
				<div class="col-chart">
				<div class="page-title pb-2">
					<h3 >Dashboard</h3>
				</div>
				<div class="col-lg mt-3">
					<form action="colReports" id="frm-col-report" method="GET">
						<div class="filters colreports row">
							<?php //if ($this->session->fname || $this->session->lname) : ?>
							<!-- <p>User: <?php //echo ucfirst($this->session->fname . ' ' . $this->session->lname) ?></p>
							<p>Role : <?php // echo $this->session->role ?></p> -->
							<?php //endif ?>
							<input type="hidden" id="userRole" value="<?php echo $this->session->role ?>" />
							<div class="form-group mb-0 mr-2">
								<select id="reports-year" name="reports-year" class="form-control">
									<option value="0">All Years</option>
									<?php foreach ($years as $row) : ?>
										<option value="<?php echo $row->year?>"<?php echo $row->year == date('Y') ? ' selected' : ''?>>
											<?php echo $row->year ?>
										</option>
									<?php endforeach ?>
								</select>
							</div>
							<div class="form-group mb-0 mr-2">
								<select id="reports-item" name="reports-item" class="form-control">
									<option value="0">All Hazard Items</option>
									<?php foreach ($items as $row) : ?>
										<option value="<?php echo $row->id?>">
											<?php echo $row->name ?>
										</option>
									<?php endforeach ?>
								</select>
							</div>
							<div class="form-group mb-0 mr-2">
								<select id="reports-region" name="reports-region" class="form-control"<?php echo ! $roleCheck('SUPERADMIN') ? ' disabled' : ''?>>
									<option value="0">All Regions</option>
									<?php foreach ($regions as $row) : ?>
										<?php if ( ! $roleCheck('SUPERADMIN') && $this->session->regionID != $row['id']) continue; ?>
										<option value="<?php echo $row['id']?>"<?php echo $this->session->regionID == $row['id'] ? ' selected' : ''?>>
											<?php echo $row['name'] ?>
										</option>
									<?php endforeach ?>
								</select>
								<input type="hidden" name="sel-region" id="sel-region" />
							</div>
							<div class="form-group mb-0 mr-2">
								<select id="reports-division" name="reports-division" class="form-control"<?php echo ! $roleCheck(['SUPERADMIN', 'REGIONCOORD']) ? ' disabled' : ''?>>
									<option value="0">All Divisions</option>
									<?php if (isset($divisions) && is_array($divisions)) : ?>
										<?php foreach ($divisions as $row) : ?>
											<option value="<?php echo $row['id']?>"<?php echo $this->session->divisionID == $row['id'] ? ' selected' : ''?>>
												<?php echo $row['name'] ?>
											</option>
										<?php endforeach ?>
									<?php endif ?>
								</select>
								<input type="hidden" name="sel-division" id="sel-division" />
							</div>
							<div class="form-group mb-0 mr-2">
							<select id="reports-school" name="reports-school" class="form-control"<?php echo ! $roleCheck(['SUPERADMIN', 'REGIONCOORD', 'DIVISIONCOORD']) ? ' disabled' : ''?>>
								<option value="0">All Schools</option>
								<?php if (isset($schools) && is_array($schools)) : ?>
									<?php foreach ($schools as $row) : ?>
										<option value="<?php echo $row['id']?>"<?php echo $this->session->schoolID == $row['id'] ? ' selected' : ''?>>
											<?php echo $row['name'] ?>
										</option>
									<?php endforeach ?>
								<?php endif ?>
								</select>
								<input type="hidden" name="sel-school" id="sel-school" />
							</div>
							<div class="form-group mb-0 mr-2">
								<select id="reports-date" name="reports-date" class="form-control"<?php echo ! $roleCheck('SCHOOLCOORD') ? ' disabled' : ''?>>
									<option value="0">All Dates</option>
									<?php if (isset($dates) && is_array($dates)) : ?>
										<?php foreach ($dates as $row) : ?>
											<option value="<?php echo $row->id?>">
												<?php echo $row->name ?>
											</option>
										<?php endforeach ?>
									<?php endif ?>
								</select>
								<input type="hidden" name="sel-cad" id="sel-cad" />
							</div>
							<a onclick="window.location.reload()" style="cursor:pointer" class="btn btn-primary ml-2">
								<img src="assets/images/icons/refresh.svg" 
								alt="Refresh" style="vertical-align: sub;">
							</a>

							<!-- <a href="#" class="btn btn-primary ml-auto">
								<img src="assets/images/icons/view-report.svg" alt="View Report" class="mr-1" style="vertical-align: sub;">View Report
							</a> -->
							<a href="#" class="btn btn-primary ml-auto" id="btn-export">
								<img src="assets/images/icons/export.svg" alt="Export" class="mr-1" style="vertical-align: sub;">Export Report
							</a>
						</div>
					</form>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-6 mt-3 mb-5" style="overflow: hidden;">
						<h3 class="mb-5">Submissions</h3>
						<ul class="legend row p-0 mb-5">
							<li class="col d-flex submitted text-white">
								<p>Submitted<br><span id="total-submit" class="count h2">0</span></p>
								<img src="assets/images/icons/mail.svg" alt="Mail icon" class="mailIcons ml-auto" width="42px">
							</li>
							<li class="col d-flex not-submitted text-white">
								<p>Not Submitted<br><span id="total-not-submit" class="count h2">0</span></p>
								<img src="assets/images/icons/mail_2.svg" alt="Mail icon" class="mailIcons ml-auto" width="42px">
							</li>
						</ul>
						<div id="bar1" style="height: 450px; width: 100%;"></div>
						<div class="cover" style="bottom: 5px;"></div>
					</div>
					<div class="col-lg-6 mt-3 mb-5">
						<h3 class="mb-5">Overall Reported Hazards</h3>
						<ul class="legend row p-0 mb-5">
							<li class="col d-flex hazard text-white">
								<p>Hazard<br><span id="total-hazard" class="count h2">0</span></p>
								<img src="assets/images/icons/caution.svg" alt="Caution icon" class="mailIcons ml-auto" width="42px">
							</li>
							<li class="col d-flex capacity text-white">
								<p>Capacity<br><span id="total-capacity" class="count h2">0</span></p>
								<img src="assets/images/icons/spirometer.svg" alt="Spirometer icon" class="mailIcons ml-auto" width="42px">
							</li>
							<li class="col d-flex others text-white">
								<p>Others<br><span id="total-additional" class="count h2">0</span></p>
								<img src="assets/images/icons/broken.svg" alt="Broken icon" class="mailIcons ml-auto" width="42px">
							</li>
						</ul>
						<h4 class="mb-3 h6">Top 10 Reported Hazards</h4>
						<canvas id="pie"></canvas>
					</div>
					<div class="col-lg-12">
						<h3 class="mb-5">Reported Hazard Per Status</h3>
						<div id="bar2" class="mb-5" style="height: 550px; width: 100%;"></div>
						<div class="cover" style="bottom: 0;"></div>
					</div>
					<div class="col-lg-12">
						<h3 class="mb-5">Reported Hazard Per Hazard Type</h3>
						<div id="bar3" class="mb-5" style="height: 550px; width: 100%;"></div>
						<div class="cover" style="bottom: 0;"></div>
					</div>
				</div>
			</div>
				<h3 class="mb-5">Report Details</h3>
                <div class="accordion" id="reports-summary">
					<div class="card">
					<button class="card-header collapsed text-left font-weight-bold border-0" id="HeadingHazard" 
						data-toggle="collapse" data-target="#hazard" aria-expanded="true" aria-controls="hazard">
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
											<th>Region</th>
											<th>Division</th>
											<th>School</th>
											<th>Checklist Date</th>
											<th>Item</th>
                                            <th>Hazard Count</th>
											<th>Hazard Type</th>
                                            <th>Timeframe</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<!--Insert records here-->
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="card">
					<button class="card-header collapsed text-left font-weight-bold border-0" id="HeadingCapacity" 
						data-toggle="collapse" data-target="#capacity" aria-expanded="true" aria-controls="capacity">
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
										<th>Region</th>
											<th>Division</th>
											<th>School</th>
											<th>Checklist Date</th>
											<th>Item</th>
                                            <th>Hazard Count</th>
											<th>Hazard Type</th>
                                            <th>Timeframe</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<!--Insert records here-->
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="card">
					<button class="card-header collapsed text-left font-weight-bold border-0" id="HeadingOthers" 
						data-toggle="collapse" data-target="#others" aria-expanded="true" aria-controls="others">
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
											<th>Region</th>
											<th>Division</th>
											<th>School</th>
											<th>Checklist Date</th>
											<th>Item</th>
                                            <th>Hazard Count</th>
											<th>Hazard Type</th>
                                            <th>Timeframe</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<!--Insert records here-->
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
	
	getEvents();
	
	$('#reports-year').on('change', function(e) {
		getEvents();
	});

	$('#reports-item').on('change', function(e) {
                
		var regionID = $('#reports-region').children("option:selected").val();
		var role = $('#userRole').val();

		if (role == 'SUPERADMIN') $('#reports-region').prop('disabled', false);

		if ($(this).val() === "") {

			//$('#reports-region').val('0');
			$('#reports-division').html('<option value="0">All Divisions</option>');
			$('#reports-school').html('<option value="0">All Schools</option>');
			$('#reports-date').html('<option value="">All Dates</option>');
			
			$('#reports-region').prop('disabled', true);
			$('#reports-division').prop('disabled', true);
			$('#reports-school').prop('disabled', true);
			$('#reports-date').prop('disabled', true);
		} 

		getEvents();

	});


    $(document).on('change', '#reports-region', function(e) {
        
        $('#reports-division').html('<option value="0">All Divisions</option>');
        $('#reports-school').html('<option value="0">All Schools</option>');
		$('#reports-date').html('<option value="0">All Dates</option>');

        var regionID 	= $(this).children("option:selected").val();

		$.ajax({
			type: 		'GET',
			url: 		'colReports/getDivisions',
			data: 		{ region_id:  regionID },
			dataType: 	'json',
			success: 	function(data) {
				
				$('#reports-division').prop('disabled', false);

				var buffer = '';
				$.each(data.divisions, function(index, val) {
					buffer += addOption(index, val);
				});

				if (regionID == 0) {
					$('#reports-division').prop('disabled', true);
					$('#reports-school').prop('disabled', true);
					$('#reports-date').prop('disabled', true);
				} 

				
                $('#reports-division').append(buffer);
                getEvents();
			},
			error: 		function(data) {
				alert(data.responseText);
			}
		});
    });


    $(document).on('change', '#reports-division', function(e) {
        
        $('#reports-school').html('<option value="0">All Schools</option>');
		$('#reports-date').html('<option value="0">All Dates</option>');

        var divID       = $(this).children("option:selected").val();

		$.ajax({
			type: 		'GET',
			url: 		'colReports/getSchools',
			data: 		{ division_id:    divID },
			dataType: 	'json',
			success: 	function(data) {
				
				$('#reports-school').prop('disabled', false);

				var buffer = '';
				$.each(data.schools, function(index, val) {
					buffer += addOption(index, val);
				});

				if (divID == 0) {
					$('#reports-school').prop('disabled', true);
					$('#reports-date').prop('disabled', true);
				}
				
                $('#reports-school').append(buffer);
                getEvents();
			},
			error: function(data) {
				alert(data.responseText);
			}
		});
    });


    $(document).on('change', '#reports-school', function(e) {

		$('#reports-date').html('<option value="0">All Dates</option>');

		var schoolID       = $(this).children("option:selected").val();

		$.ajax({
			type: 		'GET',
			url: 		'colReports/getDates',
			data: 		{ school_id:    schoolID },
			dataType: 	'json',
			success: 	function(data) {
				
				$('#reports-date').prop('disabled', false);

				var buffer = '';
				$.each(data.dates, function(index, val) {
					buffer += addOption(index, val);
				});
				
				if (schoolID == 0) {
					$('#reports-date').prop('disabled', true);
				}

				$('#reports-date').append(buffer);
				getEvents();
			},
			error: function(data) {
				alert(data.responseText);
			}
		});
	});


	$('#reports-date').on('change', function(e) {
        
        getEvents();

    });
    


    function getEvents() { 
		
		$('#tint').css('display', 'block');

		var year 		= $('#reports-year').val();
		var itemID 		= $('#reports-item').val();
		var regionID    = $('#reports-region').val();
        var divID       = $('#reports-division').val();
        var schoolID    = $('#reports-school').val();
		var dateID      = $('#reports-date').val();

		
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

		if (itemID === "") {
			$('#tint').css('display', 'none');
			return false;
		}

		$.ajax({
			type: 		'GET',
			url: 		'colReports/getEvents',
            data: 		{
							year_id: 		year,
                            item_id: 		itemID,
                            region_id:      regionID,
                            division_id:    divID,
                            school_id:      schoolID,
							date_id:        dateID,
                        },
			dataType: 	'json',
			success: 	function(data) {
				/* Submissions Count */			

				$('#total-submit').html(dataSum(data.submissions.school_submitted));
				$('#total-not-submit').html(dataSum(data.submissions.school_not_submitted));

				/* Overall Reported Hazard Count */

				$('#total-hazard').html(data.overallReportedHazard.hazard);
				$('#total-capacity').html(data.overallReportedHazard.capacity);
				$('#total-additional').html(data.overallReportedHazard.additional);
				
				/* Charts */
				getStats(data);

				/* Report Details */

				var buffer = '';
				$('#table-hazard tbody').html('');
				$.each(data.records, function(index, val) {
						if (val.type == 'HAZARD') 
							buffer += showRow(index, val);
				});
				$('#table-hazard tbody').append(buffer);

				buffer = '';
				$('#table-capacity tbody').html('');
				$.each(data.records, function(index, val) {
						if (val.type == 'CAPACITY') 
							buffer += showRow(index, val);
				});
				$('#table-capacity tbody').append(buffer);
				
				buffer = '';
				$('#table-others tbody').html('');		
				$.each(data.records, function(index, val) {
						if (val.type == 'ADDITIONAL') 
							buffer += showRow(index, val);
				});				
				$('#table-others tbody').append(buffer);

				$('#table-hazard,#table-capacity,#table-others').DataTable();

				$('#tint').css('display', 'none');
			},
			error: 		function(data) {
				//console.log(data.responseText);
				$('#tint').css('display', 'none');
			}
		});
    }


    function addOption(index, record) {

        var x = '<option value="'+record.id+'">\
                    '+record.name+'\
                </option>';
        
        return x;
    }

	function showRow(index, record) {
		
		var x = '<tr>\
                    <td class="align-middle">'+
                    record.region_name +'</td>\
                    <td class="align-middle">'+
                    record.division_name +'</td>\
                    <td class="align-middle">'+
                    record.school_name +'</td>\
					<td class="align-middle">'+
                    record.date +'</td>\
                    <td class="align-middle">'+
					record.item+'</td>\
					<td class="align-middle">'+
                    record.item_count +'</td>\
					<td class="align-middle">'+
                    record.hazardtype_name  +'</td>\
                    <td class="align-middle">'+
                    record.timeline +'</td>\
                    <td class="align-middle">'+
                    record.hazardstatus_name +'</td>\
				</tr>';
		
		return x;
	}


	function dataSum(someArray) {
		
		if ( ! Array.isArray(someArray)) { return 0; }

		var total = 0;
		for (var i = 0; i < someArray.length; i++) {
			total += someArray[i] << 0;
		}

		return total;
	}
	
	
	function prepareData(lbls, dtls, clrs) {
		
		if ( ! Array.isArray(lbls)) { return 0; }

		var data_json = [];
		for (count = 0; count < lbls.length; count++) {
			data_json[count] = { "y": parseInt(dtls[count]), "label": lbls[count], "color": clrs };
		}

		return data_json;
	}

	function getStats(datas) {
		var role = $('#userRole').val();
		var color_cap = '#174882';
		var color_haz = '#FAAF3B';
		var color_add = '#BDC3C7';

		switch (datas.submissions.scope) {
			case 'super':
				var header = 'Regions'
				var labels = datas.submissions.loc_name;
				break;
			case 'region':
			case 'division':
			case 'school':
				var header = datas.submissions.scope_name;
				var labels = datas.submissions.loc_name;
				break;
		}

		/* Submissions */		
		var color_nsub = '#DE193A';
		var color_sub = '#1DA054';
		var jsonDataNSub = prepareData(labels, datas.submissions.school_not_submitted, color_nsub);	
		var jsonDataSub = prepareData(labels, datas.submissions.school_submitted, color_sub);	

		var options = {
			animationEnabled: true,
			title: {
				text: ""
			},
			axisX: {
				title: header,
				interval: 1
			},
			axisY: {
				title: "School Count",
				
			},
			toolTip: {
				shared: true,
				reversed: true
			},
			data: [{
				type: "stackedColumn",
				name: "Not Submitted",
				showInLegend: false,
				dataPoints: jsonDataNSub
				}, {
				type: "stackedColumn",
				name: "Submitted",
				showInLegend: false,
				dataPoints: jsonDataSub
			}]
		};

		$("#bar1").CanvasJSChart(options);

		/* Overall Reported Hazards */
		var ctx = $('#pie');
		
		if(window.bar != undefined){
			window.bar.destroy();
		}

		window.bar = new Chart(ctx, {
			type: 'pie',
			options: {
				title: {
					text: 'Top 10 Reported Hazard',
					display: false
				},
				legend: {
					position: 'right',
					display: true
				}
			},
			data: {
				labels: datas.hazardArray.name,
				datasets: [{
				data: datas.hazardArray.count,
				backgroundColor: ['#14A2FA', '#FA5025', '#78949F', '#F3CD36', '#3A6EFF', '#05D85C', '#0058A7', '#714B44', '#4B4B4B', '#916057']
				}]
			},
		});
		

		/* Reported Hazard Per Status */
		var jsonDataCapacity = prepareData(datas.hazardStatusArray.list, datas.hazardStatusArray.capacity, color_cap);	
		var jsonDataHazard = prepareData(datas.hazardStatusArray.list, datas.hazardStatusArray.hazard, color_haz);	
		var jsonDataAdditional = prepareData(datas.hazardStatusArray.list, datas.hazardStatusArray.additional, color_add);
		
		var options = {
			animationEnabled: true,
			title: {
			text: ""
			},
			legend: {
			horizontalAlign: "right",
			verticalAlign: "top"
			},
			axisX: {
			title: "Hazard Status",
			interval: 1
			},
			axisY: {
			title: "Count",
			interval: 2
			},
			toolTip: {
			shared: true,
			reversed: true
			},
			data: [{
			type: "stackedColumn",
			name: "Capacity",
			legendMarkerColor: color_cap,
			showInLegend: true,
			dataPoints: jsonDataCapacity
			}, {
			type: "stackedColumn",
			name: "Hazard",
			legendMarkerColor: color_haz,
			showInLegend: true,
			dataPoints: jsonDataHazard
			}, {
			type: "stackedColumn",
			name: "Others",
			legendMarkerColor: color_add,
			showInLegend: true,
			dataPoints: jsonDataAdditional
			}]
		};
		$("#bar2").CanvasJSChart(options);


		/* Reported Hazard Per Type */
		jsonDataCapacity = prepareData(datas.hazardTypeArray.list, datas.hazardTypeArray.capacity, color_cap);	
		jsonDataHazard = prepareData(datas.hazardTypeArray.list, datas.hazardTypeArray.hazard, color_haz);	
		jsonDataAdditional = prepareData(datas.hazardTypeArray.list, datas.hazardTypeArray.additional, color_add);
			
		options = {
			animationEnabled: true,
			title: {
			text: ""
			},
			legend: {
			horizontalAlign: "right",
			verticalAlign: "top"
			},
			axisX: {
			title: "Hazard Type",
			interval: 1
			},
			axisY: {
			title: "Count",
			interval: 2
			},
			toolTip: {
			shared: true,
			reversed: true
			},
			data: [{
			type: "stackedColumn",
			name: "Capacity",
			legendMarkerColor: color_cap,
			showInLegend: true,
			dataPoints: jsonDataCapacity
			}, {
			type: "stackedColumn",
			name: "Hazard",
			legendMarkerColor: color_haz,
			showInLegend: true,
			dataPoints: jsonDataHazard
			}, {
			type: "stackedColumn",
			name: "Others",
			legendMarkerColor: color_add,
			showInLegend: true,
			dataPoints: jsonDataAdditional
			}]
		};
		$("#bar3").CanvasJSChart(options);
	}

	$('#btn-export').click(function() {
		if(confirm("Are you sure you want to export data to excel?")){
			$('#sel-region').val($('#reports-region').val());
	        $('#sel-division').val($('#reports-division').val());
	        $('#sel-school').val($('#reports-school').val());
			$('#sel-cad').val($('#reports-date').val());

			$('#frm-col-report').attr('action', 'colReports/export');
			$('#frm-col-report').submit();	
			$('#frm-col-report').attr('action', 'colReports');
		}
	});
});

</script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>