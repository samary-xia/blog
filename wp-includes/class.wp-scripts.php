<?php
/**
 * Dependencies API: WP_Scripts class
 *
 * @since 2.6.0
 *
 * @package WordPress
 * @subpackage Dependencies
 */

/**
 * Core class used to register scripts.
 *
 * @since 2.1.0
 *
 * @see WP_Dependencies
 */
class WP_Scripts extends WP_Dependencies
{
    /**
     * Base URL for scripts.
     *
     * Full URL with trailing slash.
     *
     * @since 2.6.0
     * @var string
     */
    public $base_url;

    /**
     * URL of the content directory.
     *
     * @since 2.8.0
     * @var string
     */
    public $content_url;

    /**
     * Default version string for scripts.
     *
     * @since 2.6.0
     * @var string
     */
    public $default_version;

    /**
     * Holds handles of scripts which are enqueued in footer.
     *
     * @since 2.8.0
     * @var array
     */
    public $in_footer = array();

    /**
     * Holds a list of script handles which will be concatenated.
     *
     * @since 2.8.0
     * @var string
     */
    public $concat = '';

    /**
     * Holds a string which contains script handles and their version.
     *
     * @since 2.8.0
     * @deprecated 3.4.0
     * @var string
     */
    public $concat_version = '';

    /**
     * Whether to perform concatenation.
     *
     * @since 2.8.0
     * @var bool
     */
    public $do_concat = false;

    /**
     * Holds HTML markup of scripts and additional data if concatenation
     * is enabled.
     *
     * @since 2.8.0
     * @var string
     */
    public $print_html = '';

    /**
     * Holds inline code if concatenation is enabled.
     *
     * @since 2.8.0
     * @var string
     */
    public $print_code = '';

    /**
     * Holds a list of script handles which are not in the default directory
     * if concatenation is enabled.
     *
     * Unused in core.
     *
     * @since 2.8.0
     * @var string
     */
    public $ext_handles = '';

    /**
     * Holds a string which contains handles and versions of scripts which
     * are not in the default directory if concatenation is enabled.
     *
     * Unused in core.
     *
     * @since 2.8.0
     * @var string
     */
    public $ext_version = '';

    /**
     * List of default directories.
     *
     * @since 2.8.0
     * @var array
     */
    public $default_dirs;

    /**
     * Holds a string which contains the type attribute for script tag.
     *
     * If the current theme does not declare HTML5 support for 'script',
     * then it initializes as `type='text/javascript'`.
     *
     * @since 5.3.0
     * @var string
     */
    private $type_attr = '';

    /**
     * Constructor.
     *
     * @since 2.6.0
     */
    public function __construct()
    {
        $this->init();
        add_action('init', array($this, 'init'), 0);
    }

    /**
     * Initialize the class.
     *
     * @since 3.4.0
     */
    public function init()
    {
        if (
            function_exists('is_admin') && !is_admin()
            &&
            function_exists('current_theme_supports') && !current_theme_supports('html5', 'script')
        ) {
            $this->type_attr = " type='text/javascript'";
        }

        /**
         * Fires when the WP_Scripts instance is initialized.
         *
         * @param WP_Scripts $this WP_Scripts instance (passed by reference).
         * @since 2.6.0
         *
         */
        do_action_ref_array('wp_default_scripts', array(&$this));
    }

    /**
     * Prints scripts.
     *
     * Prints the scripts passed to it or the print queue. Also prints all necessary dependencies.
     *
     * @param mixed $handles Optional. Scripts to be printed. (void) prints queue, (string) prints
     *                       that script, (array of strings) prints those scripts. Default false.
     * @param int $group Optional. If scripts were queued in groups prints this group number.
     *                       Default false.
     * @return array Scripts that have been printed.
     * @since 2.8.0 Added the `$group` parameter.
     *
     * @since 2.1.0
     */
    public function print_scripts($handles = false, $group = false)
    {
        return $this->do_items($handles, $group);
    }

    /**
     * Prints extra scripts of a registered script.
     *
     * @param string $handle The script's registered handle.
     * @param bool $echo Optional. Whether to echo the extra script instead of just returning it.
     *                       Default true.
     * @return bool|string|void Void if no data exists, extra scripts if `$echo` is true, true otherwise.
     * @see print_extra_script()
     *
     * @since 2.1.0
     * @since 2.8.0 Added the `$echo` parameter.
     * @deprecated 3.3.0
     *
     */
    public function print_scripts_l10n($handle, $echo = true)
    {
        _deprecated_function(__FUNCTION__, '3.3.0', 'WP_Scripts::print_extra_script()');
        return $this->print_extra_script($handle, $echo);
    }

