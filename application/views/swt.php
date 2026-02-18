<?php include 'head.php'; ?>
<?php include 'header.php'; ?>
<div class="wrapper d-flex align-items-stretch" id="wrapper">
  <?php include 'nav.php'; ?>
  <div class="page-content-wrapper mb-0"> <!-- All content of the page must be inside this div -->
    <div class="container-fluid">
      <div class="col-lg-12">
        <?php
        $hasHazardPriv = function ($team, $loc) use ($permissions) {
          if ( ! $permissions) return FALSE;
          foreach ($permissions as $row) {
            if ($row['team'] != $team) continue;
            if ($loc == $row['sublocation_id']) {
                return TRUE;
            }
          }
          return FALSE;
        };
        $memberCount = function($group) use ($teams) {
          $count = 0;
          if (isset($teams) && is_array($teams)) {
            foreach ($teams as $team) {
              if ($team['team'] != $group) continue;
              $count++;
            }
          } 
          return $count;
        };
        ?>
        <div class="page-title pb-2">
          <h3>School Watching Teams</h3>
          <input type="hidden" id="hasNoSchoolID" 
            value="<?php echo $hasNoSchoolID ?>" />
        </div>
        <!-- STATUS MESSAGES -->
        <div class="alert alert-success" role="alert">
          <p id="msg-prompt-success"><?php echo $this->session->flashdata('msg')?></p>
        </div>
        <div class="alert alert-warning" role="alert">
          <p id="msg-prompt-warning"><?php echo $this->session->flashdata('msg')?></p>
        </div>
        <div class="alert alert-danger" role="alert">
          <p id="msg-prompt-error"><?php echo $this->session->flashdata('msg')?></p>
        </div>
        <div>
          <div class="row">
            <div class="col-lg-4">
            <h4 class="my-3">Team Members</h4>
            
              <div class="accordion mx-auto my-4" id="swt">
                <?php $groups = ['A', 'B', 'C'] ?>
                <?php foreach ($groups as $group) : ?>
                  <div class="card">
                  <button class="card-header text-left font-weight-bold border-0 collapsed" id="heading-t<?php echo $group ?>" 
                  data-toggle="collapse" data-target="#t<?php echo $group ?>" aria-expanded="false" aria-controls="t<?php echo $group ?>">
                    Team <?php echo $group ?>
                    <div style="float:right">
                      (<span id="span-mem-count-<?php echo $group ?>"><?php echo $memberCount($group)?></span>)
                    </div>
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="17.184" height="9.666" viewBox="0 0 17.184 9.666">
                      <path id="Path_8" data-name="Path 8" d="M93.167,180.018a1.074,1.074,0,0,0,1.519,0L102.2,172.5a1.074,1.074,0,1,0-1.519-1.519l-6.759,6.759-6.759-6.759a1.074,1.074,0,0,0-1.519,1.519Z" transform="translate(-85.334 -170.667)" fill="#2a5f9d"/>
                    </svg> -->
                  </button>

                      <div id="t<?php echo $group ?>" class="collapse" aria-labelledby="heading-t<?php echo $group ?>">
                        <div class="card-body">
                          <div style="height:300px; overflow:auto">
                            <ul class="list-group swt-students"
                            id="mem-list-<?php echo $group ?>">
                              <?php
                              $count = 0;
                              if (isset($teams) && is_array($teams)) :
                                foreach ($teams as $team) : 
                                  if ($team['team'] != $group) continue;
                                  ?>
                                  <li class="list-group-item d-flex justify-content-between" id="mem-count-<?php echo $count.'-'.$group ?>">
                                    <?php echo ($count+1) . '. ' .$team['name'].' - '.$team['gender'] ?>
                                    <div id="add-remove-students" class="btn btn-delete" data-toggle="tooltip" title="Remove Student">
                                      <img src="assets/images/icons/delete.svg" 
                                      data-count="<?php echo $count?>" 
                                      data-team="<?php echo $group ?>" 
                                      data-name="<?php echo $team['name'] ?>"
                                      data-sex="<?php echo $team['gender'] ?>"
                                      data-id="<?php echo $team['id'] ?>" 
                                      class="icon mem-remove">
                                    </div>
                                  </li>
                                  <?php
                                  $count++; 
                                endforeach;
                              endif;
                              $lastCount = $count;
                              ?>
                              <input type="hidden" id="hidden-member-next-<?php echo $group ?>" value="<?php echo $lastCount + 1 ?>">
                            </ul>
                          </div>
                          <ul class="list-group swt-students" style="margin-top:10px"
                            id="mem-add-<?php echo $group ?>">
                         
                            <li class="list-group-item d-flex justify-content-between">
                              
                              <input type="text" class="form-control col-sm-8" id="text-member-<?php echo $group ?>" placeholder="Add Student">
                              <select id="sel-mem-sex-<?php echo $group ?>">
                                <option value="">Gender</option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                              </select>
                              <div id="add-remove-students" class="btn btn-add" data-toggle="tooltip" title="Add Student">
                                <img src="assets/images/icons/plus_S.svg" class="icon add-mem" data-team="<?php echo $group ?>">
                              </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                            <button type="button" id="btn-QR<?php echo $group ?>" name="btn_member_qr_<?php echo $group ?>" class="btn btn-primary"  
                            id="btn-member-QR-<?php echo $group ?>">Generate QR Code</button>
                            </li>
                          </ul>
                        </div>
                      </div>
                    
                  </div>
                <?php endforeach ?>
              </div>
            </div>
            <div class="col-lg-8">
              <h4 class="my-3">Team Assignments</h4>
              <form method="post" action="<?php echo 'swt/save' ?>" class="form-ajax">
                <table class="table" id="swt-cat-table-<?php echo $group ?>">
                  <thead>
                    <tr>
                      <td class="hazard-cat"><strong>Sublocations</strong></td>
                      <td class="room text-center"><strong>Team A</strong></td>
                      <td class="room text-center"><strong>Team B</strong></td>
                      <td class="room text-center"><strong>Team C</strong></td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (isset($locs) && $locs) : ?>
                      <?php foreach ($locs as $loc ) : ?>
                        <?php if ($loc['room']) : ?>
                          <tr>
                            <td class="hazard-cat">
                              <?php echo $loc['bldg'] . ' - ' . $loc['room'] ?>
                            </td>
                            <?php $groups = ['A', 'B', 'C'] ?>
                            <?php foreach ($groups as $group) : ?>
                              <td class="room text-center">
                                <div class="boxes">
                                  <input type="radio" class="check-perm radio-<?php echo $group ?>"
                                  name="permission[<?php echo $loc['room_id']?>]" 
                                  value="<?php echo $group ?>"
                                  <?php echo $hasHazardPriv($group, $loc['room_id'])? 'checked="checked"' : '' ?> />   
                                </div>
                              </td>
                            <?php endforeach ?>
                          </tr>
                        <?php endif ?>
                      <?php endforeach ?>
                    <?php endif ?>
                  </tbody>
                </table>
              
                <div class="save-changes text-right">
                  <button type="submit" class="btn btn-submit">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<div class="modal" id="modalQR" tabindex="-1" role="dialog" aria-labelledby="qrcode" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="qrcode">Scan to download</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div style="text-align:center">
          <img id="img-qr-code" style="size: 100%; width: 100%; height: 100%;" src="" />
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</div>
<?php include 'footer.php'; ?>

