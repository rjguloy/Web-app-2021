<?php include 'head.php'; ?>
<?php include 'header.php'; ?>
<div class="login">
	<div class="slider">
		<div class="login-slider">
			<div class="slider-item">
				<div class="img-fluid banner" style="background-image: url('./assets/images/p1.jpg');"></div>
			</div>
			<div class="slider-item">
				<div class="img-fluid banner" style="background-image: url('./assets/images/p2.jpg');"></div>
			</div>
			<div class="slider-item">
				<div class="img-fluid banner" style="background-image: url('./assets/images/p3.jpg');"></div>
			</div>
			<div class="slider-item">
				<div class="img-fluid banner" style="background-image: url('./assets/images/p4.jpg');"></div>
			</div>
			<div class="slider-item">
				<div class="img-fluid banner" style="background-image: url('./assets/images/p5.jpg');"></div>
			</div>
			<div class="slider-item">
				<div class="img-fluid banner" style="background-image: url('./assets/images/p6.jpg');"></div>
			</div>
			<div class="slider-item">
				<div class="img-fluid banner" style="background-image: url('./assets/images/p7.jpg');"></div>
			</div>
			<div class="slider-item">
				<div class="img-fluid banner" style="background-image: url('./assets/images/p8.jpg');"></div>
			</div>
			<div class="slider-item">
				<div class="img-fluid banner" style="background-image: url('./assets/images/p9.jpg');"></div>
			</div>
			<div class="slider-item">
				<div class="img-fluid banner" style="background-image: url('./assets/images/p10.jpg');"></div>
			</div>
			<div class="slider-item">
				<div class="img-fluid banner" style="background-image: url('./assets/images/p11.jpg');"></div>
			</div>
			<div class="slider-item">
				<div class="img-fluid banner" style="background-image: url('./assets/images/p12.jpg');"></div>
			</div>
		</div>
	</div>
	<div class="login-panel position-absolute text-center rounded p-5">
		<h2 class="text-white mb-3">CREATE NEW ACCOUNT</h2>
		<div id="msg-prompt-div" class="success-msg">
			<p id="msg-prompt"></p>
		</div
		<form id="register-form" class="sq-form text-left">
			<div class="form-group">
				<input type="text" class="form-control" id="register-uname" aria-describedby="emailHelp" placeholder="Enter your username">
				<div id="uname-error-msg-div" class="error-msg">
					<p>Required.</p>
				</div>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" id="register-name" aria-describedby="emailHelp" placeholder="Enter your name">
				<div id="name-error-msg-div" class="error-msg">
					<p>Required.</p>
				</div>
			</div>
			<div class="form-group">
				<input type="password" class="form-control" id="register-pword" aria-describedby="emailHelp" maxlength="20" placeholder="Enter your password" title="Password must be at least (6) characters, which consists of at least (1) upper case letter, (1) lower case letter, (1) number and (1) special character.">
				<div id="pword-error-msg-div" class="error-msg">
					<p>Required.</p>
				</div>
			</div>
			<div class="form-group">
				<input type="password" class="form-control" id="register-re-pword" aria-describedby="emailHelp" minlength="6" maxlength="20" placeholder="Re-enter your password">
				<div id="cpword-error-msg-div" class="error-msg">
					<p id="cpword-error-msg">Required.</p>
				</div>
			</div>
			<div class="dpn d-flex justify-content-between">
				<input type="checkbox" name="" id="data-privacy-notice">
				<label for="data-privacy-notice" class="mx-auto my-2">
					<a href="https://www.deped.gov.ph/about-deped/data-privacy-notice/" target="_blank" class="text-white">Data Privacy Acceptance</a>
				</label>
			</div>
			<button type="submit" id="next-btn" class="btn btn-primary px-5 mt-4 mb-5" disabled>Next</button>
			<div class="back-to-login">
				<a href="login" class="text-white">Go back to login.</a>
			</div>

			<div id="sq-div" class="security-questions position-absolute rounded w-100 p-5">
				<div class="m-header text-left pb-2 mb-3">
					<h5 class="d-inline">Security Questions</h5>
				</div>
				<div class="m-body text-left">
					<?php foreach ($questions as $ctr=>$question){ ?>
						<div class="form-group">
							<label for="sq-<?php echo ($ctr+1); ?>"><?php echo ($ctr+1).". ".$question->description; ?></label>
							<input type="text" class="form-control" name="sec-qtn-ans[]" id="<?php echo $question->seqid; ?>" placeholder="Type your answer here.">
							<div id="ans-div-<?php echo ($ctr+1); ?>" class="error-msg">
								<p>Required.</p>
							</div>
						</div>
					<?php } ?>
				</div>
				<div class="m-footer text-center mt-5">
					<div class="row">
						<button type="button" class="col btn btn-cancel px-5 mt-4 mr-1">
							<a href="register" class="btn btn-cancel">Cancel</a>
						</button>
						<button type="submit" id="register-btn" class="col btn btn-submit px-5 mt-4 ml-1">Register</button>
					</div>
				</div>
			</div>			
		</form>
	</div>
