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
	<div class="login-panel forgot-password position-absolute text-center rounded p-5">
		<h2 class="text-white mb-3">FORGOT PASSWORD</h2>
		<div id="msg-prompt-div" class="error-msg">
			<p id="msg-prompt"></p>
		</div>
		<form id="fpword-form" class="sq-form text-center">
			<!-- Username -->
			<div class="form-group">
				<input type="text" class="form-control" id="fpword-uname" aria-describedby="username" placeholder="Enter your username">
				<div id="uname-error-msg-div" class="error-msg">
					<p>Required.</p>
				</div>
			</div>
			<button type="submit" id="next-btn" class="btn btn-primary px-5 mt-4 mb-5">Next</button>
			<div class="back-to-login text-center">
				<a href="login" class="text-white">Go back to login.</a>
			</div>
			<!-- Security Questions -->
			<div id="sq-div" class="security-questions position-absolute rounded w-100 p-5">
				<div class="m-header text-left pb-2 mb-3">
					<h5 class="d-inline">Answer your Security Questions</h5>
				</div>
				<div id="sq-msg-prompt-div" class="error-msg">
					<p id="sq-msg-prompt"></p>
				</div>
				<div class="m-body text-left">
					<div class="form-group">
						<label for="sq-1">1. Question Here</label>
						<input type="text" class="form-control" name="sec-qtn-ans[]" placeholder="Type your answer here.">
						<div id="ans-div-1" class="error-msg">
							<p>Required.</p>
						</div>
					</div>
					<div class="form-group">
						<label for="sq-2">2. Question Here</label>
						<input type="text" class="form-control" name="sec-qtn-ans[]" placeholder="Type your answer here.">
						<div id="ans-div-2" class="error-msg">
							<p>Required.</p>
						</div>
					</div>
					<div class="form-group">
						<label for="sq-3">3. Question Here</label>
						<input type="text" class="form-control" name="sec-qtn-ans[]" placeholder="Type your answer here.">
						<div id="ans-div-3" class="error-msg">
							<p>Required.</p>
						</div>
					</div>
				</div>
				<div class="m-footer text-center mt-5">
					<div class="row">
						<button type="button" class="col btn btn-cancel px-5 mt-4 mr-1">
							<a href="password" class="btn btn-cancel">Cancel</a>
						</button>
						<button type="submit" id="fpword-sq-btn" class="col btn btn-primary px-5 mt-4 ml-1">Next</button>
					</div>
				</div>
			</div>	
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
						<input type="password" class="form-control" aria-label="Default" id="fpword-new-pword" aria-describedby="new-pword" placeholder="Enter your new password" title="Password must be at least (6) characters, which consists of at least (1) upper case letter, (1) lower case letter, (1) number and (1) special character.">
						<div id="new-pword-error-msg-div" class="error-msg">
							<p>Required.</p>
						</div>
					</div>
					<div class="form-group">
						<input type="password" class="form-control" aria-label="Default" id="fpword-retype-pword" aria-describedby="re-new-pword" placeholder="Re-type your new password">
						<div id="retype-pword-error-msg-div" class="error-msg">
							<p id="retype-pword-error-msg">Required.</p>
						</div>
					</div>
				</div>
				<div class="m-footer text-center mt-5">
					<div class="row">
						<button type="button" class="col btn btn-cancel px-5 mt-4 mr-1">
							<a href="password" class="btn btn-cancel">Cancel</a>
						</button>
						<button type="submit" id="fpword-cpword-btn" class="col btn btn-submit px-5 mt-4 ml-1">Save</button>
					</div>
				</div>
			</div>		
		</form>
	</div>
</div>
<?php include 'footer.php'; ?>


<script>
	$(function(){
		$('#next-btn').click(function(e){
			e.preventDefault();
			var uname = $.trim($('#fpword-uname').val());
			var err=0;

			clearMessages();

			if(uname==""){
				err = 1;
				$('#uname-error-msg-div').addClass("show");
			}

			if (err==0){
				$.ajax({
					type:'POST',
					url:'password/validateUsername',
					data:{uname:uname},
					dataType:'json',
					success:function(data){	
					    $.each(data, function(i, question) {
   	 						$("label[for=sq-" + (i + 1) + "]").text((i + 1) + ". " + question.description);
							
							$('input[name="sec-qtn-ans[]"]').each(function(index) {
								if(index==i){
									$(this).attr('id', question.seqid);
								}
							});
					    });
						$('#sq-div').addClass("show");
					},
	                error: function(data) 
	                {
	                    $('#msg-prompt-div').addClass("show");
	                    $('#msg-prompt').html(data.responseText);
	                }
				});
			}			
		});

		$('#fpword-sq-btn').click(function(e){
			e.preventDefault();
			var uname = $.trim($('#fpword-uname').val());
			var answers = $('input[name="sec-qtn-ans[]"]').map(function(){ return this.value; }).get();
			var questions = $('input[name="sec-qtn-ans[]"]').map(function(){ return this.id; }).get();
			var err = 0;

			clearMessages();

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
					url:'password/validateAnswers',
					data:{uname:uname, questions:questions.toString(), answers:answers.toString()},
					dataType:'json',
					success:function(data){	
						$('#sq-div').removeClass("show");
	                    $('#cpword-div').addClass("show");
					},
	                error: function(data) 
	                {
	                    $('#sq-msg-prompt-div').addClass("show");
	                    $('#sq-msg-prompt').html(data.responseText);
	                }
				});
			}		
		});

		$('#fpword-cpword-btn').click(function(e){
			e.preventDefault();		

			var uname = $.trim($('#fpword-uname').val());
			var newpword = $.trim($('#fpword-new-pword').val());
			var cnewpword = $.trim($('#fpword-retype-pword').val());
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
						clearForm();
						clearMessages();
	                    $('#cpword-div').removeClass("show");
	                    $('#msg-prompt-div').addClass("success-msg show");
	                    $('#msg-prompt').html("Change password successful.");
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

	function clearForm(){
		$('#fpword-uname').val('');
		$('input[name="sec-qtn-ans[]"]').each(function(index) {
			$(this).val('');
		});
		$('#fpword-new-pword').val('');
		$('#fpword-retype-pword').val('');
	}

	function clearMessages(){
		$('#uname-error-msg-div').removeClass("show");
        $('#msg-prompt-div').removeClass("success-msg show");
        $('#msg-prompt').html('');
        $('#sq-msg-prompt-div').removeClass("show");
        $('#sq-msg-prompt').html('');
        $('#new-pword-error-msg-div').removeClass("show");
        $('#retype-pword-error-msg-div').removeClass("show");
        $('#cpword-msg-prompt-div').removeClass("show");
        $('#cpword-msg-prompt').html('');
	}
</script>