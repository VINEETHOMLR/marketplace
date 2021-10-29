<?php
class Cron extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		Modules::run( 'login/check_authority' , array( 'is_admin' ) );
		$this->load->model( array( 'Cron_model' ) );
    }
	
	public function daily_cron()
	{
      $date_from=date('Y-m-d');
      $date_to=date('Y-m-d');
      $data['image_daily_rank']=0;
      
      $this->Cron_model->update($data);
      If($rows=$this->Cron_model->get_posts($date_from,$date_to))
      {
        
           $i=0;
	       foreach($rows as $k=>$v)
	       {
	       	    $i++;
	       	    $where['image_id']=$v['image_id'];
	       	    $data['image_daily_rank']=$i;
	            $this->Cron_model->update($data,$where);
	       }
       

      }


	}


	public function weekly_cron()
	{
        
      $date_from=date('Y-m-d', strtotime('-7 days'));
      $date_to=date('Y-m-d');
      $data['image_weekly_rank']=0;
      
      $this->Cron_model->update($data);
      If($rows=$this->Cron_model->get_posts($date_from,$date_to))
      {
        
           $i=0;
	       foreach($rows as $k=>$v)
	       {
	       	    $i++;
	       	    $where['image_id']=$v['image_id'];
	       	    $data['image_weekly_rank']=$i;
	            $this->Cron_model->update($data,$where);
	       }
       

      }

      


	}


	public function monthly_cron()
	{
        
      $date_from=date('Y-m-d', strtotime('-30 days'));
      $date_to=date('Y-m-d');
      $data['image_monthly_rank']=0;
      
      $this->Cron_model->update($data);
      If($rows=$this->Cron_model->get_posts($date_from,$date_to))
      {
        
           $i=0;
	       foreach($rows as $k=>$v)
	       {
	       	    $i++;
	       	    $where['image_id']=$v['image_id'];
	       	    $data['image_monthly_rank']=$i;
	            $this->Cron_model->update($data,$where);
	       }
       

      }

      


	}
	
	
	
}