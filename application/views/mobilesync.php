<?php include 'head.php'; ?>
<?php include 'header.php'; ?>
<div class="wrapper d-flex align-items-stretch" id="wrapper">
	<?php include 'nav.php'; ?>
	<div class="page-content-wrapper mb-0"> <!-- All content of the page must be inside this div -->
		<style>
			#progress {
				width: 500px;
				border: 1px solid #aaa;
				height: 20px;
			}
			#progress .bar {
				background-color: #ccc;
				height: 20px;
			}
 		 </style>
		<div class="container-fluid">
			<div class="col-lg-12">
				<div class="page-title pb-2">
					<h3>Mobile to Web</h3>
				</div>
				<!-- STATUS MESSAGES -->
				<?php if ($this->session->flashdata('error')===0) : ?>
					<div class="alert alert-success show" role="alert">
						<p id="msg-prompt-success">Successful: <?php echo $this->session->flashdata('msg')?></p>
					</div>

					<?php elseif ($this->session->flashdata('error')===1) : ?>
					<div class="alert alert-warning show" role="alert">
						<p id="msg-prompt-warning">Warning: <?php echo $this->session->flashdata('msg')?></p>
					</div>
					<?php elseif ($this->session->flashdata('error')===2) : ?>
						<div class="alert alert-danger show" role="alert">
						<p id="msg-prompt-error">Failed: <?php echo $this->session->flashdata('msg')?></p>
						</div>
					<?php endif ?>
					
				<div class="img-body">
					<div style="text-align:center">
							<img id="img-qr-code" style="size: 100%; width: 20%;" src="" />
							
					</div>
					
					<div style="text-align:center">
					<img id="img-loader" style="size: 100%; width: 70px;" src="assets/images/loader.gif" hidden/>
					<br />
						<button type="button" name="upload" class="btn btn-primary"  id="btn-QR">Generate QR Code for upload</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'footer.php'; ?>

<script>
$('#btn-QR').on({
    'click': function(a){
      let groupName = $(this).attr('name');
      $.ajax({
			url: 'qRGenerator/createUploadLink',
           	type: 'POST',
           	data: {group: groupName},
           	error: function(e) {
              alert(e.responseText);
           	},
           	success: function(data) {
                $('#img-qr-code').attr('src',data);
           	}
        });

        
    }
});
</script>