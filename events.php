<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Events_UserGroup
{
    protected $ci;
    
    public function __construct()
    {
        $this->ci =& get_instance();
        
        // register the blog_created_category event when this file is autoloaded
        Events::register('blog_category_created', array($this, 'addSport'));
		
		// register the post_published event when this file is autoloaded
        Events::register('post_published', array($this, 'emailGroup'));
     }
    
    // this will be triggered by the Events::trigger('blog_category_created') code in Blog/controller/admin_category.php
    public function addSport($category)
	{
		//print_r($category);
		//exit;
		$this->ci->load->driver('streams');
		$entry_data = array(
			'sports' => $category
		);

		$this->ci->streams->entries->insert_entry($entry_data, 'sports', 'ug');
	}
	
	// this will be triggered by the Events::trigger('post_published') code in blog/controller/admin.php
    public function emailGroup($id)
	{
		//print_r($id);
		//exit;
		
		//Get blog info http://goo.gl/bnQyFD
		$this->ci->db->where('id', $id);
		//here we select every clolumn of the table
		$q = $this->ci->db->get('default_blog');
		$data = $q->result_array();

		$blog_title = $data[0]['title'];
		$blog_body = $data[0]['body'];
		$blog_category = $data[0]['category_id'];
		
		//Get blog category info
		$this->ci->db->where('id', $blog_category);
		$c = $this->ci->db->get('default_blog_categories');
		$cat_data = $c->result_array();
		
		$category_title = $cat_data[0]['title'];
		
		//Get UserGroup sport id
		$this->ci->db->where('sports', $category_title);
		$s = $this->ci->db->get('default_ug_sports');
		$sport_data = $s->result_array();
		
		$sport_id = $sport_data[0]['id'];
		
		//Get UserGroup users who play sport
		$this->ci->db->where('sport', $sport_id);
		$u = $this->ci->db->get('default_ug_group');
		$user_data = $u->result_array();

		$sport_id = $user_data[0]['id'];
		
		for ($i = 0; $i <= count($user_data); $i++) {
			$this->ci->db->select('email');
			$this->ci->db->where('id', $user_data[$i]['user_id']);
			$e = $this->ci->db->get('default_ug_users');
			//if id is unique we want just one row to be returned
			$email_data = array_shift($e->result_array());

			$user_email = $email_data['email'];
			
			$all_data = array(
				'slug' => 'new-blog-post-published',
				'to' => $user_email,
				'from' => 'SpecialOlympics@runner15.com',
				'blog_body' => $blog_body,
				'subject' => $category_title.' Update!',
				'sport_name' => $category_title,
				'redirect_url' => 'http://runner15.com/pyroisp/blog/category/'.$category_title,
			);

			Events::trigger('email', $all_data, 'array');

		}
		

	}
	
	
    
}
/* End of file events.php */