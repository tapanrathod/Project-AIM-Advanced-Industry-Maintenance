<?php

	class Crud extends CI_Model
	{

		public function member_login($email,$pass){

			$this->db->where('email',$email);
			$this->db->where('pass',$pass);
			$data = $this->db->get('user');

			return $data->result();


		}


		public function admin_login($email,$pass){

			$this->db->where('email',$email);
			$this->db->where('pass',$pass);
			$data = $this->db->get('super_admin');

			return $data->result();


		}

		public function get_users()
		{
			$data = $this->db->get('user')->result();
			return $data;

		}

		public function login_log($user)
		{
			$this->db->insert('employee_log',$user);
		}

		public function logout_log($user,$date,$data)
		{
			$this->db->where('user',$user);
			$this->db->where('date',$date);
			$this->db->update('employee_log',$data);

		}

		public function insert_department($data)
		{
			$this->db->insert("department",$data);
		}
		public function change_department($data,$id)
		{	
			$this->db->where('id',$id);
			$this->db->update("department",$data);
		}
		public function search($input){
			

		}
		public function remove_media($id){
			$this->db->where('id',$id);
			$this->db->delete("files");
		}
		public function sort_level($data,$id){
			$this->db->where('id',$id);
			$this->db->update('access_level',$data);
		}

		public function trash_media($data,$id){
			$this->db->where('id',$id);
			$this->db->update("files",$data);
		}
		public function select_department()
		{
			$deps =	$this->db->get("department");
			return $deps->result();
		}
		public function remove_department($id)
		{
			$this->db->where('id',$id);
			$this->db->delete('department');
		}

			public function remove_log($id)
		{
			$this->db->where('id',$id);
			$this->db->delete('employee_log');
		}

		public function notification($person){
			$this->db->where('user',$person);
			$notification = $this->db->get('share');
			return $notification->result();
		}

			public function admin_notification($person){
			$this->db->where('user',$person);
			$notification = $this->db->get('share');
			return $notification->result();
		}
		//LEVEL

		public function select_level()
		{	
			$this->db->order_by('id','DESC');
			$deps =	$this->db->get("designation_level");
			return $deps->result();
		}
		public function insert_level($data)
		{
			$this->db->insert("designation_level",$data);
		}
		public function change_level($data,$id)
		{	
			$this->db->where('id',$id);
			$this->db->update("designation_level",$data);
		}
		public function remove_level($id)
		{
			$this->db->where('id',$id);
			$this->db->delete('designation_level');
		}
		public function select_user()
		{
			$deps =	$this->db->get("user");
			return $deps->result();
		}
			public function insert_user($data)
		{
			$this->db->insert("user",$data);
		}
		public function remove_user($id)
		{
			$this->db->where('id',$id);
			$this->db->delete('user');
		}
		public function select_media(){
			$this->db->where('trash',0);
			$this->db->order_by('id','DESC');
			$files = $this->db->get('files');
			return $files->result();
		}

		public function select_client_media($access){
			$this->db->where('trash',0);
			$this->db->where('access <=',$access);
			$this->db->order_by('id','DESC');
			$files = $this->db->get('files');

			return $files->result();
		}

			public function insert_media($data)
		{
			$this->db->insert("files",$data);
		}

			public function insert_audio($data)
		{
			$this->db->insert("files",$data);
		}
		public function select_audio(){
			$this->db->where('audio','1');
			$files = $this->db->get('files');
			return $files->result();
		}

		public function get_my_profile($id)
		{
			$this->db->where('id',$id);
			$data = $this->db->get('user');

			return $data->result();
		}


		public function admin_profile($id)
		{
			$this->db->where('id',$id);
			$data = $this->db->get('super_admin');

			return $data->result();
		}

		public function move_file($d,$id){
			$this->db->where('id',$id);
			$this->db->update('files',$d);
		}
		public function update_profile($data,$id)
		{
			$this->db->where('id',$id);	
			$this->db->update("user",$data);	
		}


		public function super_update_profile($data,$id)
		{
			$this->db->where('id',$id);	
			$this->db->update("super_admin",$data);	
		}
		public function get_file($id){
			$this->db->where('id',$id);
			$file = $this->db->get('files');
			return $file->result();
		}
		public function file_rename($data,$id)
		{
			$this->db->where('id',$id);	
			$this->db->update("files",$data);	
		}
		public function update_pic($id,$data)
		{
			$this->db->where('id',$id);	
			$this->db->update("user",$data);	
		}

		public function admin_update_pic($id,$data)
		{
			$this->db->where('id',$id);	
			$this->db->update("super_admin",$data);	
		}
		public function create_file($data)
		{
			$this->db->insert("files",$data);
		}
		public function share_media($data)
		{
			$this->db->insert("share",$data);
		}
		public function create_folder($data)
		{
			$this->db->insert("files",$data);
		}
		public function compress_file($data){
			$this->db->insert('files',$data);
		}
	}
?>