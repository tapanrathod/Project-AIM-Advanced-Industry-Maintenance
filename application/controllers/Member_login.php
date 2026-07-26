<?php

class Member_login extends CI_Controller{

	public function index(){
		$this->load->view('Member_login');
	}

  public function redirect(){
    redirect('Member_login/index');
  }
  

	
        
        public function client_login()
        {
          $email = $this->input->post('username');
          $pass = $this->input->post('password');

          $data = $this->Crud->member_login($email,$pass);

          $count = count($data);

          if ($count>0) {
               
           
           foreach($data as $c):
            {

            	$dept = $c->department_id;
            	$design = $c->designation_id;


            	$this->db->where('department',$dept);
            	$this->db->where('designation',$design);
            	$access_level = $this->db->get('access_level')->result();


              echo $c->fname.' '.$c->lname;
             
              $newdata = array(
                'user'=>$c->id,
                'login' => TRUE,
                'username'=>$c->fname.' '.$c->lname,
                'email'=>$c->email,
                'img'=>$c->img,
                'access'=>$c->access
            );
              date_default_timezone_set("Asia/Kolkata");
              $date = date('d/m/Y');
              $time = date('h:i');
              $user = ['user'=>$c->id,'date'=>$date,'login'=>$time];
              
              $this->db->where('date',$date);
              $this->db->where('user',$c->id);
              $employee = $this->db->get('employee_log')->result();

              if (count($employee)>0) {
                //do something
              }else{
                $this->Crud->login_log($user);
              }


            $this->session->set_userdata($newdata);
            }endforeach;
             
  
           
          }else{
            echo "Failed";
          }

        }

        public function choose_desg(){
          ?>
           
              <label>Designation</label>
                                      

                                  <?php



                                  $total = $this->input->post('data');


                                  $this->db->where('level',$total);
                                  $level = $this->db->get('designation_level');
                                  $level = $level->result();
                                  ?>
                                      <select name="level">

                                        <?php
                                  foreach($level as $l):{
                                    ?>
                                            <option value="<?=$l->id?>"><?=$l->title?>
                                            </option>
                                    <?php
                                  }endforeach;

                                  ?>
                                        </select>

                                        <?php
        }

        public function chose_access(){
         $data = ['department'=>$this->input->post('dept'),
          'designation'=> $this->input->post('level'),
          'access_level' => $this->input->post('access')];

          $this->db->insert('access_level',$data);

          redirect('Member_login/access_level');
        }

          public function clearAll(){

              $this->db->where('trash','1');
              $data = $this->db->get('files')->result();

                foreach($data as $d):{

              $this->Crud->remove_media($d->id);

                }endforeach;
            }

        public function data(){
        
        foreach ($_POST['listItem'] as $position => $item)
{
    $sql[] = "UPDATE `table` SET `access_level` = $position WHERE `id` = $item"; 

    $data = ['access_level'=>$position];
    $this->Crud->sort_level($data,$item);
}
print_r ($sql); 
       
        }



               public function share_download(){
            $id = $this->input->post('id');

            $this->db->where('id',$id);
           $r =  $this->db->get("share");
            $data = $r->result();

            foreach($data as $d):
            {

                header('content-Disposition: attachment; filename = '.$d->file.'');
                header('content-type:application/octent-strem');
                header('content-length='.filesize($d->file));
                readfile($d->file);
              //  echo $d->file;
            }
          endforeach;
            }

        public function create_file(){


  $str = str_shuffle('123456789');
  $color = substr($str,0,1);
  $title = $this->input->post('filename').'.txt';

  $date = date('d-m-Y');

  $content = $this->input->post('content');



  $open =  fopen('assets/vaibhav123/file/'.$title.'.txt','w');



  $path = 'assets/vaibhav123/file/'.$title.'.txt'; 

  fwrite($open,$content);

$data = ['type'=>'txt',
          'title'=>$title, 
          'file'=>$path,
          'date'=>$date,
          'color'=>$color,
          'size'=>filesize($path),
           'access'=>$this->session->userdata('access')
        ];

        $this->Crud->create_file($data);

        }


        public function restore_media(){
        	$data = ['trash'=>'0'];
        	$id = $this->input->post('id');
        	$this->db->where('id',$id);
        	$this->db->update('files',$data);
        	redirect('Member_login/trash');

        }

        public function trash(){
          $this->load->view('Member/trash');
        }

        public function send_trash(){
        	$id = $this->input->post('id');
        	$data = ['trash'=>'1'];

        	$this->db->where('id',$id);
        	$this->db->update('files',$data);
        }

        public function trash_data(){
        	$access = $this->session->userdata('access');
          $this->db->where('access <=',$access);
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
        <form method="post" action="<?= site_url('Member_login/remove_media'); ?>">
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
        <form method="post" action="<?= site_url('Member_login/restore_media'); ?>">
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
        }

          public function create_folder(){


  $str = str_shuffle('123456789');
  $color = substr($str,0,1);
  $title = $this->input->post('folder');

  $date = date('d-m-Y');



  $path = 'assets/vaibhav123/file/'.$title; 

  mkdir($path);
 

$data = ['type'=>'folder',
          'title'=>$title, 
          'file'=>$path,
          'date'=>$date,
          'color'=>$color,
          'size'=>filesize($path),
          'access'=>$this->session->userdata('access')

        ];

        $this->Crud->create_folder($data);

        }

     