    /**
     * Prints extra scripts of a registered script.
     *
     * @param string $handle The script's registered handle.
     * @param bool $echo Optional. Whether to echo the extra script instead of just returning it.
     *                       Default true.
     * @return bool|string|void Void if no data exists, extra scripts if `$echo` is true, true otherwise.
     * @since 3.3.0
     *
     */
    public function print_extra_script($handle, $echo = true)
    {
        $output = $this->get_data($handle, 'data');
        if (!$output) {
            return;
        }

        if (!$echo) {
            return $output;
        }

        echo "<script{$this->type_attr}>\n";

        // CDATA is not needed for HTML 5.
        if ($this->type_attr) {
            echo "/* <![CDATA[ */\n";
        }

        echo "$output\n";

        if ($this->type_attr) {
            echo "/* ]]> */\n";
        }

        echo "</script>\n";

        return true;
    }

    /**
     * Processes a script dependency.
     *
     * @param string $handle The script's registered handle.
     * @param int|false $group Optional. Group level: (int) level, (false) no groups. Default false.
     * @return bool True on success, false on failure.
     * @since 2.6.0
     * @since 2.8.0 Added the `$group` parameter.
     *
     * @see WP_Dependencies::do_item()
     *
     */
    public function do_item($handle, $group = false)
    {
        if (!parent::do_item($handle)) {
            return false;
        }

        if (0 === $group && $this->groups[$handle] > 0) {
            $this->in_footer[] = $handle;
            return false;
        }

        if (false === $group && in_array($handle, $this->in_footer, true)) {
            $this->in_footer = array_diff($this->in_footer, (array)$handle);
        }

        $obj = $this->registered[$handle];

        if (null === $obj->ver) {
            $ver = '';
        } else {
            $ver = $obj->ver ? $obj->ver : $this->default_version;
        }

        if (isset($this->args[$handle])) {
            $ver = $ver ? $ver . '&amp;' . $this->args[$handle] : $this->args[$handle];
        }

        $src = $obj->src;
        $cond_before = '';
        $cond_after = '';
        $conditional = isset($obj->extra['conditional']) ? $obj->extra['conditional'] : '';

        if ($conditional) {
            $cond_before = "<!--[if {$conditional}]>\n";
            $cond_after = "<![endif]-->\n";
        }

        $before_handle = $this->print_inline_script($handle, 'before', false);
        $after_handle = $this->print_inline_script($handle, 'after', false);

        if ($before_handle) {
            $before_handle = sprintf("<script%s>\n%s\n</script>\n", $this->type_attr, $before_handle);
        }

        if ($after_handle) {
            $after_handle = sprintf("<script%s>\n%s\n</script>\n", $this->type_attr, $after_handle);
        }

        if ($before_handle || $after_handle) {
            $inline_script_tag = $cond_before . $before_handle . $after_handle . $cond_after;
        } else {
            $inline_script_tag = '';
        }

        if ($this->do_concat) {
            /**
             * Filters the script loader source.
             *
             * @param string $src Script loader source path.
             * @param string $handle Script handle.
             * @since 2.2.0
             *
             */
            $srce = apply_filters('script_loader_src', $src, $handle);

            if ($this->in_default_dir($srce) && ($before_handle || $after_handle)) {
                $this->do_concat = false;

                // Have to print the so-far concatenated scripts right away to maintain the right order.
                _print_scripts();
                $this->reset();
            } elseif ($this->in_default_dir($srce) && !$conditional) {
                $this->print_code .= $this->print_extra_script($handle, false);
                $this->concat .= "$handle,";
                $this->concat_version .= "$handle$ver";
                return true;
            } else {
                $this->ext_handles .= "$handle,";
                $this->ext_version .= "$handle$ver";
            }
        }

        $has_conditional_data = $conditional && $this->get_data($handle, 'data');

        if ($has_conditional_data) {
            echo $cond_before;
        }

        $this->print_extra_script($handle);

        if ($has_conditional_data) {
            echo $cond_after;
        }

        // A single item may alias a set of items, by having dependencies, but no source.
        if (!$src) {
            if ($inline_script_tag) {
                if ($this->do_concat) {
                    $this->print_html .= $inline_script_tag;
                } else {
                    echo $inline_script_tag;
                }
            }

            return true;
        }

        $translations = $this->print_translations($handle, false);
        if ($translations) {
            $translations = sprintf("<script%s>\n%s\n</script>\n", $this->type_attr, $translations);
        }

        if (!preg_match('|^(https?:)?//|', $src) && !($this->content_url && 0 === strpos($src, $this->content_url))) {
            $src = $this->base_url . $src;
        }

        if (!empty($ver)) {
            $src = add_query_arg('ver', $ver, $src);
        }

        /** This filter is documented in wp-includes/class.wp-scripts.php */
        $src = esc_url(apply_filters('script_loader_src', $src, $handle));

        if (!$src) {
            return true;
        }

        $tag = $translations . $cond_before . $before_handle;
        $tag .= sprintf("<script%s src='%s'></script>\n", $this->type_attr, $src);
        $tag .= $after_handle . $cond_after;

        /**
         * Filters the HTML script tag of an enqueued script.
         *
         * @param string $tag The `<script>` tag for the enqueued script.
         * @param string $handle The script's registered handle.
         * @param string $src The script's source URL.
         * @since 4.1.0
         *
         */
        $tag = apply_filters('script_loader_tag', $tag, $handle, $src);

        if ($this->do_concat) {
            $this->print_html .= $tag;
        } else {
            echo $tag;
        }

        return true;
    }

