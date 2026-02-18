<?php
$getTypeDesc = function($data) {

  switch ($data) {
    case 1: $out = 'Room';          break;
    case 2: $out = 'Floor';         break;
    case 3: $out = 'Building';      break;
    case 4: $out = 'School Ground'; break;
    case 5: $out = 'Others';        break;
    default: $out = 'Sublocation';
  }

  return $out;
};
?>
<?php include 'head.php'; ?>
<?php include 'header.php'; ?>
<div class="wrapper d-flex align-items-stretch" id="wrapper">
  <?php include 'nav.php'; ?>
  <div class="page-content-wrapper mb-0"> <!-- All content of the page must be inside this div -->
    <div class="container-fluid">
      <div class="col-lg-12">
        <div class="page-title pb-2">
          <h3>Locations</h3>
        </div>
        <!-- STATUS MESSAGES -->
        <?php if ($this->session->flashdata('error')===0) : ?>
          <div class="alert alert-success show" role="alert">
            <p id="msg-prompt-success"><?php echo $this->session->flashdata('msg')?></p>
          </div>
        <?php elseif ($this->session->flashdata('error')===1) : ?>
          <div class="alert alert-warning show" role="alert">
            <p id="msg-prompt-warning"><?php echo $this->session->flashdata('msg')?></p>
          </div>
        <?php elseif ($this->session->flashdata('error')===2) : ?>
            <div class="alert alert-danger show" role="alert">
              <p id="msg-prompt-error"><?php echo $this->session->flashdata('msg')?></p>
            </div>
        <?php endif ?>
        <div class="row wrapper my-4">
          <div class="col-md-6 text-md-left text-center p-0">
            <input type="hidden" id="hasNoSchoolID" 
            value="<?php echo $hasNoSchoolID ?>" />
            
          </div>
          <div class="col-md-6 text-md-right text-center p-0">
            <button type="button" class="btn btn-primary py-1 mt-3 mt-md-0" id="add-building" data-toggle="modal" data-target="#modalAddBuilding">Add Building</button>
            <div class="modal fade" id="modalAddBuilding" tabindex="-1" role="dialog" aria-labelledby="addBuilding" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <form method="post" id="frm-add-loc" action="locations/add"?>
                    <div class="modal-header">
                      <h5 class="modal-title" id="addBuilding">Add Building</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="add-building-name">Building Name</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Default" aria-describedby="building-name" 
                        id="text-loc-name" name="locationName">
                        <div id="addloc-error-msg-div" class="error-msg w-100 px-3">
                          <p id="addloc-error-msg" style="text-align:left">Required.</p>
                        </div>
                        <input type="hidden" id="location-type" name="locationType" value="3">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-add">Save</button>
                    </div>
                    
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
        <?php if (isset($recs)) : ?>
          <div class="accordion" id="location-list">
            <?php $count = 1 ?>
            <?php foreach ($recs as $loc) : ?>
              <div class="card">
                <button class="card-header text-left font-weight-bold border-0 collapsed" id="box-<?php echo $count ?>" data-toggle="collapse" 
                data-target="#building-<?php echo $count ?>" aria-expanded="false" 

                aria-controls="building-<?php echo $count ?>">
                  <?php echo $loc['bldg']?>
                  <div class="wrapper position-absolute">
                    <img src="assets/images/icons/checklist-plus.svg" class="add-room" id="add-room-<?php echo $count ?>" data-toggle="modal" 
                    data-target="#modalAddRoom" data-building="<?php echo $loc['bldg_id']?>">
                    <img src="assets/images/icons/checklist-edit.svg" data-target="#modalEditBuilding" class="edit-building"
                    data-toggle="modal" data-building="<?php echo $loc['bldg_id']?>" data-name="<?php echo $loc['bldg'] ?>">
                    <img src="assets/images/icons/checklist-delete.svg" onclick="delete_location('<?php echo $loc['bldg_id']?>');">
                  </div>
                  <svg xmlns="http://www.w3.org/2000/svg" width="17.184" height="9.666" viewBox="0 0 17.184 9.666">
                    <path id="Path_8" data-name="Path 8" d="M93.167,180.018a1.074,1.074,0,0,0,1.519,0L102.2,172.5a1.074,1.074,0,1,0-1.519-1.519l-6.759,6.759-6.759-6.759a1.074,1.074,0,0,0-1.519,1.519Z" transform="translate(-85.334 -170.667)" fill="#2a5f9d"/>
                  </svg>
                </button>
                <div id="building-<?php echo $count ?>" class="collapse" aria-labelledby="box-<?php echo $count ?>">
                  <?php if (isset($loc['room'][0]['name'])) : ?>
                    <div class="card-body">
                      <ul class="list-group">
                        <li class="list-group-item">
                          <div class="container" style="margin:0px">
                            <div class="row">
                              <div class="col-lg-6">
                                <strong>Name</strong>
                              </div>
                              <div class="col-lg-6">
                              <strong>Category</strong>
                              </div>
                              <div class="wrapper position-absolute">
                                <strong>Action</strong>
                              </div>
                            </div>
                          </div>
                        </li>
                        <?php foreach ($loc['room'] as $row) : ?>
                          <li class="list-group-item">


                            <div class="container" style="margin:0px">
                              <div class="row">
                                <div class="col-lg-6">
                                  <?php echo $row['name']?>
                                </div>
                                <div class="col-lg-6">
                                  <?php echo $getTypeDesc($row['hazcat_type'])?>
                                </div>
                                <?php if (strtolower($row['name']) != 'structure') : ?>
                                  <div class="wrapper position-absolute">
                                    <img src="assets/images/icons/checklist-edit.svg" class="edit-room" data-target="#modalEditRoom" 
                                    data-toggle="modal" data-room="<?php echo $row['room_id']?>" 
                                    data-building="<?php echo $loc['bldg_id']?>" data-name="<?php echo $row['name']?>" 
                                    data-type="<?php echo $row['hazcat_type']?>" style="cursor: pointer">
                                    <img src="assets/images/icons/checklist-delete.svg" 
                                    onclick="delete_sublocation('<?php echo $row['room_id']?>');" style="cursor: pointer">
                                  </div>
                                <?php endif ?>
                              </div>

                            </div>
                          </li>
                        <?php endforeach ?>
                        
                      </ul>
                    </div>
                  <?php endif ?>
                </div>
              </div>
              <?php $count++ ?>
            <?php endforeach ?>
          </div>
        <?php endif ?>
      </div>
    </div>
  </div>
  
