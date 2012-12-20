<?php
/**
 * User: larry
 */
class Main
{
    public $action = 'landing';
    protected $valid_actions = array('landing', 'process', 'view');

    function __construct()
    {
        set_include_path(get_include_path() . PATH_SEPARATOR . $_SERVER["DOCUMENT_ROOT"] ."/../src" );
        if (!empty($_REQUEST['action']) && in_array($_REQUEST['action'], $this->valid_actions)) {
            $this->action = $_REQUEST['action'];
        }
    }

    function render() {
        include($_SERVER['DOCUMENT_ROOT'] . "actions/{$this->action}.php");
    }
}

$main = new Main();