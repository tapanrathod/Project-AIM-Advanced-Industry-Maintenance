<?php

include 'header.php';
?>
<head>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script> 
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/jquery-ui.min.js"></script><link rel='stylesheet' href='styles.css' type='text/css' media='all' />

</head>
<body>
    

    <div class="clear-fix col-lg-2 card" style="margin-left: 320px;margin-top: 100px;background: #fff">
      <div class="header">
        <h4><i class="material-icons" style="float: left;font-size: 21px;margin-top: -2px;">lock</i>Add Access Level</h4>
  </div>
  <div class="body">
      <form action="<?= site_url('Admin/chose_access'); ?>" method="post" action="">
                               

                                 <div class="form-group form-float">
                                    <div class="form-line">
                                        <label>Department</label>
                                        <select name="dept" id="dept" >
                                            <?php

                                            $ds = $this->db->get('department')->result();

                                            foreach($ds as $d):{
                                                ?>

                                            <option  value="<?=$d->id?>"><?=$d->title?> 
                                            </option>

                                            <?php
                                            }endforeach;
                                            ?>
                                        </select>
                                    </div><br>
                                    <div class="form-line" id="level">
                                        
                                    </div><br>

                                     <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="access" placeholder="Level"  required>
                                        
                                    </div>
                                  </div>
                                </div>

                               

                                <input type="text" value="4" name="id" class="sr-only">
                                <button class="btn btn-primary waves-effect" type="submit" id="update_dept4" data-dismiss="modal" > SUBMIT  </button>
                                <br>
                            </form>
 <script type="text/javascript">
                                    $(document).ready(function(){
                                        $("#dept").change(function(){
                                          var data = $("#dept").val();
                                          $.ajax({
                                              url:'<?=site_url("Admin/choose_desg");?>',
                                              type:'post',
                                              data:'data='+data,
                                              success:function(data){
                                                $("#level").html(data);
                                              }
                                          });
                                        });
                                    });
                                </script>

  </div>
  </div>


  <div class="clear-fix col-lg-3 card" style="margin-left:100px;margin-top: 100px;background: #fff;padding-left: 0px;">
      <div class="header">
          <h4>Access Level</h4>
      </div>
      
      <div class="body" style="padding-left: 0px;">
          
<ul id="test-list" style="list-style: none;"> 
    
    <?php

        foreach($data as $d):{

            ?>

    <li id="listItem_<?= $d->id?>" class="col-lg-12" style="border-bottom: solid 1px lightgrey;cursor: pointer;float: left;margin-top: 0px;padding-bottom: 5px;padding-top: 5px;"> 
       <div class="panel-heading  handle" alt="move" >

       <?php
        $this->db->where('id',$d->designation);
        $level = $this->db->get('designation_level')->result();
        foreach($level as $l):{
            ?>

               <div class="pull-left btn btn-circle btn-<?=$l->color?>">
                 <i class="material-icons">person</i>
               </div>
               <strong style="margin-left: 10px;margin-top: 10px;" class="pull-left"><?=$l->title?></strong>
            <?php 
        }endforeach;
        ?>
               
       </div> 

    </li> 

    

    <?php
        }endforeach;

    ?>


</ul> 

      </div>
  </div>
    <script type="text/javascript"> 
    // When the document is ready set up our sortable with it's inherant function(s) 
    $(document).ready(function() { 
        $("#test-list").sortable({ 
            handle : '.handle', 
            update : function () { 
                var order = $('#test-list').sortable('serialize'); 
                $.ajax({
                    url:'<?=site_url("Admin/data");?>',
                    type:"post",
                    data:'listitem='+order,
                    success:function(data){
                    }
                });
               // $("#info").load("<?= site_url('Admin/data');?>").fadeIn(); 
            } 
        }); 
    }); 
</script>
</body>




 
<?php

//include 'footer.php';
?>