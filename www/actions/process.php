<h2>Processing...</h2>
<?php
/**
 * User: larry
 */

/* i'd have to reconfigure my nginx for this to work, so it's untested */
ob_implicit_flush(1);
ob_flush();

include('ImageFilterDemo.php');
include('FilterFunctions.php');

// instantiate demo wrapper
$demo = new ImageFilterDemo("img/*.*");

// setup the filters
$demo->filter_list = array("filter_blackwhite", "filter_invert");

// party time!
$demo->Run();

if (DEBUG) print"<pre>{$demo->loggedText}</pre>";

?>

<a href="/?action=view">View Results</a>