<script>
$('#btn-QRA, #btn-QRB, #btn-QRC').on({
    'click': function(a){
      let groupName = $(this).attr('name');
      $.ajax({
           url: 'qRGenerator/createDownloadLink',
           type: 'POST',
           data: {group: groupName.replace("btn_member_qr_","")},
           error: function(e) {
            
              alert(e.responseText);
           },
           success: function(data) {
            $('#modalQR').modal('toggle');
            $('#modalQR').modal('show');

                $('#img-qr-code').attr('src',data);
           }
        });

        
    }
});
</script>
<script language="JavaScript">
$(document).ready(function(){

  var noSchoolID = $('#hasNoSchoolID').val();
  
  if (noSchoolID) {
    alert('You need to have School Information Credentials. Set it up now.');
    window.location.replace('schoolinfo');
  }

  
  var table = $('#swt-cat-table-A,#swt-cat-table-B,#swt-cat-table-C').DataTable();

  $(document).on('click', 'img.mem-remove', function(e) {

    var x = confirm('Are you sure you want to delete this team member?');

    if ( ! x) return false;

    var group = $(this).data('team');
    var count = $(this).data('count');
    var id    = $(this).data('id');
    var name  = $(this).data('name');
    var sex    = $(this).data('sex');
    
    $.ajax({
      type:     'POST',
      url:      'swt/removeMember',
      data:     {
                  memID:    id,
                  memName:  name,
                  memSex:   sex,
                  memTeam:  group
                },
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

          var lastCount = $('#hidden-member-next-'+group);
          var currCount = parseInt(lastCount.val()-1);
          $('#hidden-member-next-'+group).val(parseInt(currCount));

          $('li#mem-count-'+count+'-'+group).remove();
          $('#span-mem-count-'+group).html(parseInt(currCount)-1);
        }

        setTimeout(
          function(){
            window.location.reload();
          },
          1500
        );  
      },
      error:function(data){
        console.log(data.responseText);
      }
    });
  });


  $(document).on('click', 'img.add-mem', function(e) {

    var group       = $(this).data('team');
    var name        = $('#text-member-'+group).val();
    var sex         = $('#sel-mem-sex-'+group).val();

   if (name === "") {
      alert('Name is required.');
      return false;
    }

    if (name.length > 10) {
      alert('Name length is too long.');
      return false;
    }

    if (sex === "") {
      alert('Gender is required.');
      return false;
    }

    $.ajax({
      type:     'POST',
      url:      'swt/addMember/'+group,
      data:     {
                  memID:    0,
                  memName:  name,
                  memSex:   sex
                },
      dataType: 'json',
      success:  function(data) {
        if (data.error == 1) {
          $('#msg-prompt-warning').text(data.msg)
          .parent().addClass("show");
        } else if (data.error == 2) {
          $('#msg-prompt-danger').text(data.msg)
          .parent().addClass("show");
        } else {
          $('#msg-prompt-success').text(data.msg)
          .parent().addClass("show");


          var lastCount = $('#hidden-member-next-'+group);
          var currCount = parseInt(lastCount.val());
          
          $('#mem-list-'+group).append('\
            <li class="list-group-item d-flex justify-content-between" id="mem-count-'+currCount+'-'+group+'">'+
            currCount +'. '+ name+' - '+sex+
              '<div id="add-remove-students" class="btn btn-delete" data-toggle="tooltip" title="Remove Student">\
                <img src="assets/images/icons/delete.svg"\
                data-count="'+currCount+'" data-team="'+group+'"\
                data-name="'+name+'" data-sex="'+sex+'"\
                data-id="'+data.memID+'" class="icon mem-remove">\
              </div>\
            </li>\
          ');

          
          $('#text-member-'+group).val('');
          $('#sel-mem-sex-'+group).val('');

          $('#hidden-member-next-'+group).val(parseInt(currCount)+1);
          $('#span-mem-count-'+group).html(parseInt(currCount));

        }

        setTimeout(
          function(){
            
            $('#msg-prompt-warning')
            .parent().removeClass("show");
            $('#msg-prompt-danger')
            .parent().removeClass("show");
            $('#msg-prompt-success')
            .parent().removeClass("show");
          },
          1500
        );  
      },
      error:function(data){
        console.log(data.responseText);
      }
    });
  });


  $('.form-ajax').submit(function(e) {
    
    e.preventDefault();

    var params = table.$('.check-perm').serializeArray();

    $.ajax({
      type:     'POST',
      url:      $(this).attr('action'),
      data:     params,
      dataType: 'json',
      success:  function(data) {
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
            window.location.reload(true);
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