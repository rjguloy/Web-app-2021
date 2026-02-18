<?php include 'head.php'; ?>
<?php include 'header.php'; ?>
<div class="wrapper d-flex align-items-stretch" id="wrapper">
	<?php include 'nav.php'; ?>
	<div class="page-content-wrapper mb-0">
		<div class="container-fluid">
			<div class="col-lg-12">
				<div class="page-title pb-2">
					<h3>Reports - School Head Narrative</h3>
				</div>
				<div class="alert success-msg" role="alert" id="msg-prompt-div">
				  <p id="msg-prompt">Successfully updated narrative.</p>
				</div>
				<div class="row mt-3">
					<div class="col-lg-4 mb-3">
						<div class="input-group mb-1">
							<div class="input-group-prepend">
								<label class="input-group-text" for="checklist-activity-date">Checklist Date</label>
							</div>
							<select class="custom-select" id="checklist-activity-date">
								<option value="0" selected>Please select date</option>
								<?php foreach($dates as $date){ ?>
									<option value="<?php echo $date->id; ?>"><?php echo $date->date; ?></option>
								<?php } ?>
							</select>
						</div>
						<div id="narrative-cad-error-msg-div" class="error-msg">
							<p id="narrative-cad-error-msg">Required.</p>
						</div>
					</div>
				</div>
				<div id="wrapper">
					<div class="form-group mb-1">
						<label for="reports-school-head-narrative">School Head Narrative</label>
						<textarea class="form-control" id="reports-school-head-narrative" rows="6" style="max-width:700px;"></textarea>
						<div id="narrative-error-msg-div" class="error-msg" style="max-width:700px;">
							<p id="narrative-error-msg">Required.</p>
						</div>
					</div>
					<button type="submit" class="btn btn-submit mt-3" id="save-narrative-btn">Save</button>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'footer.php'; ?>

<script type="text/javascript">	
	$(function(){
		$('#checklist-activity-date').on('change', function (e) {
			e.preventDefault();
			clearMessages();
			clearForm();

		    $.ajax({
				type:'POST',
				url:'reportNarrative/getNarrative',
				data:{id:this.value},
				dataType:'json',
				success:function(data){
					$('#reports-school-head-narrative').val(data);
				},
				error:function(data){
					$('#reports-school-head-narrative').val('');
				}
			});	
		});

		$('#save-narrative-btn').click(function (e) {
			var narrative = $.trim($('#reports-school-head-narrative').val());
			var cadId = $.trim($('#checklist-activity-date').val());
			var err = 0;

			clearMessages();

			if(narrative==""){
				err = 1;
				$('#narrative-error-msg-div').addClass("show");
			}

			if(cadId==0){
				err = 1;
				$('#narrative-cad-error-msg-div').addClass("show");
			}

			if(err==0){
			    $.ajax({
					type:'POST',
					url:'reportNarrative/save',
					data:{checklistDateId:cadId, narrative:narrative},
					dataType:'json',
					success:function(data){
						$('#msg-prompt-div').addClass("show");

						setTimeout(
							function(){
								window.location.reload(false);
							},
							1500
						);	
					},
					error:function(data){
						alert(data.responseText);
					}
				});	
			}
		});
	});

	function clearForm(){
		$('#reports-school-head-narrative').val('');
	}

	function clearMessages(){
		$('#msg-prompt-div').removeClass("show");
		$('#narrative-error-msg-div').removeClass("show");
		$('#narrative-cad-error-msg-div').removeClass("show");
	}
</script>