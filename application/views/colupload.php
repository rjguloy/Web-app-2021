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
						<h3>Import School Data</h3>
					</div>
					<div class="alert" role="alert" id="msg-prompt-div">
					  <p id="msg-prompt"></p>
					</div>
					<form enctype="multipart/form-data" id="frm-import" class="container">
						<div class="input-group my-3">
							<div class="input-group-prepend">
								<span class="input-group-text" for="upload_file">File Upload</span>
							</div>
							<input type="file" name="upload_file" class="form-control" id="upload_file">
							<button type="button" class="btn btn-primary ml-3" id="btn-import">Import Data</button>
						</div>
						<input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'footer.php'; ?>

<script type="text/javascript">
	$(function(){
		$('#btn-import').click(function() {
			if(confirm("Are you sure you want to import data from the uploaded file?")){
				$('#tint').css('display', 'block');
				$('#frm-import').submit();
			}
		});	

		$("#frm-import").on('submit', function(e){
		    e.preventDefault();

			$.ajax({
				type:'POST',
				url:'colUpload/import',
				data: new FormData(this),
				dataType:'json',
	            contentType: false,
	            cache: false,
	            processData:false,
				success:function(data){
					$('#msg-prompt-div').addClass("alert-success show");
                    $('#msg-prompt').html("Successfully inserted data.");
                    $('#tint').css('display', 'none');
					setTimeout(
						function(){
							window.location.href = 'colUpload';
						},
						1500
					);	
				},
				error:function(data){
                    $('#msg-prompt-div').addClass("alert-danger show");
                    $('#msg-prompt').html(data.responseText);
                    $('#tint').css('display', 'none');
                    console.log(data);
					setTimeout(
						function(){
							window.location.href = 'colUpload';
						},
						2000
					);
				}
			});
		});
	});
</script>