<?php include 'head.php'; ?>
<?php include 'header.php'; ?>

<div class="wrapper d-flex align-items-stretch" id="wrapper">
	<?php include 'nav.php'; ?>
	<div class="page-content-wrapper mb-0"> <!-- All content of the page must be inside this div -->
		<div class="container-fluid">
			<div class="col-lg-12">
				<div class="page-title pb-2">
					<h3>User Accounts</h3>
				</div>
				<div class="alert" role="alert" id="msg-prompt-div">
				  <p id="msg-prompt"></p>
				</div>
				<!-- <div class="wrapper my-4">
					<input type="text" class="form-control d-inline-block" id="search-location">
					<button type="button" class="btn btn-add align-bottom py-1 mt-3 mt-md-0" id="search-account">Search Account</button>
				</div> -->
				<div class="user-accounts mt-3">
					<!-- <h4 class="mb-2">Accounts</h4> -->
					<table class="table table-striped" id="user-table">
						<thead>
							<tr>
								<th>Username</th>
								<th>Name</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($users as $user){ ?>
								<tr>
									<td><?php echo $user->username; ?></td>
									<td><?php echo $user->name; ?></td>
									<td><?php echo $user->status; ?></td>
									<td>
										<?php if(is_null($user->validationdate)){ ?>
											<button type="button" class="btn btn-submit py-0" id="<?php echo $user->seqid; ?>" name="appBtn" data-toggle="tooltip" title="Approve">
												<img src="./assets/images/icons/correct.svg">
											</button>
										<?php } ?>
											<button type="button" class="btn btn-delete py-0" id="<?php echo $user->seqid; ?>" name="delBtn" data-toggle="tooltip" title="Delete">
												<img src="./assets/images/icons/delete.svg">
											</button>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'footer.php'; ?>

<script type="text/javascript">
	$('#user-table').DataTable();
	
	$("button[name='appBtn']").click(function() {
		if(confirm("Are you sure you want to activate this user?")){
			$.ajax({
				type:'POST',
				url:'user/approve',
				data:{id:this.id},
				dataType:'json',
				success:function(data){ 		
                    $('#msg-prompt-div').addClass("alert-success show");
                    $('#msg-prompt').html("Successfully activated user.");
					setTimeout(
						function(){
							window.location.reload(false);
						},
						1500
					);	
				},
				error:function(data){ 		
                    $('#msg-prompt-div').addClass("alert-danger show");
                    $('#msg-prompt').html(data.responseText);
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


	$("button[name='delBtn']").click(function() {
		if(confirm("Are you sure you want to delete this user?")){
			$.ajax({
				type:'POST',
				url:'user/delete',
				data:{id:this.id},
				dataType:'json',
				success:function(data){ 		
                    $('#msg-prompt-div').addClass("alert-success show");
                    $('#msg-prompt').html("Successfully deleted user.");
					setTimeout(
						function(){
							window.location.reload(true);
						},
						1500
					);
				},
				error:function(data){ 		
                    $('#msg-prompt-div').addClass("alert-danger show");
                    $('#msg-prompt').html(data.responseText);
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
</script>