        public function search(){


         $input =  $this->input->post('searching');


      $this->db->like('title',$input);
      $this->db->or_like('type',$input);
      $this->db->or_like('date',$input);
      $data = $this->db->get('files');
      $data =  $data->result();
      $count = count($data);

              if ($count>0) {
                foreach($data as $d):{

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


                    <div class="col-lg-8" style="margin-top: 10px;animation-duration: 1s;animation-name: bounceInDown;" >
                         <div class="icon-circle bg-<?= $color ?> pull-left" style="height: 50px;width: 50px;border-radius: 100%;padding: 13px;">
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
                     <div class="pull-left" style="margin-left: 10px;"><strong><?= $d->title ?></strong>
                       <br><span style="margin-top: 5px;font-size: 12px;" class="pull-left"><?= $d->type ?> File</span>
                       <span style="margin-top: 5px;font-size: 12px;margin-left: 10px;" class="pull-left"><b>
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


                       </b></span>
                        </div>

                     <div class="pull-right" style="margin-left: 10px;margin-top: 22px;">
                       <label>By 

                        <?php

                          $this->db->where('id',$d->uploader);
                          $user = $this->db->get('user')->result();

                          foreach($user as $u):{
                            echo $u->fname.' '.$u->lname;

                               $this->db->where('id',$u->department_id);
                  $design =   $this->db->get('department')->result();

                  foreach($design as $e):{
                    echo '('.$e->title.' - ';
                  }endforeach;


                    $this->db->where('id',$u->designation_id);
                  $design =   $this->db->get('designation_level')->result();

                  foreach($design as $e):{
                    echo $e->title.')';
                  }endforeach;
                    
                          }endforeach;
                        ?>

                        on <?=$d->date ?></label>
                    </div>
                    </div>



            <?php
          }
        endforeach;


              }else{


      $this->db->like('fname',$input);
      $this->db->or_like('lname',$input);
      $this->db->or_like('email',$input);
      $pankti = $this->db->get('user');

      $c = count($pankti);

      if ($c>0) {

      $pankti =  $pankti->result();


         foreach($pankti as $d):{

             
                                              


            ?>


                    <div class="col-lg-8" style="margin-top: 10px;animation-duration: 1s;animation-name: bounceInDown;" >
                         <div class="icon-circle bg-light-blue pull-left" style="height: 50px;width: 50px;border-radius: 100%;padding: 13px;">
                       <i class="material-icons">person</i>
                     </div>
                     <div class="pull-left" style="margin-left: 10px;"><strong><?= $d->fname.' '.$d->lname ?></strong>
                       <br><span style="margin-top: 5px;font-size: 12px;" class="pull-left"><?= $d->gender ?> </span>
                       <span style="margin-top: 5px;font-size: 12px;margin-left: 10px;" class="pull-left"><b>
                      <i class="material-icons" style="font-size: 15px;float: left;margin-top: 3px;">email</i>&nbsp;  <?=$d->email; ?>


                       </b></span>
                        </div>

                     <div class="pull-right" style="margin-left: 10px;margin-top: 22px;">
                       <label><i class="material-icons" style="font-size: 15px;float: left;margin-top: 3px;">call</i>&nbsp; 

                      <?=$d->mobile ?></label>
                    </div>
                    </div>



            <?php
          }
        endforeach;


            
        
      }else{


      $this->db->like('title',$input);
      $this->db->or_like('type',$input);
      $this->db->or_like('date',$input);
      $data = $this->db->get('share');
      
      $count = count($data);

      if ($count>0) {

        $data =  $data->result();


       foreach($data as $d):{

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


                    <div class="col-lg-8" style="margin-top: 10px;animation-duration: 1s;animation-name: bounceInDown;" >
                         <div class="icon-circle bg-<?= $color ?> pull-left" style="height: 50px;width: 50px;border-radius: 100%;padding: 13px;">
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
                     <div class="pull-left" style="margin-left: 10px;"><strong><?= $d->title ?></strong>
                       <br><span style="margin-top: 5px;font-size: 12px;" class="pull-left"><?= $d->type ?> File</span>
                       <span style="margin-top: 5px;font-size: 12px;margin-left: 10px;" class="pull-left"><b>
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


                       </b></span>
                        </div>

                     <div class="pull-right" style="margin-left: 10px;margin-top: 22px;">
                       <label>By 

                        <?php

                          $this->db->where('id',$d->sender);
                          $user = $this->db->get('user')->result();

                          foreach($user as $u):{
                            echo $u->fname.' '.$u->lname;
                          }endforeach;
                        ?>

                        on <?=$d->date ?></label>
                    </div>
                    </div>



            <?php
          }
        endforeach;



      }else{
        ?>
        <h3 class="text">No Data Found..!</h3>
        <?php
      }

               
              }
        
        }
      }


        public function user_detail(){

            $login = $this->session->has_userdata('login');

            if ($login==TRUE) {
               $user = $this->session->userdata('user');
                $data = $this->Crud->get_my_profile($user);

                foreach($data as $d):{
                  
                   ?>

                   <div class="image">
                    <img src="<?= base_url('assets/images/'.$d->img); ?>" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="email" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $d->fname.' '.$d->lname; ?> <?php

                    $this->db->where('id',$d->designation_id);
                  $design =   $this->db->get('designation_level')->result();

                  foreach($design as $e):{
                    echo '('.$e->title.')';
                  }endforeach;
                    ?></div>
                    <div class="email"><?= $d->email; ?> </div>

                   

                <?php

                }endforeach;
                
                         }else{
              echo '404';
            }
          }


