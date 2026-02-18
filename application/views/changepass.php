
	<div id="page-wrapper" style="padding-top:80px">
	    <div class="row">
	        <div class="col-lg-12">
	            <h1 class="page-header"><img src="assets/images/cp.png" width="50"/>&nbsp;&nbsp;Change Password</h1>
	        </div><!-- /.col-lg-12 -->   
	    </div><!-- /.row -->
	    
	    <div class="row" style="padding:15px">
	    	<div class="tab" role="tabpanel">
	    		<!-- Nav tabs -->
				<ul id="myTabs" class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#Section1" aria-controls="home" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-user"></i> Information</a></li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane fade in active" id="Section1">
						<div class="row" style="padding:0 15px">
							<form class="well form-horizontal" action="" method="post"  id="contact_form">
								<fieldset>
									<div class="form-group">
									  	<label class="col-md-4 control-label">Current Password</label>  
									  	<div class="col-md-6 inputGroupContainer">
									  		<div class="input-group">
									  			<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
									  			<input  name="oldpass" id="oldpass" placeholder="Type your old password" class="form-control"  type="text" >
											</div><!-- end .input-group -->
									  	</div><!-- end .inputGroupContainer -->
									</div><!-- end .form-group -->

									<div class="form-group">
									  	<label class="col-md-4 control-label">New Password</label>  
									  	<div class="col-md-6 inputGroupContainer">
									  		<div class="input-group">
									  			<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
									  			<input  id="newpass" name="newpass" placeholder="Type your new password" class="form-control"  type="text" >
									    	</div><!-- end .input-group -->
									  	</div><!-- end .inputGroupContainer -->
									</div><!-- end .form-group -->

									<div class="form-group">
									  	<label class="col-md-4 control-label"></label>
									  	<div class="col-md-6"><br>
											<div class="alert alert-warning" role="alert" id="success_message">
												<i class="glyphicon glyphicon-exclamation-sign"></i> Error!.<br/>
												<span id="err-msg">Please enter your old password</span><br/>
												<span id="err-msg">Please enter your new password</span><br/>
												<span id="err-msg">The inputted old password is incorrect</span>
											</div>

									   		<button id="submit" name="submit" type="submit" class="btn btn-primary" style="width:375px" >SAVE <span class="glyphicon glyphicon-send"></span></button>
									  	</div><!-- end .col-md-6 -->
									</div><!-- end .form-group -->


								</fieldset>
							</form>
						</div><!-- end .row -->
					</div><!-- end .tab-pane -->
				</div><!-- end .tab-content -->


			</div><!-- end .tab -->
		
		</div><!-- /.row -->

		
	    
	</div><!-- /#page-wrapper -->
	