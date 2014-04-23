<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_usergroup extends Module {

	public $version = '1.0';
    public $namespace = 'ug';
    public $module_name = 'usergroup';

    
	public function __construct()
    {
        parent::__construct();

        // dependencies
        
        //$this->load->language('usergroup/ug');
        $this->load->library('streams/streams_details');
        $this->streams_details->set_namespace($this->namespace);
    }
	

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'UserGroup'
			),
			'description' => array(
				'en' => 'Create groups of users and email them.'
			),
			'frontend' => TRUE,
			'backend' => TRUE,
			'menu' => 'content', 
			'author' => 'Runner',
			'sections' => array(
				'users' => array(
					'name' 	=> 'ug:users', // These are translated from your language file
					'uri' 	=> 'admin/'.$this->module_name,
						'shortcuts' => array(
							'create' => array(
								'name' 	=> 'ug:createusers',
								'uri' 	=> 'admin/'.$this->module_name.'/create',
								'class' => 'add'
								)
							)
						),
				
				'group' => array(
					'name' 	=> 'ug:group', // These are translated from your language file
					'uri' 	=> 'admin/'.$this->module_name.'/group',
						'shortcuts' => array(
							'create' => array(
								'name' 	=> 'ug:creategroup',
								'uri' 	=> 'admin/'.$this->module_name.'/group/create',
								'class' => 'add'
							)
						)
					),	
				
				'sports' => array(
					'name' 	=> 'ug:sports',
					'uri' 	=> 'admin/blog/categories'/*'admin/'.$this->module_name.'/sports'*/,
						'shortcuts' => array(
							'create' => array(
								'name' 	=> 'ug:newsports',
								'uri' 	=> 'admin/'.$this->module_name.'/sports/create',
								'class' => 'add'
							)
						)
					)	
				)
		);
	}

	public function install()
	{
		// We're using the streams API to
        // do data set-up.
        $this->load->driver('Streams');

        //$this->load->language('ugmain');
		
		//add streams
		if ( ! $users_stream_id = $this->streams->streams->add_stream('Users', 'users', $this->namespace, 'ug_', null)) return false;
        if ( ! $group_stream_id = $this->streams->streams->add_stream('Group', 'group', $this->namespace, 'ug_', null)) return false;
        if ( ! $sports_stream_id = $this->streams->streams->add_stream('Sports', 'sports', $this->namespace, 'ug_', null)) return false;
		
		//$streams = array('users', 'group');

		/*
		$fields_assignment = array(
			'users' => array('first_name', 'last_name', 'age', 'phone', 'email'),
			'group' => array('user_id', 'sport'),
		);
		*/	

		/* uninstall
        -------------------------------------------------- 
        if( ! $this->uninstall())
            return false;
		*/

        /* fields
        -------------------------------------------------- */
        $fields = array(
		    array(
		        'name'          => 'First Name',
		        'slug'          => 'first_name',
		        'namespace'     => 'ug',
		        'type'          => 'text',
		        'extra'         => array('max_length' => 200),
		        'assign'        => 'users',
		        'required'      => true,
		    ),
		    array(
		        'name'          => 'Last Name',
		        'slug'          => 'last_name',
		        'namespace'     => 'ug',
		        'type'          => 'text',
		        'extra'         => array('max_length' => 200),
		        'assign'        => 'users',
        		'title_column'  => true,
		        'required'      => true
		    ),
		    array(
		    	'name'          => 'Age',
		        'slug'          => 'age',
		        'namespace'     => 'ug',
		        'type'          => 'integer',
		        'extra'         => array('max_length' => 3),
		        'assign'        => 'users',
		    ),
		    array(
		        'name'          => 'Phone',
		        'slug'          => 'phone',
		        'namespace'     => 'ug',
		        'type'          => 'text',
		        'extra'         => array('max_length' => 20),
		        'assign'        => 'users',
		    ),
		    array(
		        'name'          => 'Email',
		        'slug'          => 'email',
		        'namespace'     => 'ug',
		        'type'          => 'email',
		        'assign'        => 'users',
		        'required'      => true
		    ),
		    array(
		        'name'          => 'User ID',
		        'slug'          => 'user_id',
		        'namespace'     => 'ug',
		        'type'          => 'relationship',
		        'extra'         => array('choose_stream' => $users_stream_id),
		        'assign'        => 'group',
		        'required'      => true
		    ),
		    array(
		        'name'          => 'Sport',
		        'slug'          => 'sport',
		        'namespace'     => 'ug',
		        'type'          => 'relationship',
		        'extra'         => array('choose_stream' => $sports_stream_id),
		        'assign'        => 'group',
		        'required'      => true
		    ),
		    array(
		        'name'          => 'Sports',
		        'slug'          => 'sports',
		        'namespace'     => 'ug',
		        'type'          => 'text',
		        'extra'         => array('max_length' => 200),
		        'assign'        => 'sports',
		        'required'      => true
		    ),
		);
		
		$this->streams_details->insert_fields($fields);
		
		$this->streams->streams->update_stream('users', $this->namespace, array(
            'view_options' => array('first_name', 'last_name', 'age', 'phone', 'email'),
            'title_column' => 'last_name'
            )
        );
		
		$this->streams->streams->update_stream('group', $this->namespace, array(
            'view_options' => array('user_id', 'sport'),
            'title_column' => 'sport'
            )
        );

        $this->streams->streams->update_stream('sports', $this->namespace, array(
            'view_options' => array('sports'),
            'title_column' => 'sports'
            )
        );
		
		/*$streams_options = array(
			'users' => array(
                'view_options' => array('first_name', 'last_name', 'age', 'phone', 'email'),
                'title_column' => 'last_name'
                ),
			'group' => array(
                'view_options' => array('user_id', 'sport'),
                'title_column' => 'sport'
            ),
		);*/
		
		/* streams
        $streams_id = $this->streams_details->insert_streams($streams, $streams_options);
		*/

        /* fields_assignment
        $this->streams_details->insert_fields_assignment($streams, $fields, $fields_assignment, $instructions);
		*/

        return true;

	}

	public function uninstall()
	{
		$this->load->driver('streams');

        $this->streams->utilities->remove_namespace($this->namespace);

        return true;
	}


	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return TRUE;
	}

	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
	}
}
/* End of file details.php */