    /**
     * Adds extra code to a registered script.
     *
     * @param string $handle Name of the script to add the inline script to. Must be lowercase.
     * @param string $data String containing the javascript to be added.
     * @param string $position Optional. Whether to add the inline script before the handle
     *                         or after. Default 'after'.
     * @return bool True on success, false on failure.
     * @since 4.5.0
     *
     */
    public function add_inline_script($handle, $data, $position = 'after')
    {
        if (!$data) {
            return false;
        }

        if ('after' !== $position) {
            $position = 'before';
        }

        $script = (array)$this->get_data($handle, $position);
        $script[] = $data;

        return $this->add_data($handle, $position, $script);
    }

    /**
     * Prints inline scripts registered for a specific handle.
     *
     * @param string $handle Name of the script to add the inline script to. Must be lowercase.
     * @param string $position Optional. Whether to add the inline script before the handle
     *                         or after. Default 'after'.
     * @param bool $echo Optional. Whether to echo the script instead of just returning it.
     *                         Default true.
     * @return string|false Script on success, false otherwise.
     * @since 4.5.0
     *
     */
    public function print_inline_script($handle, $position = 'after', $echo = true)
    {
        $output = $this->get_data($handle, $position);

        if (empty($output)) {
            return false;
        }

        $output = trim(implode("\n", $output), "\n");

        if ($echo) {
            printf("<script%s>\n%s\n</script>\n", $this->type_attr, $output);
        }

        return $output;
    }

    /**
     * Localizes a script, only if the script has already been added.
     *
     * @param string $handle Name of the script to attach data to.
     * @param string $object_name Name of the variable that will contain the data.
     * @param array $l10n Array of data to localize.
     * @return bool True on success, false on failure.
     * @since 2.1.0
     *
     */
    public function localize($handle, $object_name, $l10n)
    {
        if ($handle === 'jquery') {
            $handle = 'jquery-core';
        }

        if (is_array($l10n) && isset($l10n['l10n_print_after'])) { // back compat, preserve the code in 'l10n_print_after' if present.
            $after = $l10n['l10n_print_after'];
            unset($l10n['l10n_print_after']);
        }

        foreach ((array)$l10n as $key => $value) {
            if (!is_scalar($value)) {
                continue;
            }

            $l10n[$key] = html_entity_decode((string)$value, ENT_QUOTES, 'UTF-8');
        }

        $script = "var $object_name = " . wp_json_encode($l10n) . ';';

        if (!empty($after)) {
            $script .= "\n$after;";
        }

        $data = $this->get_data($handle, 'data');

        if (!empty($data)) {
            $script = "$data\n$script";
        }

        return $this->add_data($handle, 'data', $script);
    }

    /**
     * Sets handle group.
     *
     * @param string $handle Name of the item. Should be unique.
     * @param bool $recursion Internal flag that calling function was called recursively.
     * @param int|false $group Optional. Group level: (int) level, (false) no groups. Default false.
     * @return bool Not already in the group or a lower group
     * @since 2.8.0
     *
     * @see WP_Dependencies::set_group()
     *
     */
    public function set_group($handle, $recursion, $group = false)
    {
        if (isset($this->registered[$handle]->args) && $this->registered[$handle]->args === 1) {
            $grp = 1;
        } else {
            $grp = (int)$this->get_data($handle, 'group');
        }

        if (false !== $group && $grp > $group) {
            $grp = $group;
        }

        return parent::set_group($handle, $recursion, $grp);
    }

