<?php
	include 'header.php';
?>
<head>
	<style type="text/css">
	#trash{
      margin-left: 330px;margin-top: 100px;
    }
		#data{
			animation-name: bounceInDown;
			animation-duration: 1s;
		}

		@media (max-width: 767px) {
  #trash{
    margin-left: 0px;margin-top: 0px;
  }

		@media (max-width: 900px) {
  #trash{
    margin-left: 0px;margin-top: 0px;
  }

		@media (max-width: 1100px) {
  #trash{
    margin-left: 0px;margin-top: 0px;
  }
	
</style>
</head>


	<div class="card col-lg-7 col-md-12 col-xs-12 col-sm-12" id="trash">
		<div class="header">
			<h4>Trash Detail <button class="btn btn-danger pull-right" id="clearAll">Clear ALL</button></h4>
		</div>
		<div class="body" style="padding-right: 0px;padding-left: 0px;" id="content">
			<div class="col-lg-12" id="progress" style="display: none;">
				<div class="col-lg-7">
					 <strong class="msg">Removing files</strong>
                                                <big class="pull-right" id="status">0%</big>
                                            </h6>
                                            <div class="progress" style="height: 10px;">
                                                <div class="progress-bar bg-red progress-bar-striped active" id="myBar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                                </div>
                                            </div>
				</div>
			</div>


			<form method="post" id="myForm" >

			<?php

			  $this->db->where('trash','1');
          $data = $this->db->get('files');
          $files = $data->result();
        foreach($files as $d):{
             switch ($d->color) {
                                                    case '1':
                                                        $color = 'red';
                                                        break;

                                                        case '2':
                                                        $color = 'green';
                                                        break;
                                                        case '3':
                                                        $color = 'light-blue';
                                                        break;
                                                        case '4':
                                                        $color = 'orange';
                                                        break;
                                                        case '5':
                                                        $color = 'pink';
                                                        break;
                                                        case '6':
                                                        $color = 'purple';
                                                        break;
                                                        case '7':
                                                        $color = 'light-green';
                                                        break;
                                                        case '8':
                                                        $color = 'blue';
                                                        break;
                                                        case '9':
                                                        $color = 'indigo';
                                                        break;
                                                    
                                                    default:
                                                        # code...
                                                        break;
                                                }




                                             

            ?>

            <div class="col-lg-3 col-xs-12 col-sm-12 col-md-12" style="border:solid 1px lightgrey;padding: 10px;margin: 2px;" id="data">
        <div style="    float: left;
    border-radius: 100%;
    height: 40px;
    width: 40px;

    padding: 8px;" class="bg-<?=$color ?>">
          <?php
              switch ($d->type) {
                    case 'folder':
                     echo '<i class="material-icons">folder</i>';
                      break;

                      case 'pdf':
                     echo '<i class="material-icons">picture_as_pdf</i>';
                      break;

                      case 'zip':
                     echo '<i class="material-icons">message</i>';
                      break;

                      case 'txt':
                     echo '<i class="material-icons">insert_drive_file</i>';
                      break;

                      case 'video':
                     echo '<i class="material-icons">video_library</i>';
                      break;


                      case 'audio':
                     echo '<i class="material-icons">library_music</i>';
                      break;
                    
                     case 'other':
                     echo '<i class="material-icons">library_books</i>';
                      break;

                       case 'img':
                     echo '<i class="material-icons">photo</i>';
                      break;
                    
                    default:
                      # code...
                      break;
                  }

?>
        </div>
        <div class="pull-left">
          <h5 style="margin-left: 10px;"><?= substr($d->title,0,18); ?></h5>
          <span style="margin-left: 10px;"><?=$d->type ?>  <strong>
            
              <?php
                                              $bytes = $d->size;
                                               if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        echo $bytes;

        ?>

          </strong></span>
        <hr>
        <button class="btn btn-info btn-xs"  data-toggle="modal" data-target="#<?= $d->id?>restore" ><i class="material-icons">access_time</i></button>
        <button class="btn btn-danger btn-xs" style="margin-left: 10px;" data-toggle="modal" data-target="#<?= $d->id?>delete"><i class="material-icons">delete_forever</i></button>
       
        </div>
      </div>




  <!-- Modal -->
  <div class="modal fade" id="<?= $d->id?>delete" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remove Forever <?= $d->title?></h4>
        </div>
        <div class="modal-body">
          <h3 class="text-center">Are You Sure ?</h3><br>
        <form method="post" action="<?= site_url('Admin/remove_media'); ?>">
              <input type="text" value="<?= $d->id;?>" name="id" class="sr-only">
               <input type="text" value="<?= $d->type;?>" name="type" class="sr-only">
                  <input type="text" value="<?= $d->file;?>" name="path" class="sr-only">
          <button class="btn btn-success" id="delete_level"   type="submit" style="margin-left: 35%;">Yeah Sure !</button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>

        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>


   <!-- Modal -->
  <div class="modal fade" id="<?= $d->id?>restore" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="material-icons" style="float: left;font-size: 23px;margin-top: 0px;">access_time</i>  Restore <?=$d->title?> </h4>
        </div>
        <div class="modal-body">
          <h3 class="text-center">Are You Sure ?</h3><br>
        <form method="post" action="<?= site_url('restore_media'); ?>">
              <input type="text" value="<?= $d->id;?>" name="id" class="sr-only">
          <button class="btn btn-success" id="delete_level"  type="submit" style="margin-left: 35%;">Yeah Sure !</button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>

        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  <?php
          }endforeach;
					
			?>

</form>





		</div>
	</div>
<script type="text/javascript">
	$(document).ready(function(){
		
		$("#check").click(function(){
			$.ajax({
					url:'<?= site_url("Admin/check_delete");?>',
					type:'post',
					data:$("#myForm").serialize(),
					success:function(data){
						alert(data);
					}
			});
		});


		$("#clearAll").click(function(){


			var v = 'delete';
			$.ajax({
					url:'<?=site_url('Admin/clearAll')?>',
					type:'post',
					data:v,
					success:function(data){
			$("#progress").fadeIn();
					  setInterval(function(){$("#progress").fadeOut();},6000);

var elem = document.getElementById("myBar");
var status = document.getElementById("status");   

  var width = 1;
  var id = setInterval(frame, 30);

  $(".msg").css('font-size','20px');

  function frame() {
    if (width >= 100) {
        $(".msg").html('All Data Cleared..!');
       
            window.location.href="<?= site_url('Admin/trash'); ?>";        
                    

      clearInterval(id);
    } else {
      width++; 
      elem.style.width = width + '%';
      $("#status").html(elem.style.width); 

    }

    if(width>=0){
        $(".msg").html('Got Your Trash Request');
    }
     if(width>=45){
        $(".msg").html('Collecting Trash Data');
    }
     if(width>=75){
        $(".msg").html('Removing Files..');

    }
     if(width>=95){
        $(".msg").html('Almost There..! ');

    }
  }
					}
			});
		})
		
	});
</script>
<?php
	include 'footer.php';
?>