<!-- ADD ROOM MODAL -->
<div class="modal fade" id="modalAddRoom" role="dialog" aria-labelledby="addRoom" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form method="post" id="frm-add-sub" action="sublocation/add">
        <div class="modal-header">
          <h5 class="modal-title" id="addRoom">Add Sublocation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="add-room-name">Name</span>
              </div>
              <input type="text" class="form-control" aria-label="Default" id="sublocation-name" name="sublocationName">
              <div id="addsub-error-msg-div" class="error-msg w-100 px-3">
                <p id="addsub-error-msg">Required.</p>
              </div>
              <input type="hidden" id="location_id" name="locationId">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Type</span>
              </div>
              <select id="sublocation-type" name="sublocationType" class="form-control">
                  <option value="">Select</option>
                  <option value="1">Room</option>
                  <option value="2">Floor</option>
                  <option value="4">School Ground</option>
                  <option value="5">Others</option>
              </select>
              <div id="addsubtype-error-msg-div" class="error-msg w-100 px-3">
                <p id="addsubtype-error-msg">Required.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-add">Save</button>
        </div>
      </form>
      
    </div>
  </div>
</div>

<!-- EDIT BUILDING MODAL -->
<div class="modal fade" id="modalEditBuilding" role="dialog" aria-labelledby="editBuilding" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form method="post" id="frm-edit-loc" action="locations/edit">
        <div class="modal-header">
          <h5 class="modal-title" id="addRoom">Edit Building</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text" id="edit-building-name">Building Name</span>
            </div>
            <input type="text" class="form-control" aria-label="Default" id="locationName" name="locationName">
            <div id="editloc-error-msg-div" class="error-msg w-100 px-3">
              <p id="editloc-error-msg">Required.</p>
            </div>
            <input type="hidden" id="location_id" name="locationId">
            <input type="hidden" id="orig-loc-name" name="origLocName" />
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-add">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- EDIT ROOM MODAL -->
<div class="modal fade" id="modalEditRoom" role="dialog" aria-labelledby="editRoom" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form method="post" id="frm-edit-sub" action="sublocation/edit">
        <div class="modal-header">
          <h5 class="modal-title" id="addRoom">Edit Sublocation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="edit-room-name">Name</span>
              </div>
              <input type="text" class="form-control" aria-label="Default" id="sublocation_name" name="sublocationName">
              <div id="editsub-error-msg-div" class="error-msg w-100 px-3">
                <p id="editsub-error-msg">Required.</p>
              </div>
              <input type="hidden" id="location_id" name="locationId">
              <input type="hidden" id="sublocation_id" name="sublocationId">
              <input type="hidden" id="orig-subloc-name" name="origSublocName" />
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Type</span>
              </div>
              <select id="sublocation_type" name="sublocationType" class="form-control">
                  <option value="">Select</option>
                  <option value="1">Room</option>
                  <option value="2">Floor</option>
                  <option value="4">School Ground</option>
                  <option value="5">Others</option>
              </select>
              <div id="editsubtype-error-msg-div" class="error-msg w-100 px-3">
                <p id="editsubtype-error-msg">Required.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-add">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
<?php include 'footer.php'; ?>

