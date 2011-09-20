<?php

/**
 * TinyMCE admin settings
 *
 * @package    editor
 * @subpackage tinymce
 * @copyright  2009 Petr Skoda (http://skodak.org)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $options = array(
        'PSpell'=>'PSpell',
        'GoogleSpell'=>'Google Spell',
        'PSpellShell'=>'PSpellShell');
    $settings->add(new admin_setting_configselect('editor_mootinymce/spellengine', get_string('spellengine', 'admin'), '', 'GoogleSpell', $options));
}