    /**
     * Sets a translation textdomain.
     *
     * @param string $handle Name of the script to register a translation domain to.
     * @param string $domain Optional. Text domain. Default 'default'.
     * @param string $path Optional. The full file path to the directory containing translation files.
     * @return bool True if the text domain was registered, false if not.
     * @since 5.0.0
     * @since 5.1.0 The `$domain` parameter was made optional.
     *
     */
    public function set_translations($handle, $domain = 'default', $path = null)
    {
        if (!isset($this->registered[$handle])) {
            return false;
        }

        /** @var \_WP_Dependency $obj */
        $obj = $this->registered[$handle];

        if (!in_array('wp-i18n', $obj->deps, true)) {
            $obj->deps[] = 'wp-i18n';
        }

        return $obj->set_translations($domain, $path);
    }

    /**
     * Prints translations set for a specific handle.
     *
     * @param string $handle Name of the script to add the inline script to. Must be lowercase.
     * @param bool $echo Optional. Whether to echo the script instead of just returning it.
     *                       Default true.
     * @return string|false Script on success, false otherwise.
     * @since 5.0.0
     *
     */
    public function print_translations($handle, $echo = true)
    {
        if (!isset($this->registered[$handle]) || empty($this->registered[$handle]->textdomain)) {
            return false;
        }

        $domain = $this->registered[$handle]->textdomain;
        $path = $this->registered[$handle]->translations_path;

        $json_translations = load_script_textdomain($handle, $domain, $path);

        if (!$json_translations) {
            // Register empty locale data object to ensure the domain still exists.
            $json_translations = '{ "locale_data": { "messages": { "": {} } } }';
        }

        $output = <<<JS
( function( domain, translations ) {
	var localeData = translations.locale_data[ domain ] || translations.locale_data.messages;
	localeData[""].domain = domain;
	wp.i18n.setLocaleData( localeData, domain );
} )( "{$domain}", {$json_translations} );
JS;

        if ($echo) {
            printf("<script%s>\n%s\n</script>\n", $this->type_attr, $output);
        }

        return $output;
    }

    /**
     * Determines script dependencies.
     *
     * @param mixed $handles Item handle and argument (string) or item handles and arguments (array of strings).
     * @param bool $recursion Internal flag that function is calling itself.
     * @param int|false $group Optional. Group level: (int) level, (false) no groups. Default false.
     * @return bool True on success, false on failure.
     * @since 2.1.0
     *
     * @see WP_Dependencies::all_deps()
     *
     */
    public function all_deps($handles, $recursion = false, $group = false)
    {
        $r = parent::all_deps($handles, $recursion, $group);
        if (!$recursion) {
            /**
             * Filters the list of script dependencies left to print.
             *
             * @param string[] $to_do An array of script dependency handles.
             * @since 2.3.0
             *
             */
            $this->to_do = apply_filters('print_scripts_array', $this->to_do);
        }
        return $r;
    }

    /**
     * Processes items and dependencies for the head group.
     *
     * @return array Handles of items that have been processed.
     * @see WP_Dependencies::do_items()
     *
     * @since 2.8.0
     *
     */
    public function do_head_items()
    {
        $this->do_items(false, 0);
        return $this->done;
    }

    /**
     * Processes items and dependencies for the footer group.
     *
     * @return array Handles of items that have been processed.
     * @see WP_Dependencies::do_items()
     *
     * @since 2.8.0
     *
     */
    public function do_footer_items()
    {
        $this->do_items(false, 1);
        return $this->done;
    }

    /**
     * Whether a handle's source is in a default directory.
     *
     * @param string $src The source of the enqueued script.
     * @return bool True if found, false if not.
     * @since 2.8.0
     *
     */
    public function in_default_dir($src)
    {
        if (!$this->default_dirs) {
            return true;
        }

        if (0 === strpos($src, '/' . WPINC . '/js/l10n')) {
            return false;
        }

        foreach ((array)$this->default_dirs as $test) {
            if (0 === strpos($src, $test)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Resets class properties.
     *
     * @since 2.8.0
     */
    public function reset()
    {
        $this->do_concat = false;
        $this->print_code = '';
        $this->concat = '';
        $this->concat_version = '';
        $this->print_html = '';
        $this->ext_version = '';
        $this->ext_handles = '';
    }
}