<script language="JavaScript">
$(document).ready(function(){

  var noSchoolID = $('#hasNoSchoolID').val();
  
  if (noSchoolID) {
    alert('You need to have School Information Credentials. Set it up now.');
    window.location.replace('schoolinfo');
  }

  setTimeout(function(){$('.alert').removeClass("show")}, 1500);

  $('#add-building').click(function(e){
    $('#text-loc-name').val('');
    $("#addloc-error-msg").html("");
    $("#addloc-error-msg-div").removeClass("d-block");
  });

  $('.edit-building').click(function(e){
    $("#editloc-error-msg").html("");
    $("#editloc-error-msg-div").removeClass("d-block");
  });

  $('.add-room').click(function(e){
    $('#sublocation-name').val('');
    $('#sublocation-type').val('');
    $("#addsub-error-msg").html("");
    $("#addsub-error-msg-div").removeClass("d-block");
    $("#addsubtype-error-msg").html("");
    $("#addsubtype-error-msg-div").removeClass("d-block");
  });

  $('.edit-room').click(function(e) {
    $("#editsub-error-msg").html("");
    $("#editsub-error-msg-div").removeClass("d-block");
    $("#editsubtype-error-msg").html("");
    $("#editsubtype-error-msg-div").removeClass("d-block");
  }); 

  $('#frm-add-loc').submit(function(e){
    var name = $('#text-loc-name').val();
    if (name==""){
      $("#addloc-error-msg").html("Required.");
      $("#addloc-error-msg-div").addClass("d-block");
      e.preventDefault;
      return false;
    }
    return true;
  });

  $('#frm-edit-loc').submit(function(e){
    var name = $('#locationName').val();
    $("#editloc-error-msg").html("");
    $("#editloc-error-msg-div").removeClass("d-block");
    
    if (name==""){
      $("#editloc-error-msg").html("Required.");
      $("#editloc-error-msg-div").addClass("d-block");
      e.preventDefault;
      return false;
    }
    return true;
  });

  $('#frm-add-sub').submit(function(e){
    var name = $('#sublocation-name').val();
    var type = $('#sublocation-type').val();

    $("#addsub-error-msg").html("");
    $("#addsub-error-msg-div").removeClass("d-block");
    $("#addsubtype-error-msg").html("");
    $("#addsubtype-error-msg-div").removeClass("d-block");

    if (name == '' || type == '') {
      if (name =='') {
        $("#addsub-error-msg").html("Required.");
        $("#addsub-error-msg-div").addClass("d-block");
      }
      if (type == '') {
        $("#addsubtype-error-msg").html("Required.");
        $("#addsubtype-error-msg-div").addClass("d-block");
      }
      e.preventDefault();
      return false;
    } 

    return true;
  });


  $('#frm-edit-sub').submit(function(e){
    var name = $('#sublocation_name').val();
    var type = $('#sublocation_type').val();

    $("#editsub-error-msg").html("");
    $("#editsub-error-msg-div").removeClass("d-block");
    $("#editsubtype-error-msg").html("");
    $("#editsubtype-error-msg-div").removeClass("d-block");

    if (name == '' || type == '') {
      if (name =='') {
        $("#editsub-error-msg").html("Required.");
        $("#editsub-error-msg-div").addClass("d-block");
      }
      if (type == '') {
        $("#editsubtype-error-msg").html("Required.");
        $("#editsubtype-error-msg-div").addClass("d-block");
      }
      e.preventDefault();
      return false;
    } 

    return true;
  });

  $('#modalAddRoom').on('show.bs.modal', function (event) {
      var elem = $(event.relatedTarget); // Button that triggered the modal
      var id = elem.data('building'); // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this);
      modal.find('#location_id').val(id)
  });

  $('#modalEditBuilding').on('show.bs.modal', function (event) {
      var elem = $(event.relatedTarget); // Button that triggered the modal
      var id = elem.data('building'); // Extract info from data-* attributes
      var name = elem.data('name');
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this);
      modal.find('#location_id').val(id);
      modal.find('#locationName').val(name);
      modal.find('#orig-loc-name').val(name);
  });

  $('#modalEditRoom').on('show.bs.modal', function(event) {
      var elem = $(event.relatedTarget); // Button that triggered the modal
      var name = elem.data('name');
      var id = elem.data('room'); // Extract info from data-* attributes
      var loc = elem.data('building');
      var type = elem.data('type');
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this);
      modal.find('#sublocation_name').val(name);
      modal.find('#orig-subloc-name').val(name);
      modal.find('#sublocation_id').val(id);
      modal.find('#location_id').val(loc);
      modal.find('#sublocation_type').val(type);
  });

});

  
function delete_location(locationId) {
    
  var x = confirm('Are you sure you want to delete this location?');
  if (x) {
    window.location.replace('locations/delete/' + locationId);
  }
}

function delete_sublocation(sublocationId) {
    
  var x = confirm('Are you sure you want to delete this sublocation?');
  if (x) {
    window.location.replace('sublocation/delete/' + sublocationId);
  }
}


</script>