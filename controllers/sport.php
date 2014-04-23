<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends Admin_Controller
{
    protected $section = 'blog';
    public $namespace = 'ug';
    public $stream = 'ug';
    public $module_name = 'usergroup';

    public function __construct()
    {
        parent::__construct();

        $this->load->driver('streams');
        $this->lang->load('ugmain');
    }

    public function sport($slug = '')
    {
        $slug or redirect('blog');
    }