        public function compress_file(){

          $file_name = $this->input->post('path');
  
$output = $file_name.".zip";

file_put_contents("compress.zlib://$output", file_get_contents($file_name));
          


  $str = str_shuffle('123456789');
  $color = substr($str,0,1);

$date = date('d-m-Y');
  
  $title = $this->input->post('title');
$data = ['type'=>'zip',
          'title'=>$title.'.zip', 
          'file'=>$output,
          'date'=>$date,
          'size'=>filesize($output),
          'color'=>$color
        ];


        $this->Crud->compress_file($data);



        }
        
         
         public function dashboard()
        {
           $login = $this->session->has_userdata('login');

           if ($login==TRUE) {
             

          $this->load->view('Member/dashboard');
            
           }else{
            echo "404";
           }
        }

        public function counter(){
           $person = $this->session->userdata('user');
            
            $data =  $this->Crud->notification($person);
              	
              	
              echo count($data);
        }

        public function notification(){
          $person = $this->session->userdata('user');
            
            $data =  $this->Crud->notification($person);


            foreach($data as $d):{

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




              $m_date =$d->date;
              $m_day = substr($m_date, 0,2);
              $m_month = substr($m_date, 3,2);
              $m_year = substr($m_date, 6,4);
              $c_date =date('d-m-Y'); 
               $c_day = substr($c_date, 0,2);
              $c_month = substr($c_date, 3,2);
              $c_year = substr($c_date, 6,4);
              ?>
               <li style="padding: 6px;">
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-<?= $color ?>">

                                              <?php

                                                switch ($d->type) {
                                                    case 'pdf':
                                                        
                                                   echo '<i class="material-icons">insert_drive_file</i>';

                               
                                                        break;

                                                        case 'folder':
                                                          
                                                    echo '<i class="material-icons">folder</i>';

                                                        break;
                                                        
                                                case 'other':
                                              
                                   
                                                   echo '<i class="material-icons">library_books</i>';

                                                        break;

                                                         case 'txt':
                                             
                                                   echo '<i class="material-icons">attach_file</i>';

                                              break; 

                                                         case 'video':
                                                      echo ' <i class="material-icons">video_library</i>';
                           ;
                                                        break;     

                                                         case 'audio':
                                                  
                                                  echo ' <i class="material-icons">library_music</i>';

                                  
                                                        break;                                                        
                                                    
                                                        case 'zip':
                                            

                                                  echo ' <i class="material-icons">message</i>';

                               
                             
                                                            break;



                                                     case 'img':
                                                  echo ' <i class="material-icons">photo</i>';
                                                          
                                                        break;                                                        
                                                    default:


                                                        # code...
                                                        break;
                                                }
                                                ?>
                                              </div>
                                            <div class="menu-info">
                                                <h4><?php
                                                $this->db->where('id',$d->sender);
                                                $user = $this->db->get('user');
                                                $user= $user->result();
                                                
                                                foreach($user as $u):{

                                                  echo $u->fname.' shared a '.$d->type.' file with you';
                                                }endforeach;

                                                ?>
                                                </h4>
                                                <p>
                                               
                                                    <i class="material-icons">access_time</i> 

                                                    <?php

                                                        if ($c_year==$m_year) {
                                                                
                                                                if ($c_month==$m_month) {
                                                                        
                                                                        if ($c_day==$m_day) {
                                                                          echo 'Today';
                                                                        }else{
                                                                            echo $c_day-$m_day.' day ago';

                                                                          }
                                                                }else{
                                                                  echo $c_month-$m_month.' month ago';
                                                                }
                                                        }else{
                                                          echo $c_year-$m_year.' year ago';
                                                        }
                                                    ?>
                                                </p>
                                            </div>
                                        </a>
                                    </li>

                                    <?php
            }
          endforeach;
            
        }

        public function move_file(){

            $data =  $this->input->post('file');
            $folder = $this->input->post('folder');


            
           
            $sql = explode(':',$folder);

           $folder_id = $sql['1'];

           $title = $this->input->post('title');
           $sourcePath = $data;

           $targetPath = $sql['0'].'/'.$title;

      rename($sourcePath,$targetPath);


           
          

           $d = ['move'=>'1',
                  'folder'=>$folder_id,
                  'file'=>$targetPath
                ];
                $id = $this->input->post('id');

           $this->Crud->move_file($d,$id);

           echo $title.' moved successfully...';
        }

      
       

        public function ajax_profile_pic(){
          $user = $this->session->userdata('user');
            $data = $this->Crud->get_my_profile($user);


    foreach($data as $d):
    {

        ?>
        <img src="<?= base_url('assets/images/'.$d->img); ?>" onclick="chooseFile()" style="cursor: pointer; height: 300px;width:300px;margin-left:50px;" class="image" >
    <input type="text" value="<?=$d->id?>" name="id" class="sr-only">

        <input type="submit" name="upload" id="upload" value="UPLOAD" class="btn btn-primary">
        <?php

    }
endforeach;
  

        }

        public function shared_with(){
            $access = $this->session->userdata('access');

            $files = $this->db->get('share')->result();

            $count = count($files);

          $this->load->view('Member/shared_with',['files'=>$files,'count'=>$count]);
        }

   

