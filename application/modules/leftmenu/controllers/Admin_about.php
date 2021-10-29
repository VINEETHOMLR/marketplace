<?php
class Admin_about extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		Modules::run( 'login/check_authority' , array( 'is_admin'  ) );
		$this->load->model( array( 'About_model' ) );
    }
	

	public function form( $about_id= NULL )
	{
		$data[ 'content' ] = 'leftmenu/about/form';
		$data[ 'about' ]	=	array();
		$about_id=1;
		if( $about_id != NULL )
		{
			$data[ 'about' ]	=	$this->About_model->get( $about_id );
		}
		//echo '<pre>';print_r($data[ 'blog' ]);exit;
		
		$this->load->view( 'admin/page' , $data );
	}
	public function manage()
	{
		
		$data[ 'content' ]	=	'leftmenu/history/table';
		$this->load->view( 'admin/page' , $data );
	}
	
	public function remove( $about_id )
	{
		$where[ 'about_id' ]  = $about_id;
		$this->About_model->delete( $where );
	}
	private function get_uri( $title , $id = NULL )
	{
		$config = array(
			'field' => 'about_uri',
			'table' => 'mv_destination_cinema',
			'id' => 'about_id',
		);
		$this->load->library('slug', $config);
		return $uri	=	$this->slug->create_uri(array( 'title' => $title ), $id );
	}
	public function update()
	{
		//$about_id	=	$_POST[ 'about_id' ];

		
		$data[ 'about_title' ]	=	$_POST[ 'about_title' ];
		$data[ 'about_description' ]	=	$_POST[ 'about_description' ];
		
		
		

		
		

		$about_id	=	isset($_POST[ 'about_id' ])?$_POST['about_id']:0;
		

        
		    $this->db->trans_begin();
		    

		

		if( $about_id == NULL )
		{
			//$data[ 'about_dateadded' ]	=	$this->dbnow;	
			//$data[ 'about_dateupdated' ]	=	$this->dbnow;	
			$about_id	=	$this->About_model->add( $data );
			$cinema = "About added !";
		}
		else
		{
			$where[ 'about_id' ]	=	$about_id;
			//$data[ 'about_dateupdated' ]	=	$this->dbnow;
			$this->About_model->update( $data , $where );
			$cinema = "About updated !";
		}

	    
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$msg['res']		=	2;
			$msg['msg']		=	'Something went wrong Please try again !';
		}
		else
		{
			$this->db->trans_commit();
			$msg['res']		=	1;
			$msg['msg']		=	$cinema;
			$msg[ 'red' ]	=	$this->base.'leftmenu/admin_about/form';
		}
		echo json_encode( $msg );
	}
	
	public function change_status( )
	{
		$record_id	=	$this->input->post( 'pk' );
		$record_status	=	$this->input->post( 'value' );
		$field	=	$this->input->post( 'name' );
		$where[ 'about_id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		if( $this->About_model->update( $data , $where ) )
		{
			$msg['res']		=	1;
			$msg['msg']		=	'Status changed .';
			
		}
		else
		{
			$msg['res']		=	2;
			$msg['msg']		=	'Something went wrong Please try again.';
		}
		
		echo json_encode($msg);
	}

	public function list_json()
	{
		$about_status	=	$this->input->post( 'about_status' );
		$limit	=	$this->input->post( 'limit' );
		$start	=	$this->input->post( 'offset' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		
		$data[ 'rows' ] = $this->About_model->get_list(  $about_status , $limit , $start , $date_from   , $date_to );
		
		$data[ 'total' ] = $this->About_model->get_count(  $about_status , $date_from   , $date_to );
		echo json_encode( $data );
	}
	
	
	
}