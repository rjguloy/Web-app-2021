<nav class="sidebar-wrapper animated bounceInDown">
	<ul class="sidebar-nav" id="sidebar-menu">
		<?php if ($this->session->role != 'SCHOOL') : ?>
			<li>
				<a href="colReports">Dashboard</a>
			</li>
			<li>
				<a href="colUpload">Import School Data</a>
			</li>
		<?php endif; ?>
		<?php if ($this->session->role == 'SCHOOL') : ?>
			<li class="sub-menu">
				<a href="#">Admin
			<svg xmlns="http://www.w3.org/2000/svg" width="12.184" height="4.666" viewBox="0 0 17.184 9.666">
				<path id="Path_8" data-name="Path 8" d="M93.167,180.018a1.074,1.074,0,0,0,1.519,0L102.2,172.5a1.074,1.074,0,1,0-1.519-1.519l-6.759,6.759-6.759-6.759a1.074,1.074,0,0,0-1.519,1.519Z" transform="translate(-85.334 -170.667)" fill="#8BA4C1"/>
			</svg>
				</a>
				<ul>
					<li>
						<a href="user" class="">User Accounts</a>
					</li>
					<li>
						<a href="schoolinfo">School Information Setting</a>
					</li>
					<li>
						<a href="#" data-toggle="modal" data-target="#modalChangePassword" id="cpword-link">Change Password</a>
					</li>
					<li>
						<a href="checklist">Checklist</a>
					</li>
				</ul>
			</li>
			<li class="sub-menu">
				<a href="#">SWAPP Set up
			<svg xmlns="http://www.w3.org/2000/svg" width="12.184" height="4.666" viewBox="0 0 17.184 9.666">
				<path id="Path_8" data-name="Path 8" d="M93.167,180.018a1.074,1.074,0,0,0,1.519,0L102.2,172.5a1.074,1.074,0,1,0-1.519-1.519l-6.759,6.759-6.759-6.759a1.074,1.074,0,0,0-1.519,1.519Z" transform="translate(-85.334 -170.667)" fill="#8BA4C1"/>
			</svg>
				</a>
				<ul>
					<li>
						<a href="locations">Locations</a>
					</li>
					<li>
						<a href="swt">School Watching Teams</a>
					</li>
					<li>
						<a href="checklistActivity">Checklist Activity Setting</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="mobileSync">Receive Results</a>
			</li>
			<li class="sub-menu">
				<a href="#">Reports
			<svg xmlns="http://www.w3.org/2000/svg" width="12.184" height="4.666" viewBox="0 0 17.184 9.666">
				<path id="Path_8" data-name="Path 8" d="M93.167,180.018a1.074,1.074,0,0,0,1.519,0L102.2,172.5a1.074,1.074,0,1,0-1.519-1.519l-6.759,6.759-6.759-6.759a1.074,1.074,0,0,0-1.519,1.519Z" transform="translate(-85.334 -170.667)" fill="#8BA4C1"/>
			</svg>
				</a>
				<ul>
					<li>
						<a href="reportChecklistActivity">Checklist Activity</a>
					</li>
					<li>
						<a href="reportSummary">Summary</a>
					</li>
					<li>
						<a href="reportPhoto">Hazard Photos</a>
					</li>
					<li>
						<a href="comparative">Comparative Data</a>
					</li>
					<li>
						<a href="reportNarrative">School Head Narrative</a>
					</li>
					<li>
						<a href="reportSendToServer">Send to Server</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="hazardmap">Hazard Map</a>
			</li>
		<?php endif; ?>
		<li>
			<a href="login/logout">Logout</a>
		</li>
	</ul>
</nav>
<?php include 'sidebar-toggler.php'; ?>

<div class="modal" id="modalChangePassword" tabindex="-1" role="dialog" aria-labelledby="changePassword" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="changePassword">Change Password</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="error-msg-div" class="w-100 px-3">
					<p id="error-msg"></p>
				</div>
				<div class="input-group my-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="current-password">Current password</span>
					</div>
					<input type="password" class="form-control" aria-label="Default" aria-describedby="current-password" id="cpword-oldpword">
					<div id="oldpword-error-msg-div" class="error-msg w-100 px-3">
						<p>Required.</p>
					</div>
				</div>
				<div class="input-group my-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="new-password">New password</span>
					</div>
					<input type="password" class="form-control" aria-label="Default" aria-describedby="new-password" id="cpword-npword" title="Password must be at least (6) characters, which consists of at least (1) upper case letter, (1) lower case letter, (1) number and (1) special character.">
					<div id="npword-error-msg-div" class="error-msg w-100 px-3">
						<p>Required.</p>
					</div>
				</div>
				<div class="input-group my-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="re-new-password">Re-type new password</span>
					</div>
					<input type="password" class="form-control" aria-label="Default" aria-describedby="re-new-password" id="cpword-re-npword">
					<div id="re-npword-error-msg-div" class="error-msg w-100 px-3">
						<p id="re-npword-error-msg">Required.</p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-submit" id="cpword-save-btn">Save</button>
			</div>

		</div>
	</div>
</div>