        public function change_profile_pic(){

if(is_array($_FILES)) {
if(is_uploaded_file($_FILES['fileInput']['tmp_name'])) {
$sourcePath = $_FILES['fileInput']['tmp_name'];
$targetPath = "assets/images/".$_FILES['fileInput']['name'];

$target_file = $targetPath . basename($_FILES["fileInput"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


if ($imageFileType!='jpg' && $imageFileType!='jpeg' && $imageFileType!='png' && $imageFileType!='gif') {
  echo "Some Error Occured while uploading this file";
}else{
  

  move_uploaded_file($sourcePath,$targetPath);

  $id = $this->input->post('id');

  $data = ['img'=>
  $img = $_FILES['fileInput']['name']

];

  $this->Crud->update_pic($id,$data);

}

}
}
            
        }

       
        public function media()
        {
        	$access = $this->session->userdata('access');

            $files = $this->Crud->select_client_media($access);
            $users = $this->Crud->select_user();

            $this->load->view('Member/media',['files'=>$files,'users'=>$users]);
        }
        public function remove_media(){
          

          $id = $this->input->post('id');

          $file = $this->input->post('path');

          $type = $this->input->post('type');

          $this->Crud->remove_media($id);

          if ($type=='folder') {
              rmdir($file);
              redirect('Member_login/trash');        
          }else{
              unlink($file);
              redirect('Member_login/trash');
          }



        }
        public function ajax_media(){
                

             $access = $this->session->userdata('access');

            $files = $this->Crud->select_client_media($access);

                                       $i = 1;
                                         foreach($files as $file):
                                            {


                                              if ($file->folder!='0') {
                                               
                                              }else{



                                                switch ($file->color) {
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

                                                switch ($file->type) {
                                                    case 'pdf':
                                                $data = '<div class="btn  bg-'.$color.'" style:"cursor:context-menu;" ><i class="material-icons">picture_as_pdf</i></div>';
                                                        
                                                  $change = ' <li><a href=""><i class="material-icons">library_books</i>

                                <form method="post" action="'.site_url('Member_login/download').'" >
                                                <input type="text" value="'.$file->id.'" name="id" class="sr-only">
                                             <button type="submit" class="btn btn-primary btn-xs"> Download  </button>
                                            </form>
                            </li>';     
                                                        break;

                                                        case 'folder':
                                                 $data = '<div class="btn  bg-'.$color.'" data-toggle="modal" data-target="#img'.$file->id.'"  style:"cursor:context-menu;" ><i class="material-icons">folder</i></div>';
                                            
                                                   $change = ' <li><a href="#"><i class="material-icons">library_books</i>

                                
                                                

                                             <button type="button" data-toggle="modal" data-target="#compress'.$file->id.'"  class="btn btn-primary btn-xs"> Compress  </button></a>
                                        
                            </li>';    
                                                        break;
                                                        
                                                case 'other':
                                                $data = '<div class="btn  bg-'.$color.'" style:"cursor:context-menu;" ><i class="material-icons">message</i></div>';
                                   
                                                  $change = ' <li><a href=""><i class="material-icons">library_books</i>

                                <form method="post" action="'.site_url('Member_login/download').'" >
                                                <input type="text" value="'.$file->id.'" name="id" class="sr-only">
                                             <button type="submit" class="btn btn-primary btn-xs"> Download  </button>
                                            </form>
                            </li>';     
                                                        break;

                                                         case 'txt':
                                                $data = '<div class="btn  bg-'.$color.'" style:"cursor:context-menu;"  data-toggle="modal" data-target="#img'.$file->id.'" ><i class="material-icons">insert_drive_file</i></div>';
                                   
                                                  $change = ' <li><a href=""><i class="material-icons">library_books</i>

                                <form method="post" action="'.site_url('Member_login/download').'" >
                                                <input type="text" value="'.$file->id.'" name="id" class="sr-only">
                                             <button type="submit" class="btn btn-primary btn-xs"> Download  </button>
                                            </form>
                            </li>';
                                                        break; 

                                                         case 'video':
                                                $data = '<div class="btn  bg-'.$color.'" style:"cursor:context-menu;" data-toggle="modal" data-target="#img'.$file->id.'"  ><i class="material-icons">video_library</i></div>';
                                                        
                                                 $change = ' <li><a href=""><i class="material-icons">library_books</i>

                                <form method="post" action="'.site_url('Member_login/download').'" >
                                                <input type="text" value="'.$file->id.'" name="id" class="sr-only">
                                             <button type="submit" class="btn btn-primary btn-xs"> Download  </button>
                                            </form>
                            </li>';
                                                        break;     

                                                         case 'audio':
                                                $data = '<div class="btn  bg-'.$color.'" style:"cursor:context-menu;"  data-toggle="modal" data-target="#img'.$file->id.'" ><i class="material-icons">library_music</i></div>';
                                                    
                                                 $change = ' <li><a href=""><i class="material-icons">library_books</i>

                                <form method="post" action="'.site_url('Member_login/download').'" >
                                                <input type="text" value="'.$file->id.'" name="id" class="sr-only">
                                             <button type="submit" class="btn btn-primary btn-xs"> Download  </button>
                                            </form>
                            </li>';   
                                                        break;                                                        
                                                    
                                                        case 'zip':
                                                $data = '<div class="btn bg-'.$color.'" style:"cursor:context-menu"><i class="material-icons">message</i></div>';
                                            

                                                 $change = ' <li><a href=""><i class="material-icons">library_books</i>

                               
                                <form method="post" action="'.site_url('Member_login/download').'" >
                                                <input type="text" value="'.$file->id.'" name="id" class="sr-only">
                                             <button type="submit" class="btn btn-primary btn-xs"> Download  </button>
                                            </form>
                            </li>';  
                                                            break;
                                                    default:



                                                     case 'img':
                                                $data = '<img src="'.base_url($file->file).'" data-toggle="modal" data-target="#img'.$file->id.'" style="height:50px;width:50px;cursor:pointer">';
                                                        
                                                        break;                                                        
                                                    default:


                                                        # code...
                                                        break;
                                                }




                                                    ?>


                                                <tr>
                                            <td>
                                                

                                    <?=$i ?>
                                            </td>
                                            <td><?= $data ?></td>
                                            <td><?= substr($file->title,0,32) ?></td>
                                            <td><?= formatSizeUnits($file->size); ?></td>
                                            <td><?= $file->date ?></td>
                                        

                                            <td>
                                          
  
                                    

                                         <div class="btn-group">
                        <button class="btn btn-default" data-toggle="dropdown" aria-haspopup="true" style="cursor: pointer;" aria-expanded="true"><i class="material-icons" d>view_week</i></button>
                        <ul class="dropdown-menu pull-right">
                           <?= $change ?>
                            <li role="seperator" class="divider"></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">share</i><button class="btn btn-success btn-xs" data-toggle="modal" data-target="#share<?= $file->id ?>" >Share</button></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">font_download</i><button data-toggle="modal" data-target="#rename<?= $file->id ?>" class="btn btn-warning btn-xs">Rename</button></a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">move_to_inbox</i><button data-toggle="modal" data-target="#move<?= $file->id ?>" class="btn btn-xs btn-info">Move</button></a></li>
                            <li role="seperator" class="divider"></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">delete</i><button class="btn btn-danger btn-xs"  data-toggle="modal" data-target="#delete<?= $file->id ?>" >Trash</button></a></li>
                        </ul>
                    </div>
                                       
                               
</td>
                                            
                                        </tr>

                                         



  <!-- Modal -->
  <div class="modal fade" id="delete<?= $file->id ?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Trash <?= $file->title?></h4>
        </div>
        <div class="modal-body">
          <h3 class="text-center">Are You Sure ?</h3><br>
        <form method="post" action="" id="delete_form<?= $file->id ?>">
              <input type="text" value="<?= $file->id ?>" name="id" class="sr-only">
              <input type="text" value="<?= $file->file ?>" name="path" class="sr-only">

          <button class="btn btn-success" id="delete_level<?= $file->id ?>" data-dismiss="modal"  type="button" style="margin-left: 35%;">Yeah Sure !</button>
        </form>
          <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  <!--Delete End-->





  <!-- Modal -->
  <div class="modal fade" id="compress<?= $file->id ?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="glyphicon glyphicon-archive"></i> Compress <?= $file->title?></h4>
        </div>
        <div class="modal-body">
          <h3 class="text-center">Are You Sure ?</h3><br>
        <form method="post" action="" id="compress_form<?= $file->id ?>">
              <input type="text" value="<?= $file->id ?>" name="id" class="sr-only">
              <input type="text" value="<?= $file->file ?>" name="path" class="sr-only">
               <input type="text" value="<?= $file->title ?>" name="title" class="sr-only">

          <button class="btn btn-success" id="compress<?= $file->id ?>" data-dismiss="modal"  type="button" style="margin-left: 35%;">Yeah Sure !</button>
        </form>
          <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  <!--Delete End-->





  <!-- Modal -->
  <div class="modal fade" id="img<?= $file->id ?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header ">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="material-icons"> pageview</i> View <?= $file->title?></h4>
        </div>
        <div class="modal-body">
          <?php

              if ($file->type=='img') {
                
                ?>


         <img src="<?= base_url($file->file); ?>" class="img-thumbnail">

         <?php
              }else if($file->type=='audio'){
                ?>

<audio controls>
  <source src="<?= base_url($file->file); ?>" type="audio/mp3">
</audio>
                <?php
              }else if($file->type=='txt'){
                $myfile = fopen($file->file, "r") or die("Unable to open file!");
                echo '<p>'.fread($myfile,filesize($file->file)).'</p>';
                fclose($myfile);
              }else if($file->type=='video'){
                ?>

<video width="100%" height="240" controls class="card">
  <source src="<?= base_url($file->file) ?>" type="video/mp4" style="width: 100%; margin: 10px;">
</video>
          <?php
              }else if($file->type=='folder'){


                $this->db->where('folder',$file->id);
                $inner_data = $this->db->get('files');

                $inner_data = $inner_data->result();

                foreach($inner_data as $inner):{

                  $bytes = $inner->size();
                  switch ($inner->type) {
                    case 'folder':
                    $icon = '<i class="material-icons">folder</i>';
                      break;

                      case 'pdf':
                    $icon = '<i class="material-icons">picture_as_pdf</i>';
                      break;

                      case 'zip':
                    $icon = '<i class="material-icons">message</i>';
                      break;

                      case 'txt':
                    $icon = '<i class="material-icons">insert_drive_file</i>';
                      break;

                      case 'video':
                    $icon = '<i class="material-icons">video_library</i>';
                      break;


                      case 'audio':
                    $icon = '<i class="material-icons">library_music</i>';
                      break;
                    
                     case 'other':
                    $icon = '<i class="material-icons">library_books</i>';
                      break;
                    
                    default:
                      # code...
                      break;
                  }


                                                switch ($inner->color) {
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
                  <div class="col-lg-5 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-<?= $color; ?>">
                        <div class="icon">
                        <?= $icon ?>

                                                 </div>
                        <div class="content">
                            <div class="text"><?= $inner->title ?></div>
                            <div class="number count-to" style="font-size: 20px;"><?php

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
                            ?></div>
                        </div>
                    </div>
                </div>

                <?php

                }endforeach;

              }
          ?>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  <!--Delete End-->


  <!--SHARE Modal -->
  <div class="modal fade" id="share<?= $file->id ?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header ">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="glyphicon glyphicon-share"></i> Share <?= $file->title?></h4>
        </div>
        <div class="modal-body">
       <form method="post" id="shareForm<?= $file->id ?>">
         
          <select id="share_user" name="share_user">
            <?php

                foreach($users as $u): {
                  ?>

                  <option value="<?= $u->id ?>" ><?= $u->fname.' '.$u->lname; ?></option>
                  <?php
                } 
              endforeach;
            ?>

          </select>
          <input type="text" name="title" value="<?= $file->title ?>" class="sr-only" >
          <input type="text" name="size" value="<?= $file->size ?>" class="sr-only" >
          <input type="text" name="file" value="<?= $file->file ?>" class="sr-only" >
          <input type="text" name="color" value="<?= $file->color ?>" class="sr-only" >
          <input type="text" name="type" value="<?= $file->type ?>" class="sr-only" >



        <div>
          <br>
          <button type="button" id="shareto<?= $file->id ?>" class="btn btn-info" data-dismiss="modal" >Share</button>
        </div>
       </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  <!--SHARE End-->


  <!--Rename Modal -->
  <div class="modal fade" id="rename<?= $file->id ?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content"> 
        <div class="modal-header ">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="glyphicon glyphicon-share"></i> Rename </h4>
        </div>
        <div class="modal-body">
       <form method="post" id="renameForm<?= $file->id ?>">
         
          <input type="text" id="share_user" name="filename" value="<?= $file->title?>">
          

          <input type="text" name="fileid" value="<?= $file->id ?>" class="sr-only">
        <div>
          <br>
          <button type="button" id="renameto<?= $file->id ?>" class="btn btn-info" data-dismiss="modal" >Save</button>
        </div>
       </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  <!--SHARE End-->




  <!--Move Modal -->
  <div class="modal fade" id="move<?= $file->id ?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header ">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="glyphicon glyphicon-share"></i> Move <?= $file->title?></h4>
        </div>
        <div class="modal-body">
       <form method="post" id="moveForm<?= $file->id ?>">
         <input type="text" name="file" value="<?= $file->file ?>" class="sr-only">


          <select id="share_user" name="folder">
            <?php

                foreach($files as $u): {
                   $type = $u->type;
                  if ($type=='folder' && $u->folder=='0') {
                    ?>

                  <option value="<?= $u->file.':'.$u->id ?>" ><?= $u->title ?>
                    
                    
                  </option>

                  <?php


                  }else{


                  } 
                } 
              endforeach;
            ?>

          </select>
          <input type="text" name="id" value="<?= $file->id ?>" class="sr-only" >
          <input type="text" name="title" value="<?= $file->title ?>" class="sr-only" >
          



        <div>
          <br>
          <button type="button" id="moveto<?= $file->id ?>" class="btn btn-info" data-dismiss="modal" >Move</button>
        </div>
       </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  <!--SHARE End-->

  <script type="text/javascript">
      $(document).ready(function(){
              //AJAX FOR Deletion

    $("#delete_level<?= $file->id ?>").click(function(){
            $.ajax({
                url:'<?= site_url("Member_login/send_trash") ?>',
                type:'post',
                data:$("#delete_form<?= $file->id ?>").serialize(),
                success:function(){
                     $("#ajaxdata").load('<?= site_url("Member_login/ajax_media") ?>');
                      $("#delete_notify").fadeIn('slow');
                setInterval(function(){$("#delete_notify").fadeOut('slow');},6000);

                }
            });
        });       
    });
  </script>



  <script type="text/javascript">
      $(document).ready(function(){
              //AJAX FOR Deletion

    $("#moveto<?= $file->id ?>").click(function(){
            $.ajax({
                url:'<?= site_url("Member_login/move_file") ?>',
                type:'post',
                data:$("#moveForm<?= $file->id ?>").serialize(),
                success:function(data){
                     $("#ajaxdata").load('<?= site_url("Member_login/ajax_media") ?>');

                      $("#move_notify").fadeIn('slow');
                setInterval(function(){$("#move_notify").fadeOut('slow');},6000);

                }
            });
        });       
    });
  </script>



  <script type="text/javascript">
      $(document).ready(function(){
              //AJAX FOR Deletion

    $("#compress<?= $file->id ?>").click(function(){
            $.ajax({
                url:'<?= site_url("Member_login/compress_file") ?>',
                type:'post',
                data:$("#compress_form<?= $file->id ?>").serialize(),
                success:function(data){
                     $("#ajaxdata").load('<?= site_url("Member_login/ajax_media") ?>');

                      $("#compress_notify").fadeIn('slow');
                setInterval(function(){$("#compress_notify").fadeOut('slow');},6000);

                }
            });
        });       
    });
  </script>


  <script type="text/javascript">
      $(document).ready(function(){
              //AJAX FOR Deletion

    $("#shareto<?= $file->id ?>").click(function(){
            $.ajax({
                url:'<?= site_url("Member_login/share_media") ?>',
                type:'post',
                data:$("#shareForm<?= $file->id ?>").serialize(),
                success:function(data){
                     $("#ajaxdata").load('<?= site_url("Member_login/ajax_media") ?>');

                      $("#share_notify").fadeIn('slow');
                      
                setInterval(function(){$("#share_notify").fadeOut('slow');},6000);

                }
            });
        });       
    });
  </script>



  <script type="text/javascript">
      $(document).ready(function(){
              //AJAX FOR Deletion

    $("#renameto<?= $file->id ?>").click(function(){
            $.ajax({
                url:'<?= site_url("Member_login/file_rename") ?>',
                type:'post',
                data:$("#renameForm<?= $file->id ?>").serialize(),
                success:function(data){
                     $("#ajaxdata").load('<?= site_url("Member_login/ajax_media") ?>');

                      $("#rename_notify").fadeIn('slow');
                      
                setInterval(function(){$("#rename_notify").fadeOut('slow');},6000);

                }
            });
        });       
    });
  </script>




                                     
                                                <?php
                                                $i = $i+1;
                                            }


                                          }
                                        endforeach;
                         
                                         

        }


        public function insert_media()
        {
if(is_array($_FILES)) {
if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
$sourcePath = $_FILES['userImage']['tmp_name'];
$targetPath = "assets/vaibhav123/file/".$_FILES['userImage']['name'];



$target_file = $targetPath . basename($_FILES["userImage"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


if ($imageFileType=='exe' || $imageFileType == 'php' || $imageFileType == 'java' || $imageFileType == 'xml' || $imageFileType == 'psd' || $imageFileType == 'sql' || $imageFileType == 'ini' || $imageFileType == 'css' || $imageFileType == 'html' || $imageFileType == 'js' || $imageFileType == 'wmv') {
  echo "Some Error Occured while uploading this file";
}else{
  $type = $imageFileType;
  $size = $_FILES['userImage']['size'];
  $date = date('d-m-Y');
  $title = $_FILES['userImage']['name'];

  switch ($type) {
    case 'jpg':
      $type = 'img';
      break;

       case 'jpeg':
      $type = 'img';
      break;

       case 'png':
      $type = 'img';
      break;

       case 'gif':
      $type = 'img';
      break;

       case 'mp3':
      $type = 'audio';
      break;


       case 'ogg':
      $type = 'audio';
      break;


       case 'mp4':
      $type = 'video';
      break;

       case 'zip':
      $type = 'other';
      break;


       case 'doc':
      $type = 'other';
      break;


       case 'txt':
      $type = 'text';
      break;


       case 'pdf':
      $type = 'pdf';
      break;


       case 'pptx':
      $type = 'other';
      break;

    case 'docx':
      $type = 'other';
      break;    
    default:
      # code...
      break;
  }


  $str = str_shuffle('123456789');
  $color = substr($str,0,1);


$data = ['type'=>$type,
          'title'=>$title, 
          'file'=>$targetPath,
          'date'=>$date,
          'size'=>$size,
          'color'=>$color,
          'access'=>$this->session->userdata('access')
        ];

        $this->db->where('file',$targetPath);
        $exist = $this->db->get('files')->result();

        $count = count($exist);

        if ($count>0) {
            echo "Exists";
        }else{
          move_uploaded_file($sourcePath,$targetPath);
$this->Crud->insert_media($data);
 echo "uploaded";         
  
        }
}
} 
}
}


  public function share_media(){
    $user = $this->input->post('share_user');
    $postid = $this->input->post('file_id');

    $date = date('d-m-Y');

    $sender = $this->session->userdata('user');

    $data = ['title'=>$this->input->post('title'),
            'color'=>$this->input->post('color'),
            'size'=>$this->input->post('size'),
            'file'=>$this->input->post('file'),
            'type'=>$this->input->post('type'),
            'user'=>$sender,
            'sender'=>$sender,
            'date'=>$date
            ];

          $this->db->insert('share',$data);

  }


  public function file_rename(){
    $file = $this->input->post('fileid');
    $name = $this->input->post('filename');

    $files = $this->Crud->get_file($file);
    foreach($files as $f):
      {
        $newname = 'assets/vaibhav123/file/'.$name;
        $oldname = $f->file;
        rename($oldname, $newname); 
        $data =  ['title' => $this->input->post('filename'),
                  'file' => $newname
                 ];
        $id = $this->input->post('fileid');




        $this->Crud->file_rename($data,$id);


      }
    endforeach;


      


        $fname = $this->input->post('filename');
        echo $fname.' moved successfully..';
  }

        public function download(){
            $id = $this->input->post('id');

            $this->db->where('id',$id);
           $r =  $this->db->get("files");
            $data = $r->result();

            foreach($data as $d):
            {

                header('content-Disposition: attachment; filename = '.$d->file.'');
                header('content-type:application/octent-strem');
                header('content-length='.filesize($d->file));
                readfile($d->file);
              //  echo $d->file;
            }
          endforeach;
            }

            public function logout(){
              $user = $this->session->userdata('user');
              date_default_timezone_set("Asia/Kolkata");
              $date = date('d/m/Y');
              $time = date('h:i');
              $data = ['logout'=>$time];
                $this->Crud->logout_log($user,$date,$data);

              $this->session->sess_destroy();
              redirect('Member_login');
            }

  
         public function audio()
        {
             $files = $this->Crud->select_audio();

            $this->load->view('Member/audio',['files'=>$files]);
        }
        public function document()
        {
            $this->load->view('Member/document');
        }

        public function profile(){
          $user = $this->session->userdata('user');

            $data = $this->Crud->get_my_profile($user);
            $this->load->view('Member/profile.php',['data'=>$data]);
        }

        public function ajax_profile()
        {
          $user = $this->session->userdata('user');

            $data = $this->Crud->get_my_profile($user);

            $data = $data->result();

            ?>
             <?php

                            foreach($data as $d):
                            {
                                ?>
                                 <form id="form_validation" method="post" action="<?= site_url('Member_login/insert_user'); ?>">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" value="<?= $d->fname?>" name="fname" required>
                                        <label class="form-label">First Name</label>
                                    </div>
                                </div>


                                 <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" value="<?= $d->lname; ?>" name="lname" required>
                                        <label class="form-label">Last Name</label>
                                    </div>
                                </div>

                                   <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" value="<?= $d->email ?>" name="email" required>
                                        <label class="form-label">Email</label>
                                    </div>
                                </div>

                                <!--
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label>Department</label>
                                                    <select name="dept" required>
                                                      
                                                        <option value="" ><?= $d->department_id ?></option>


                                                           
                                                    </select>

                                    </div>
                                </div>

                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label>Designation</label>
                                                   <select name="level" required>
                                                        
                                                        <option value="" ><?= $d->designation_id?></option>


                                                          
                                                    </select>

                                            </div>
                                </div>

                            -->


                                 
                                   <?php

                                   if ($d->gender=='male') {
                                    ?>
                                    <div class="form-group">
                                    <input type="radio" checked="checked"  name="gender" id="male" class="with-gap" value="male"  required>
                                    <label for="male">Male</label>

                                    <input type="radio" name="gender" id="female" class="with-gap" value="female"  required>
                                    <label for="female" class="m-l-20">Female</label>
                                </div>
                                <?php
                                   }else{
                                    ?>

                                    <div class="form-group">
                                    <input type="radio" name="gender" id="male" class="with-gap" value="male"  required>
                                    <label for="male">Male</label>

                                    <input type="radio" checked="checked" name="gender" id="female" class="with-gap" value="female"  required>
                                    <label for="female" class="m-l-20">Female</label>
                                </div>

                                <?php
                                   }
                                   ?>

                                   <input type="text" name="id" value="<?= $d->id ?>" class="sr-only">
                                 <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" value="<?= $d->mobile ?>" name="mobile" required>
                                        <label class="form-label">Mobile</label>
                                    </div>
                                </div>
                                 <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="password" class="form-control" value="<?= $d->pass ?>" name="mobile" required>
                                        <label class="form-label">Password</label>
                                    </div>
                                </div>

                                    


                              

                                <button class="btn btn-primary waves-effect" type="submit"> SUBMIT  </button>
                            </form>
                        </div>
                    </div>
                </div>

                <?php
                            }
                        endforeach;
                           ?>
            
            <!-- #END# Basic Validation -->

<?php
        }

        public function update_profile(){
            $data = ['fname'=>$this->input->post('fname'),
                    'lname'=>$this->input->post('lname'),
                    'email'=>$this->input->post('email'),
                    'mobile'=>$this->input->post('mobile'),
                    'gender'=>$this->input->post('gender'),
                    'pass'=>$this->input->post('pass')
                    ];
              
                  $id = $this->input->post('id');
                    $this->Crud->update_profile($data,$id);
        }


        public function ajax_dept(){
           $depts = $this->Crud->select_department();
              $i = 1;
             foreach($depts as $d):
                                            {
                                                ?>

                                         <tr>
                                            <td><?= $i ?></td>
                                            <td><button class="btn btn-<?= $d->color?>"><?= $d->title ?></button></td>
                                            <td> <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal<?= $d->id ?>"> <i class="material-icons">edit</i> </button>
</td>
                                            <td><button class="btn btn-danger btn-xs"  data-toggle="modal" data-target="#trash<?= $d->id ?>" ><i class="material-icons">delete</i></button></td>
                                            
                                        </tr>
           


  <!-- Modal -->
  <div class="modal fade" id="myModal<?= $d->id?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header btn-info">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"> <i class="glyphicon glyphicon-edit"></i> Edit <?= $d->title?> </h4>
        </div>
        <div class="modal-body">
         <form id="update_form<?= $d->id ?>" method="post" action="<?= site_url('Member_login/change_department'); ?>">
                                


                                 <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="ename" value="<?= $d->title ?>"  required>
                                        <label class="form-label">Department Name</label>
                                    </div>
                                </div>



                                <input type="text" value="<?= $d->id ?>" name="id" class="sr-only">
                                <button class="btn btn-primary waves-effect" type="button" id="update_dept<?= $d->id ?>" data-dismiss="modal" > SUBMIT  </button>
                            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  <!--EDT END-->



  <!-- Modal -->
  <div class="modal fade" id="trash<?= $d->id ?>" role="dialog">
    <div class="modal-dialog" style="    margin-left: 629px;
    width: 22%;
    margin-top: 131px;">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header btn-danger">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remove <?= $d->title?></h4>
        </div>
        <div class="modal-body">
          <h3 class="text-center">Are You Sure ?</h3><br>
        <form method="post" action="<?= site_url('Member_login/remove_department') ?>" id="delete_form<?= $d->id ?>" >
              <input type="text" value="<?= $d->id ?>" name="id" class="sr-only">
          <button class="btn btn-success" style="margin-left: 60px;" type="button" id="delete_dept<?= $d->id ?>" data-dismiss="modal" >Yeah Sure !</button>
        </form>
          <button class="btn btn-danger">Cancel</button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  <!--Delete End-->


  <script type="text/javascript">
      $(document).ready(function(){
              //AJAX FOR Deletion

    $("#delete_dept<?= $d->id ?>").click(function(){
            $.ajax({
                url:'<?= site_url("Member_login/remove_department") ?>',
                type:'post',
                data:$("#delete_form<?= $d->id ?>").serialize(),
                success:function(){
                     $("#ajaxdata").load('<?= site_url("Member_login/ajax_dept") ?>');
                     $("#delete_notify").fadeIn('slow');
                setInterval(function(){$("#delete_notify").fadeOut('slow');},6000);

                }
            });
        });       
    });
  </script>



  <script type="text/javascript">
      $(document).ready(function(){
              //AJAX FOR Deletion

    $("#update_dept<?= $d->id ?>").click(function(){
            $.ajax({
                url:'<?= site_url("Member_login/change_department") ?>',
                type:'post',
                data:$("#update_form<?= $d->id ?>").serialize(),
                success:function(){
                     $("#ajaxdata").load('<?= site_url("Member_login/ajax_dept") ?>');
                      $("#update_notify").fadeIn('slow');
                setInterval(function(){$("#update_notify").fadeOut('slow');},6000);

                }
            });
        });       
    });
  </script>


                                                <?php
                                           
                                                $i = $i+1;
                                            }
                                             endforeach;

        }



    

}

?>