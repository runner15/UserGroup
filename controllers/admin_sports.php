<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_sports extends Admin_Controller
{
    protected $section = 'sports';
    public $namespace = 'ug';
    public $stream = 'ug';
    public $module_name = 'usergroup';

    public function __construct()
    {
        parent::__construct();

        $this->load->driver('streams');
        $this->lang->load('ugmain');
    }

    // --------------------------------------------------------------------------

    public function index()
    {
        // The extra array is where most of our
        // customization options go.
        $extra = array();

        // The title can be a string, or a language
        // string, prefixed by lang:
        $extra['title'] = 'lang:ug:sports';
        
        // We can customize the buttons that appear
        // for each row. They point to our own functions
        // elsewhere in this controller. -entry_id- will
        // be replaced by the entry id of the row.
        $extra['buttons'] = array(
            array(
                'label' => lang('global:edit'),
                'url' => 'admin/'.$this->module_name.'/sports/edit/-entry_id-'
            ),
            array(
                'label' => lang('global:delete'),
                'url' => 'admin/'.$this->module_name.'/sports/delete/-entry_id-',
                'confirm' => true
            )
        );

        // In this example, we are setting the 5th parameter to true. This
        // signals the function to use the template library to build the page
        // so we don't have to. If we had that set to false, the function
        // would return a string with just the form.
        $this->streams->cp->entries_table('sports', 'ug', 15, 'admin/'.$this->module_name.'/sports/index', true, $extra);
    }
	
	    /**
     * Create a new User entry
     *
     * We're using the entry_form function
     * to generate the form.
     *
     * @return	void
     */
    public function create()
    {
        $extra = array(
            'return' => 'admin/'.$this->module_name.'/sports',
            'success_message' => lang('ug:submit_success'),
            'failure_message' => lang('ug:submit_failure'),
            'title' => 'lang:ug:newsports',
         );

        $this->streams->cp->entry_form('sports', 'ug', 'new', null, true, $extra);
    }
    
    /**
     * Edit a User
     *
     * We're using the entry_form function
     * to generate the edit form. We're passing the
     * id of the entry, which will allow entry_form to
     * repopulate the data from the database.
     *
     * @param   int [$id] The id of the User to the be deleted.
     * @return	void
     */
    public function edit($id = 0)
    {
        $extra = array(
            'return' => 'admin/'.$this->module_name.'/sports',
            'success_message' => lang('ug:submit_success'),
            'failure_message' => lang('ug:submit_failure'),
            'title' => 'lang:ug:editsports'
        );

        $this->streams->cp->entry_form('sports', 'ug', 'edit', $id, true, $extra);
    }

    /**
     * Delete a User entry
     * 
     * @param   int [$id] The id of User to be deleted
     * @return  void
     */
    public function delete($id = 0)
    {
        $this->streams->entries->delete_entry($id, 'sports', 'ug');
        $this->session->set_flashdata('error', lang('ug:deleted'));
 
        redirect('admin/'.$this->module_name.'/sports/');
    }


}
/* End of file admin.php */