</div>
<?php include 'footer.php'; ?>


<script>
	$(function(){
		$('#data-privacy-notice').click(function(e){
			if(this.checked){
				$('#next-btn').prop('disabled', false);
			}else{
				$('#next-btn').prop('disabled', true);
			}
		});

		$('#next-btn').click(function(e){
			e.preventDefault();
			var uname = $.trim($('#register-uname').val());
			var name = $.trim($('#register-name').val());
			var pword = $.trim($('#register-pword').val());
			var cpword = $.trim($('#register-re-pword').val());
			var err=0;

			$('#uname-error-msg-div').removeClass("show");
			$('#name-error-msg-div').removeClass("show");
			$('#pword-error-msg-div').removeClass("show");
			$('#cpword-error-msg-div').removeClass("show");
			$('#msg-prompt-div').removeClass("show");

			if(uname==""){
				err = 1;
				$('#uname-error-msg-div').addClass("show");
			}

			if(name==""){
				err = 1;
				$('#name-error-msg-div').addClass("show");
			}

			if(pword==""){
				err = 1;
				$('#pword-error-msg-div').addClass("show");
			}

			if(cpword==""){
				err = 1;
				$('#cpword-error-msg').html("Required.");
				$('#cpword-error-msg-div').addClass("show");
			}

			if(pword!="" && cpword!="" && pword!=cpword){
				err = 1;
				$('#cpword-error-msg').html("Password and confirm password does not match.");
				$('#cpword-error-msg-div').addClass("show");
			}

			if (err==0){
				$.ajax({
					type:'POST',
					url:'register/validatePassword',
					data:{pword:pword},
					dataType:'json',
					success:function(data){	
						$('#sq-div').addClass("show");
					},
	                error: function(data) 
	                {
	                    $('#msg-prompt-div').removeClass("success-msg");
	                    $('#msg-prompt-div').addClass("error-msg show");
	                    $('#msg-prompt').html(data.responseText);
	                }
				});
			}			
		});

		$('#register-btn').click(function(e){
			e.preventDefault();
			var uname = $.trim($('#register-uname').val());
			var name = $.trim($('#register-name').val());
			var pword = $.trim($('#register-pword').val());
			var answers = $('input[name="sec-qtn-ans[]"]').map(function(){ return this.value; }).get();
			var questions = $('input[name="sec-qtn-ans[]"]').map(function(){ return this.id; }).get();
			var err = 0;

            $('#msg-prompt-div').removeClass("show");

			$('input[name="sec-qtn-ans[]"]').each(function(index) {
				$('#ans-div-'+(index+1)).removeClass("show");
			    if($.trim($(this).val())==""){
			    	err++;
					$('#ans-div-'+(index+1)).addClass("show");
			    }
			});

			if (err==0){
				$.ajax({
					type:'POST',
					url:'user/add',
					data:{name:name, uname:uname, pword:pword, questions:questions.toString(), answers:answers.toString()},
					dataType:'json',
					success:function(data){	
						$('#sq-div').removeClass("show");
	                    $('#msg-prompt-div').addClass("show");
	                    $('#msg-prompt-div').removeClass("error-msg");
	                    $('#msg-prompt-div').addClass("success-msg");
	                    $('#msg-prompt').html("Account successfully created. Please wait for the approval.");
	                    clearForm();
					},
	                error: function(data) 
	                {
						$('#sq-div').removeClass("show");
	                    $('#msg-prompt-div').addClass("show");
	                    $('#msg-prompt-div').removeClass("success-msg");
	                    $('#msg-prompt-div').addClass("error-msg");
	                    $('#msg-prompt').html(data.responseText);
	                    clearForm();
	                }
				});
			}		
		});
	});

	function clearForm(){
		$('#register-uname').val('');
		$('#register-name').val('');
		$('#register-pword').val('');
		$('#register-re-pword').val('');
		$('input[name="sec-qtn-ans[]"]').each(function(index) {
			$(this).val('');
		});
		$("#data-privacy-notice").prop("checked", false);
		$('#next-btn').prop('disabled', true);
	}
</script>