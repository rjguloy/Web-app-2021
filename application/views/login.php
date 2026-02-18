<?php include 'head.php'; ?>
<?php include 'header.php'; ?>
<div class="login-fix d-flex flex-column">
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
		<div class="login-panel text-center position-absolute rounded p-5">
			<h2 class="text-white mb-3">PLEASE SIGN IN</h2>
			<div id="login-error-msg-div" class="error-msg">
				<p id="login-error-msg"></p>
			</div>
			<form id="login-form">
				<div class="form-group">
					<input type="text" class="form-control" id="login-uname" name="login-uname" aria-describedby="emailHelp" placeholder="Username">
					<div id="uname-error-msg-div" class="error-msg">
						<p>Required.</p>
					</div>
				</div>
				<div class="form-group">
					<input type="password" class="form-control" id="login-pword" name="login-pword" aria-describedby="emailHelp" placeholder="Password">
					<div id="pword-error-msg-div" class="error-msg">
						<p>Required.</p>
					</div>
				</div>
				<button type="submit" id="login-btn" class="btn btn-primary px-5 mb-5">Log in</button>
				<div>
					<a href="password" class="text-white">Forgot your password?</a>
				</div>
				<div class="create-account">
					<a href="register" class="text-white">No account yet? Click here to register.</a>
				</div>
			</form>
			<!-- Change Password -->
			<div id="cpword-div" class="security-questions position-absolute rounded w-100 p-5">
				<div class="m-header text-left pb-2 mb-3">
					<h5 class="d-inline">Change Password</h5>
				</div>
				<div id="cpword-msg-prompt-div" class="error-msg">
					<p id="cpword-msg-prompt"></p>
				</div>
				<div class="m-body text-left">
					<div class="form-group">
						<input type="password" class="form-control" aria-label="Default" id="login-new-pword" aria-describedby="new-pword" placeholder="Enter your new password" title="Password must be at least (6) characters, which consists of at least (1) upper case letter, (1) lower case letter, (1) number and (1) special character.">
						<div id="new-pword-error-msg-div" class="error-msg">
							<p>Required.</p>
						</div>
					</div>
					<div class="form-group">
						<input type="password" class="form-control" aria-label="Default" id="login-retype-pword" aria-describedby="re-new-pword" placeholder="Re-type your new password">
						<div id="retype-pword-error-msg-div" class="error-msg">
							<p id="retype-pword-error-msg">Required.</p>
						</div>
					</div>
				</div>
				<div class="m-footer text-center mt-5">
					<div class="row">
						<button type="button" class="col btn btn-cancel px-5 mt-4 mr-1">
							<a href="login/logout" class="btn btn-cancel">Cancel</a>
						</button>
						<button type="submit" id="login-cpword-btn" class="col btn btn-submit px-5 mt-4 ml-1">Save</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include 'footer.php'; ?>
</div>
<div class="password-expiration position-absolute text-center p-3">
	<p class="small">Your password will expire in</p>
	<p>3 days.</p>
</div>

<script>
	$(function(){
		$('#login-btn').click(function(e){
			e.preventDefault();
			var uname = $('#login-uname').val();
			var pword=$('#login-pword').val();
			var err = 0;

			$('#uname-error-msg-div').removeClass("show");
			$('#pword-error-msg-div').removeClass("show");
            $('#login-error-msg-div').removeClass("show");

			if(uname==""){
				err=1;
				$('#uname-error-msg-div').addClass("show");
			}

			if(pword==""){
				err=1;
				$('#pword-error-msg-div').addClass("show");
			}

			if(err==0){
				$.ajax({
					type:'POST',
					url:'login/validate',
					data:{uname:uname,pword:pword},
					dataType:'json',
					success:function(data){
						if(data < 90){
							window.location.href = 'home'; 
						}else{
		                    $('#cpword-div').addClass("show");
		                    $('#cpword-msg-prompt-div').addClass("show");
		                    $('#cpword-msg-prompt').html('Your password is already expired. Please change your password.');
						}
					},
	                error: function(data) 
	                {
	                    $('#login-error-msg-div').addClass("show");
	                    $('#login-error-msg').html(data.responseText);
	                }
				});		
			}	
		});

		$('#login-cpword-btn').click(function(e){
			e.preventDefault();		

			var uname = $.trim($('#login-uname').val());
			var newpword = $.trim($('#login-new-pword').val());
			var cnewpword = $.trim($('#login-retype-pword').val());
			var err=0;

			clearMessages();

			if(newpword==""){
				err = 1;
				$('#new-pword-error-msg-div').addClass("show");
			}

			if(cnewpword==""){
				err = 1;
				$('#retype-pword-error-msg').html("Required.");
				$('#retype-pword-error-msg-div').addClass("show");
			}

			if(newpword!="" && cnewpword!="" && newpword!=cnewpword){
				err = 1;
				$('#retype-pword-error-msg').html("New password and confirm password does not match.");
				$('#retype-pword-error-msg-div').addClass("show");
			}	

			if(err == 0){
				$.ajax({
					type:'POST',
					url:'password/change2',
					data:{uname:uname, newpword:newpword},
					dataType:'json',
					success:function(data){
						clearMessages();
	                    $('#cpword-msg-prompt-div').addClass("success-msg show");
	                    $('#cpword-msg-prompt').html("Change password successful.");

    					setTimeout(
							function(){
								window.location.href = 'home'; 
							},
							1500
						);							
					},
					error: function(data) 
					{
	                    $('#cpword-msg-prompt-div').addClass("show");
	                    $('#cpword-msg-prompt').html(data.responseText);
					}
				});
			}
		});
	});

	function clearMessages(){
        $('#new-pword-error-msg-div').removeClass("show");
        $('#retype-pword-error-msg-div').removeClass("show");
        $('#cpword-msg-prompt-div').removeClass("show");
        $('#cpword-msg-prompt').html('');
	}
</script>
