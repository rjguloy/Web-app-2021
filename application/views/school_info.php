<?php include 'head.php'; ?>
<?php include 'header.php'; ?>
<div class="wrapper d-flex align-items-stretch" id="wrapper">
	<?php include 'nav.php'; ?>
	<div class="page-content-wrapper mb-0"> <!-- All content of the page must be inside this div -->
		<div class="container-fluid">
			<div class="col-lg-12">
				<div class="page-title pb-2">
					<h3>School Information Settings</h3>
				</div>
		          <div class="alert alert-success" role="alert">
		            <p id="msg-prompt-success"><?php echo $this->session->flashdata('msg')?></p>
		          </div>
		          <div class="alert alert-warning" role="alert">
		            <p id="msg-prompt-warning"><?php echo $this->session->flashdata('msg')?></p>
		          </div>
		            <div class="alert alert-danger" role="alert">
		              <p id="msg-prompt-error"><?php echo $this->session->flashdata('msg')?></p>
		            </div>
		        
				<form method="post" id="school-info-settings" class="container">
					<div class="input-group my-3">
						<div class="input-group-prepend">
							<span class="input-group-text" id="school-id">School ID</span>
						</div>
						<input type="text" class="form-control" aria-label="Default" aria-describedby="school-id" 
						id="schoolid" name="schoolid" value="<?php echo $info ? $info['id'] : '' ?>"<?php echo isset($info['id']) ? 'readonly' : '' ?>>
					</div>
					<div class="input-group my-3">
						<div class="input-group-prepend">
							<span class="input-group-text" id="school-name">School Name</span>
						</div>
						<input type="text" class="form-control" aria-label="Default" aria-describedby="school-name" 
						id="schoolname" name="schoolname" value="<?php echo $info ? $info['name'] : '' ?>">
						<div id="name-error-msg-div" class="error-msg w-100 px-3">
							<p id="name-error-msg">Required.</p>
						</div>
					</div>

					<div class="input-group my-3">
						<div class="input-group-prepend">
							<span class="input-group-text" id="school-approver">School Approver</span>
						</div>
						<input type="text" class="form-control" aria-label="Default" aria-describedby="school-approver"
						id="approver" name="approver" value="<?php echo $info ? $info['approver'] : '' ?>">
						<div id="approver-error-msg-div" class="error-msg w-100 px-3">
							<p id="approver-error-msg">Required.</p>
						</div>
					</div>
					<div class="input-group my-3">
						<div class="input-group-prepend">
							<span class="input-group-text" id="school-reviewer">School Reviewer</span>
						</div>
						<input type="text" class="form-control" aria-label="Default" aria-describedby="school-reviewer" 
						id="reviewer" name="reviewer" value="<?php echo $info ? $info['reviewer'] : '' ?>">
						<div id="reviewer-error-msg-div" class="error-msg w-100 px-3">
							<p id="reviewer-error-msg">Required.</p>
						</div>
					</div>
					<div class="input-group my-3">
						<div class="input-group-prepend">
							<span class="input-group-text" id="school-ip">School IP Address</span>
						</div>
						<input type="text" class="form-control" aria-label="Default" aria-describedby="school-reviewer" 
						id="ipAddress" name="ipAddress" value="<?php echo $ip ?>" readonly>
					</div>

					<button type="submit" class="btn btn-add d-block m-auto px-5">Save</button>
				</form>
			</div>
		</div>
	</div>
</div>
<?php include 'footer.php'; ?>

<script>
	$(document).ready(function(e) {
		
		$('#school-info-settings').submit(function(e){
			e.preventDefault();

			var name = $('#schoolname').val();
			var approver = $('#approver').val();
			var reviewer = $('#reviewer').val();

			$("#name-error-msg").html("");
			$("#name-error-msg-div").removeClass("d-block");
			$("#approver-error-msg").html("");
			$("#approver-error-msg-div").removeClass("d-block");
			$("#reviewer-error-msg").html("");
			$("#reviewer-error-msg-div").removeClass("d-block");

			if (name == '' || approver == '' || reviewer == '') {
				if (name == '') {
					$("#name-error-msg").html("Required.");
					$("#name-error-msg-div").addClass("d-block");
				}
				if (approver == '') {
					$("#approver-error-msg").html("Required.");
					$("#approver-error-msg-div").addClass("d-block");
				}
				if (reviewer == '') {
					$("#reviewer-error-msg").html("Required.");
					$("#reviewer-error-msg-div").addClass("d-block");
				}

				return false;
			}
			
			$.ajax({
				type:     'POST',
				url:      'schoolinfo/save',
				data:     $(this).serialize(),
				dataType: 'json',
				success:  function(data) {
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
					function(){
						$('#msg-prompt-warning')
						.parent().removeClass("show");
						$('#msg-prompt-danger')
						.parent().removeClass("show")
						$('#msg-prompt-success')
						.parent().removeClass("show")
					},
					1500
					);  
				},
				error:function(data){
					console.log(data.responseText);
				}
			});
		});
	});
</script>