=== MooTinyMCE "Text Editor Plugin" ===

Author:    Mohamed Alsharaf (mohamed.alsharaf@gmail.com)
Website:   http://jamandcheese-on-phptoast.com
Copyright: 2011-2012 Mohamed Alsharaf
License:   http://www.gnu.org/copyleft/gpl.html
Version:   1.0.0

== Changelog: ==
1.0.0 - First version for Moodle 2.1

== Installation ==
1. Copy and paste the folder mooprofile into the directory lib/editor/.

2. Log into your Moodle site as an admin user.

3. Go to the notifications page to install this plugin. The plugin will install 3 global settings and 3 database tables.

== Usage ==
    +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    +  [WARNING] Creating different instances of TinyMCE MUST only be done by a developer.      +
    +            Currently there is no user interface to manage the instances. The only way is  +
    +            by modifying the config.php file.                                              +
    +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

1. Open config.php

2. At the end of the file just after require_once(dirname(__FILE__) . '/lib/setup.php'); add the different instances.

// id_summary_editor ==> is the value of the ID attribute of the form element
$CFG->mootinymce_options = array();

// The configuration array is going to be merged on top of the default configuration.
$CFG->mootinymce_options['id_summary_editor'] = array(
    'skin' => 'o2k7',
    'skin_variant' => 'silver',
    'font_sizes' => '1,2,3',
    'toolbar_align' => 'center',
    'statusbar_location' => 'none',
    'resize_horizontal' => false,
    'min_height' => '30',
    'min_height' => '30',
    'resizing' => false,
    'buttons' => array(
        array('bullist', 'numlist', 'bold', '|'), // replace the first buttons row
        array('add', 'fontselect'), // add extra buttons at the end of the default buttons
        array('before', 'bold'), // add extra buttons from the beginning of the default buttons
        array(), // to remove the entire buttons row
    ),
    'plugins' => array(
        'plugins' => array('emotions',), // list of plugins to load
        'apply_type' => 'append' // append: add extra plugin to the defaults
                                 // fixed: load the new plugins only, ignore the defaults
    )
);

== ToDo ==
1. Create an administrator interface to create and manage the different TinyMCE instances.
