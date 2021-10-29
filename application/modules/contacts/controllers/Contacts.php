<?php
class Contacts extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		Modules::run( 'login/check_authority' , array( 'is_admin'  ) );
		$this->load->model( array( 'Contacts_model' ) );
    }
	
	public function manage()
	{
		$data[ 'content' ]	=	'contacts/table';
		$this->load->view( 'admin/page' , $data );
	}
	
	public function list_json()
	{
		$contact_status	=	$this->input->post( 'contact_status' );
		$limit	=	$this->input->post( 'limit' );
		$start	=	$this->input->post( 'offset' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		$search	=	$this->input->post( 'search' );
		$contact_type	=	$this->input->post( 'contact_type' );
		
		$data[ 'rows' ] = $this->Contacts_model->get_list(  $contact_status , $limit , $start , $date_from   , $date_to  , $search , $contact_type);
		
		$data[ 'total' ] = $this->Contacts_model->get_count(  $contact_status , $date_from   , $date_to , $search , $contact_type );
		echo json_encode( $data );
	}
	
	public function remove( $contact_id )
	{
		$where[ 'contact_id' ]  = $contact_id;
		$this->Contacts_model->delete( $where );
	}
	
	public function update()
	{
		$data[ 'contact_name' ]	=	$this->input->post( 'contact_name' );
		$data[ 'contact_type' ]	=	$this->input->post( 'contact_type' );
		$data[ 'contact_email' ]	=	$this->input->post( 'contact_email' );
		$data[ 'contact_phone' ]	=	$this->input->post( 'contact_phone' );
		$data[ 'contact_description' ]	=	$this->input->post( 'contact_description' );
		$contact_id	=	$this->input->post( 'contact_id' );
		$this->db->trans_begin();
		$contact_exists = NULL;
		$wherec[ 'contact_email' ] = $data[ 'contact_email' ];
		if( $contact_id != NULL )
		{
			$wherec[ 'contact_id!=' ]	=	$contact_id;
		}

		if( $this->Contacts_model->get( $wherec ) )
		{
			$msg['res']		=	2;
			$msg['msg']		=	'Contact email already exists!';
			echo json_encode( $msg );
			die();
		}

		if( $contact_id == NULL )
		{
			$data[ 'contact_join_date' ]	=	$this->dbnow;	
			$contact_id	=	$this->Contacts_model->add( $data );
			$message = "New contact added !";
		}
		else
		{
			$where[ 'contact_id' ]	=	$contact_id;
			$this->Contacts_model->update( $data , $where );
			$message = "Contact updated !";
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
			$msg['msg']		=	$message;
		}
		echo json_encode( $msg );
	}
	
	public function change_status( )
	{
		$record_id	=	$this->input->post( 'pk' );
		$record_status	=	$this->input->post( 'value' );
		$field	=	$this->input->post( 'name' );
		$where[ 'contact_id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		if( $this->Contacts_model->update( $data , $where ) )
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
	
	public function save_selected()
	{
		$selections	=	$this->input->post( 'selections' );
		$_SESSION[ 'selections' ]	=	$selections;
	}
	
	public function send_mail()
	{
		$selections	=	$_SESSION[ 'selections' ];
		$contacts	=	$this->Contacts_model->get_list_from_ids( $selections );
		$data[ 'contacts' ]	=	$contacts;
		$data[ 'content' ]	=	'contacts/send_mail';
		$this->load->view( 'admin/page' , $data );
	}
	
	public function send_mail_to_contact()
	{
		$template	=	$this->input->post( 'template' );
		$contact	=	$this->input->post( 'contact' );
		$greeting	=	str_replace('{name}', $contact['contact_name'] , $template['greeting'] );
		$content	=	$template[ 'content' ];
		$subject	=	$template[ 'subject' ];
		$email		=	$contact[ 'contact_email' ];
		Modules::run( 'mails/send_mail_to_contact' ,  $subject , $greeting , $content , $email  );
		
	}
	
}