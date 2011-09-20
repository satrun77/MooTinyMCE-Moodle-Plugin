<?php

/**
 * TinyMCE text editor integration.
 *
 * @package    editor
 * @subpackage mootinymce
 * @copyright  2011 Mohamed Alsharaf
 * @author     Mohamed Alsharaf <mohamed.alsharaf@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

include_once $CFG->libdir . '/editor/tinymce/lib.php';

class mootinymce_texteditor extends tinymce_texteditor
{

    public $version = '3.4.2';
    private $name = 'mootinymce';

    const PLUGIN_ADVIMG = 'advimage';
    const PLUGIN_SAFARI = 'safari';
    const PLUGIN_TABLE = 'table';
    const PLUGIN_STYLE = 'style';
    const PLUGIN_LAYER = 'layer';
    const PLUGIN_ADVHR = 'advhr';
    const PLUGIN_ADVLINK = 'advlink';
    const PLUGIN_EMOTION = 'emotions';
    const PLUGIN_INLINEPOPUPS = 'inlinepopups';
    const PLUGIN_SEARCH = 'searchreplace';
    const PLUGIN_PASTE = 'paste';
    const PLUGIN_DIRECTIONALITY = 'directionality';
    const PLUGIN_FULLSCREEN = 'fullscreen';
    const PLUGIN_MOODLENOLINK = 'moodlenolink';
    const PLUGIN_NONBREAKING = 'nonbreaking';
    const PLUGIN_CONTEXTMENU = 'contextmenu';
    const PLUGIN_DATETIME = 'insertdatetime';
    const PLUGIN_SAVE = 'save';
    const PLUGIN_IESPELL = 'iespell';
    const PLUGIN_PREVIEW = 'preview';
    const PLUGIN_PRINT = 'print';
    const PLUGIN_NONEDITABLE = 'noneditable';
    const PLUGIN_CHARS = 'visualchars';
    const PLUGIN_XTHML = 'xhtmlxtras';
    const PLUGIN_TEMPLTE = 'template';
    const PLUGIN_PAGEBREAK = 'pagebreak';
    const PLUGIN_SPELLCHECKER = 'spellchecker';
    const PLUGIN_MOODLEMEDIA = 'moodlemedia';
    const PLUGIN_DRAGMATH = 'dragmath';
    const PLUGIN_MOODLEEMOTICON = 'moodleemoticon';

    const BUTTON_SPACER = '|';
    const BUTTON_BULLIST = 'bullist';
    const BUTTON_NUMLIST = 'numlist';
    const BUTTON_OUTDENT = 'outdent';
    const BUTTON_INDENT = 'indent';
    const BUTTON_LINK = 'link';
    const BUTTON_UNLINK = 'unlink';
    const BUTTON_MOODLENOLINK = 'moodlenolink';
    const BUTTON_IMAGE = 'image';
    const BUTTON_NONBREAKING = 'nonbreaking';
    const BUTTON_CHAR = 'charmap';
    const BUTTON_MOODLEMEDIA = 'moodlemedia';
    const BUTTON_TABLE = 'table';
    const BUTTON_CODE = 'code';
    const BUTTON_BOLD = 'bold';
    const BUTTON_ITALIC = 'italic';
    const BUTTON_UNDERLINE = 'underline';
    const BUTTON_STRIKETHROUGH = 'strikethrough';
    const BUTTON_SUB = 'sub';
    const BUTTON_SUP = 'sup';
    const BUTTON_JUSTYLEFT = 'justifyleft';
    const BUTTON_JUSTYCENTER = 'justifycenter';
    const BUTTON_JUSTYRIGHT = 'justifyright';
    const BUTTON_CLEANUP = 'cleanup';
    const BUTTON_REMOVEFORMAT = 'removeformat';
    const BUTTON_PASTETEXT = 'pastetext';
    const BUTTON_PASTEWORD = 'pasteword';
    const BUTTON_FORECOLOR = 'forecolor';
    const BUTTON_BACKCOLOR = 'backcolor';
    const BUTTON_LTR = 'ltr';
    const BUTTON_RTL = 'rtl';
    const BUTTON_FONTSELECT = 'fontselect';
    const BUTTON_FONTSIZE = 'fontsizeselect';
    const BUTTON_FORMAT = 'formatselect';
    const BUTTON_UNDO = 'undo';
    const BUTTON_REDO = 'redo';
    const BUTTON_SEARCH = 'search';
    const BUTTON_REPLACE = 'replace';
    const BUTTON_FULLSCREEN = 'fullscreen';

    public function use_editor($elementid, array $options=null, $fpoptions=null)
    {
        global $PAGE;
        if (debugging('', DEBUG_DEVELOPER)) {
            $PAGE->requires->js('/lib/editor/' . $this->name . '/tiny_mce/' . $this->version . '/tiny_mce_src.js');
        } else {
            $PAGE->requires->js('/lib/editor/' . $this->name . '/tiny_mce/' . $this->version . '/tiny_mce.js');
        }
        $PAGE->requires->js_init_call('M.editor_' . $this->name . '.init_editor', array($elementid, $this->get_init_params($elementid, $options)), true);
        if ($fpoptions) {
            $PAGE->requires->js_init_call('M.editor_' . $this->name . '.init_filepicker', array($elementid, $fpoptions), true);
        }
    }

    /**
     * Get parameter value or default if it does not exists
     * 
     * @global moodle_page $PAGE
     * @param string $name
     * @param array $options
     * @return string 
     */
    private function get_param($name, $options)
    {
        global $PAGE;

        if (!in_array($name, array('fonts', 'plugins')) && isset($options[$name])) {
            return $options[$name];
        }
        switch ($name) {
            case 'content_css':
                return $PAGE->theme->editor_css_url()->out(false);
                break;
            case 'language':
                return current_language();
                break;
            case 'directionality':
                return get_string('thisdirection', 'langconfig');
                break;
            case 'date_format':
                return get_string('strftimedaydate');
                break;
            case 'time_format':
                return get_string('strftimetime');
                break;
            case 'skin':
                return 'o2k7';
                break;
            case 'skin_variant':
                return 'silver';
                break;
            case 'apply_source_formatting':
                return true;
                break;
            case 'remove_script_host':
                return false;
                break;
            case 'entity_encoding':
                return 'raw';
                break;
            case 'plugins':
                $default = array(
                    self::PLUGIN_ADVIMG, self::PLUGIN_SAFARI, self::PLUGIN_TABLE, self::PLUGIN_STYLE, self::PLUGIN_LAYER, self::PLUGIN_ADVHR, self::PLUGIN_ADVLINK,
                    self::PLUGIN_EMOTION, self::PLUGIN_INLINEPOPUPS, self::PLUGIN_SEARCH, self::PLUGIN_PASTE, self::PLUGIN_DIRECTIONALITY, self::PLUGIN_FULLSCREEN,
                    self::PLUGIN_MOODLENOLINK, self::PLUGIN_NONBREAKING, self::PLUGIN_CONTEXTMENU, self::PLUGIN_DATETIME, self::PLUGIN_SAVE, self::PLUGIN_IESPELL,
                    self::PLUGIN_PREVIEW, self::PLUGIN_PRINT, self::PLUGIN_NONEDITABLE, self::PLUGIN_CHARS, self::PLUGIN_XTHML, self::PLUGIN_TEMPLTE, self::PLUGIN_PAGEBREAK,
                    self::PLUGIN_SPELLCHECKER, self::PLUGIN_MOODLEMEDIA,
                );
                $plugins = $default;

                if (isset($options['plugins']['apply_type']) && $options['plugins']['apply_type'] == 'append') {
                    $plugins = array_merge($default, $options['plugins']['plugins']);
                } else if (isset($options['plugins']['plugins'])) {
                    $plugins = $options['plugins']['plugins'];
                }
                if (($key = array_search(self::PLUGIN_DRAGMATH, $plugins)) !== false) {
                    unset($plugins[$key]);
                }
                if (($key = array_search(self::PLUGIN_MOODLEEMOTICON, $plugins)) !== false) {
                    unset($plugins[$key]);
                }

                $context = empty($options['context']) ? get_context_instance(CONTEXT_SYSTEM) : $options['context'];
                $filters = filter_get_active_in_context($context);
                if (array_key_exists('filter/tex', $filters)) {
                    $plugins[] = self::PLUGIN_DRAGMATH;
                }
                if (array_key_exists('filter/emoticon', $filters)) {
                    $plugins[] = self::PLUGIN_MOODLEEMOTICON;
                }
                return $plugins;
                break;
            case 'font_sizes':
                return "1,2,3,4,5,6,7";
                break;
            case 'layout_manager':
                return 'SimpleLayout';
                break;
            case 'toolbar_align':
                return 'left';
                break;
            case 'toolbar_location':
                return 'top';
                break;
            case 'statusbar_location':
                return 'bottom';
                break;
            case 'fonts':
                $default = array(
                    'Trebuchet=Trebuchet MS', 'Verdana', 'Arial', 'Helvetica', 'sans-serif;Arial=arial', 'helvetica', 'sans-serif;Courier New=courier new',
                    'courier', 'monospace;Georgia=georgia', 'times new roman', 'times', 'serif;Tahoma=tahoma', 'arial', 'helvetica', 'sans-serif;Times New Roman=times new roman',
                    'serif;Verdana=verdana', 'sans-serif;Impact=impact;Wingdings=wingdings',
                );
                $fonts = $default;

                if (isset($options['fonts']['apply_type']) && $options['fonts']['apply_type'] == 'append') {
                    $fonts = array_merge($default, $options['fonts']['fonts']);
                } else if (isset($options['fonts']['fonts'])) {
                    $fonts = $options['fonts']['fonts'];
                }
                return join(',', $fonts);
                break;
            case 'resize_horizontal':
                return true;
                break;
            case 'min_height':
                return 30;
                break;
            case 'resizing':
                return true;
                break;
        }

        return '';
    }

    protected function get_init_params($elementid, array $options=null)
    {
        global $CFG, $PAGE, $OUTPUT;

        $options = $this->merge_options($elementid, $options);

        // init TinyMCE parameters
        $plugins = $this->get_param('plugins', $options);
        $params = array(
            'mode' => "exact",
            'elements' => $elementid,
            'relative_urls' => false,
            'document_base_url' => $CFG->httpswwwroot,
            'content_css' => $this->get_param('content_css', $options),
            'language' => $this->get_param('language', $options),
            'directionality' => $this->get_param('directionality', $options),
            'content_css' => $this->get_param('content_css', $options),
            'plugin_insertdate_dateFormat' => $this->get_param('date_format', $options),
            'plugin_insertdate_timeFormat' => $this->get_param('time_format', $options),
            'theme' => "advanced",
            'skin' => $this->get_param('skin', $options),
            'skin_variant' => $this->get_param('skin_variant', $options),
            'apply_source_formatting' => $this->get_param('apply_source_formatting', $options),
            'remove_script_host' => $this->get_param('remove_script_host', $options),
            'entity_encoding' => $this->get_param('entity_encoding', $options),
            'theme_advanced_font_sizes' => $this->get_param('font_sizes', $options),
            'theme_advanced_layout_manager' => $this->get_param('layout_manager', $options),
            'theme_advanced_toolbar_align' => $this->get_param('toolbar_align', $options),
            'theme_advanced_toolbar_location' => $this->get_param('toolbar_location', $options),
            'theme_advanced_statusbar_location' => $this->get_param('statusbar_location', $options),
            'theme_advanced_fonts' => $this->get_param('fonts', $options),
            'theme_advanced_resize_horizontal' => $this->get_param('resize_horizontal', $options),
            'theme_advanced_resizing_min_height' => $this->get_param('min_height', $options),
            'theme_advanced_resizing' => $this->get_param('resizing', $options),
        );

        // add spell checker paramerters if it's enabled
        $spellchecker = false;
        if (in_array(self::PLUGIN_SPELLCHECKER, $plugins)) {
            $params['spellchecker_rpc_url'] = $CFG->wwwroot . "/lib/editor/" . $this->name . "/tiny_mce/" . $this->version . "/plugins/spellchecker/rpc.php";
            $spellchecker = true;
        }
        $params['spellchecker_rpc_url'] = $CFG->wwwroot . "/lib/editor/" . $this->name . "/tiny_mce/" . $this->version . "/plugins/spellchecker/rpc.php";

        // default buttons
        $buttonsdefault = array(
            array(
                self::BUTTON_FONTSELECT, self::BUTTON_FONTSIZE, self::BUTTON_FORMAT, self::BUTTON_SPACER, self::BUTTON_UNDO, self::BUTTON_REDO,
                self::BUTTON_SPACER, self::BUTTON_SEARCH, self::BUTTON_SPACER, self::BUTTON_REPLACE, self::BUTTON_FULLSCREEN,
            ),
            array(
                self::BUTTON_BOLD, self::BUTTON_ITALIC, self::BUTTON_UNDERLINE, self::BUTTON_STRIKETHROUGH, self::BUTTON_SUB, self::BUTTON_SUP, self::BUTTON_SPACER,
                self::BUTTON_JUSTYLEFT, self::BUTTON_JUSTYCENTER, self::BUTTON_JUSTYRIGHT, self::BUTTON_SPACER, self::BUTTON_CLEANUP, self::BUTTON_REMOVEFORMAT,
                self::BUTTON_PASTETEXT, self::BUTTON_PASTEWORD, self::BUTTON_SPACER, self::BUTTON_FORECOLOR, self::BUTTON_BACKCOLOR, self::BUTTON_SPACER,
                self::BUTTON_LTR, self::BUTTON_RTL,
            ),
            array(
                self::BUTTON_BULLIST, self::BUTTON_NUMLIST, self::BUTTON_OUTDENT, self::BUTTON_INDENT, self::BUTTON_SPACER, self::BUTTON_LINK,
                self::BUTTON_UNLINK, self::BUTTON_MOODLENOLINK, self::BUTTON_SPACER, self::BUTTON_IMAGE, self::BUTTON_NONBREAKING,
                self::BUTTON_CHAR, self::BUTTON_MOODLEMEDIA, self::BUTTON_TABLE, self::BUTTON_SPACER, self::BUTTON_CODE,
            ),
        );

        // add spell checker button if it's enabled
        if ($spellchecker) {
            $buttonsdefault[2][] = 'spellchecker';
        }

        // add moodle emotion button if it's enabled
        $moodleemoticon = false;
        if (in_array(self::PLUGIN_MOODLEEMOTICON, $plugins)) {
            $buttonsdefault[2][] = self::PLUGIN_MOODLEEMOTICON;

            $manager = get_emoticon_manager();
            $emoticons = $manager->get_emoticons();
            $imgs = array();
            // see the TinyMCE plugin moodleemoticon for how the emoticon index is (ab)used :-S
            $index = 0;
            foreach ($emoticons as $emoticon) {
                $imgs[$emoticon->text] = $OUTPUT->render(
                        $manager->prepare_renderable_emoticon($emoticon, array('class' => 'emoticon emoticon-index-' . $index++)));
            }
            $params['moodleemoticon_emoticons'] = json_encode($imgs);
            $moodleemoticon = true;
        }

        // add drag math button if it's enabled
        $dragmath = false;
        if (in_array(self::PLUGIN_DRAGMATH, $plugins)) {
            $buttonsdefault[2][] = self::PLUGIN_DRAGMATH;
            $dragmath = true;
        }

        // get user custom buttons
        $buttons = $this->get_param('buttons', $options);
        $moodlenolink = false;

        // render the default buttons if there are no custom ones
        if ($buttons == '') {
            foreach ($buttonsdefault as $buttonindex => $buttonvalues) {
                if (in_array(self::BUTTON_MOODLENOLINK, $buttonvalues)) {
                    $moodlenolink = true;
                }
                $params['theme_advanced_buttons' . ($buttonindex + 1)] = join(',', $buttonvalues);
            }
        } else {

            foreach ($buttons as $buttonindex => $buttonvalues) {
                if (in_array(self::BUTTON_MOODLENOLINK, $buttonvalues)) {
                    $moodlenolink = true;
                }

                $action = '';
                if (isset($buttonvalues[0])) {
                    if ($buttonvalues[0] === 'add') {
                        $action = '_add';
                        array_shift($buttonvalues);
                    } else if ($buttonvalues[0] === 'before') {
                        $action = '_add_before';
                        array_shift($buttonvalues);
                    }
                }

                if (in_array(self::PLUGIN_DRAGMATH, $buttonvalues) && !$dragmath) {
                    if (($key = array_search(self::PLUGIN_DRAGMATH, $buttonvalues)) !== false) {
                        unset($buttonvalues[$key]);
                    }
                }
                if (in_array(self::PLUGIN_MOODLEEMOTICON, $buttonvalues) && !$moodleemoticon) {
                    if (($key = array_search(self::PLUGIN_MOODLEEMOTICON, $buttonvalues)) !== false) {
                        unset($buttonvalues[$key]);
                    }
                }

                if (isset($buttonsdefault[$buttonindex]) && $action != '') {
                    $params['theme_advanced_buttons' . ($buttonindex+1)] = join(',', $buttonsdefault[$buttonindex]);
                    $params['theme_advanced_buttons' . ($buttonindex+1) . $action] = join(',', $buttonvalues);
                } else {
                    $params['theme_advanced_buttons' . ($buttonindex+1)] = join(',', $buttonvalues);
                }
            }
        }

        // add plugins
        // remove the plugin moodle no link, if the button is not added
        if (!$moodlenolink) {
            if (($key = array_search(self::PLUGIN_MOODLENOLINK, $plugins)) !== false) {
                unset($plugins[$key]);
            }
        }
        $params['plugins'] = join(',', $plugins);

        // other settings
        if (empty($CFG->xmlstrictheaders) and (!empty($options['legacy']) or !empty($options['noclean']) or !empty($options['trusted']))) {
            // now deal somehow with non-standard tags, people scream when we do not make moodle code xtml strict,
            // but they scream even more when we strip all tags that are not strict :-(
            $params['valid_elements'] = 'script[src|type],*[*]'; // for some reason the *[*] does not inlcude javascript src attribute MDL-25836
            $params['invalid_elements'] = '';
        }

        if (empty($options['legacy'])) {
            if (isset($options['maxfiles']) and $options['maxfiles'] != 0) {
                $params['file_browser_callback'] = "M.editor_" . $this->name . ".filepicker";
            }
        }

        //Add onblur event for client side text validation
        if (!empty($options['required'])) {
            $params['init_instance_callback'] = 'M.editor_" . $this->name . ".onblur_event';
        }

        return $params;
    }

    /**
     * Merge the current options with the configurations for the same instance in config.php
     * 
     * @param array $options
     * @param string $elementid
     * @return array
     */
    protected function merge_options($elementid, $options)
    {
        global $CFG;

        // return current options, if there are no customization from the config.php file to merge
        if (!isset($CFG->mootinymce_options[$elementid])) {
            return $options;
        }

        return array_merge($CFG->mootinymce_options[$elementid], $options);
    }
}