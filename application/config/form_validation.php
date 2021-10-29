<?php

$config = array(



'user/registration/register' => array(
       array(
           'field' => 'email',
           'label' => 'Email',
           'rules' => 'trim|required|valid_email|min_length[3]|max_length[100]',
           //'errors'=>array( 'email_check'=> 'This %s already registered.' )
       ),
       
       
       array(
           'field' => 'password',
           'label' => 'Password',
           'rules' => 'trim|required|min_length[6]|max_length[20]'
       ),
       
       array(
       'field' => 'confirm_password',
       'label' => 'Repeat password',
       'rules' => 'trim|required|matches[password]'
       ),
     

   ),
	'pages/send_message' => array(
						array(
								'field' => 'form_packagename',
								'label' => 'Package Name',
								'rules' => 'trim|min_length[2]|max_length[50]'
						),
						array(
								'field' => 'form_hotelname',
								'label' => 'Hotel Name',
								'rules' => 'trim|min_length[1]|max_length[50]'
						),
						array(
								'field' => 'form_vehicle',
								'label' => 'Vehicle',
								'rules' => 'trim|min_length[1]|max_length[50]'
						),
						array(
								'field' => 'form_food',
								'label' => 'Food',
								'rules' => 'trim|min_length[1]|max_length[50]'
						),
						array(
								'field' => 'form_budget',
								'label' => 'Budget',
								'rules' => 'trim|min_length[1]|max_length[50]'
						),
						array(
								'field' => 'form_startdate',
								'label' => 'start Date',
								'rules' => 'trim|required|min_length[2]|max_length[100]'
						),
						array(
								'field' => 'form_enddate',
								'label' => 'End Date',
								'rules' => 'trim|required|min_length[2]|max_length[100]'
						),
						array(
								'field' => 'form_adult',
								'label' => 'Adult Number',
								'rules' => 'trim|required|min_length[1]|max_length[20]'
						),
						array(
								'field' => 'form_child',
								'label' => 'child Number',
								'rules' => 'trim|min_length[1]|max_length[20]'
						),
						array(
								'field' => 'form_fname',
								'label' => 'First Name',
								'rules' => 'trim|required|min_length[2]|max_length[10]'
						),
						array(
								'field' => 'form_lname',
								'label' => 'last Name',
								'rules' => 'trim|required|min_length[2]|max_length[10]'
						),

						array(
								'field' => 'form_email',
								'label' => 'Email',
								'rules' => 'trim|required|valid_email|min_length[5]|max_length[100]',
						),
						
						array(
								'field' => 'form_phone',
								'label' => 'Phone',
								'rules' => 'trim|numeric|required|min_length[10]|max_length[15]',
						),
						array(
								'field' => 'form_facebookid',
								'label' => 'Facebook Id',
								'rules' => 'trim|min_length[2]|max_length[50]'
						),
							array(
								'field' => 'form_whatsapp',
								'label' => 'Whatsapp',
								'rules' => 'trim|numeric|min_length[10]|max_length[15]',
						),
						array(
								'field' => 'form_comments',
								'label' => 'Message',
								'rules' => 'trim|min_length[3]|max_length[1000]',
						),
						
					
						
			),

	'pages/request_call_back' => array(
						array(
								'field' => 'first_name',
								'label' => 'First Name',
								'rules' => 'trim|required|min_length[2]|max_length[20]'
						),
						array(
								'field' => 'email',
								'label' => 'Email',
								'rules' => 'trim|required|valid_email|min_length[3]|max_length[100]',
						),
						
						array(
								'field' => 'phone',
								'label' => 'Phone',
								'rules' => 'trim|required|min_length[3]|max_length[10]',
						),
						
						
			),
		'pages/send_query' => array(
						array(
								'field' => 'first_name',
								'label' => 'First Name',
								'rules' => 'trim|required'
						),
						array(
								'field' => 'last_name',
								'label' => 'Last Name',
								'rules' => 'trim|required'
						),
						array(
								'field' => 'email',
								'label' => 'Email',
								'rules' => 'trim|required|valid_email|min_length[3]|max_length[100]',
						),
						array(
								'field' => 'phone',
								'label' => 'Phone',
								'rules' => 'trim|numeric|required|min_length[10]|max_length[15]',
						),
						array(
								'field' => 'message',
								'label' => 'Message',
								'rules' => 'trim|required|min_length[10]',
						)
						
						
						
						
			),
		'pages/book_now' => array(
						array(
								'field' => 'name',
								'label' => 'First Name',
								'rules' => 'trim|required'
						),
						
						array(
								'field' => 'email',
								'label' => 'Email',
								'rules' => 'trim|required|valid_email|min_length[3]|max_length[100]',
						),
						array(
								'field' => 'phone',
								'label' => 'Phone',
								'rules' => 'trim|numeric|required|min_length[10]|max_length[15]',
						),
					
						
						
						
						
			),
		'pages/send_query_header' => array(
						array(
								'field' => 'name',
								'label' => 'Name',
								'rules' => 'trim|required'
						),
						array(
								'field' => 'email',
								'label' => 'Email',
								'rules' => 'trim|required|valid_email|min_length[3]|max_length[100]',
						),
						array(
								'field' => 'message',
								'label' => 'Message',
								'rules' => 'trim|required'
						)
						
						
						
						
			),
			'pages/free_consultation' => array(
						array(
								'field' => 'name',
								'label' => 'Name',
								'rules' => 'trim|required'
						),
						array(
								'field' => 'phone',
								'label' => 'Phone',
								'rules' => 'trim|required'
						),
						array(
								'field' => 'email',
								'label' => 'Email',
								'rules' => 'trim|required|valid_email|min_length[3]|max_length[100]',
						),
						array(
								'field' => 'owe',
								'label' => 'How much you owe',
								'rules' => 'trim|required',
						),
						array(
								'field' => 'help',
								'label' => 'I need help with',
								'rules' => 'trim|required',
						),
						array(
								'field' => 'information',
								'label' => 'Information',
								'rules' => 'trim|required'
						)
						
						
						
						
			)
);

$config['error_prefix'] = '<span  class="text-small text-danger">';
$config['error_suffix'] = '</span><br/>';
