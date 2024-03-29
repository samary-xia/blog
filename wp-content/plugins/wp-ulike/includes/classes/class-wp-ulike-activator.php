<?php
/**
 * WP ULike Activator
 *
 * @package    wp-ulike
 * @author     TechnoWich 2021
 * @link       https://wpulike.com
 */

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class wp_ulike_activator
{

    /**
     * Instance of this class.
     *
     * @var object
     */
    protected static $instance = null;

    /**
     * Other variables
     */
    protected static $tables, $database;

    public function __construct()
    {
        global $wpdb;

        self::$database = $wpdb;
        self::$tables = array(
            'posts' => self::$database->prefix . "ulike",
            'comments' => self::$database->prefix . "ulike_comments",
            'activities' => self::$database->prefix . "ulike_activities",
            'forums' => self::$database->prefix . "ulike_forums",
            'meta' => self::$database->prefix . "ulike_meta"
        );
    }


    public static function activate()
    {
        self::install_tables();
    }

    public static function install_tables()
    {

        $max_index_length = 191;
        $charset_collate = '';

        if (!empty($wpdb->charset)) {
            $charset_collate = "DEFAULT CHARACTER SET " . self::$database->charset;
        }
        if (!empty(self::$database->collate)) {
            $charset_collate .= " COLLATE " . self::$database->collate;
        }

        if (!function_exists('maybe_create_table')) {
            // Add one library admin function for next function
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        }

        // Extract array to variables
        extract(self::$tables);

        // Posts table
        maybe_create_table($posts, "CREATE TABLE IF NOT EXISTS `{$posts}` (
			`id` bigint(20) NOT NULL AUTO_INCREMENT,
			`post_id` bigint(20) NOT NULL,
			`date_time` datetime NOT NULL,
			`ip` varchar(100) NOT NULL,
			`user_id` varchar(100) NOT NULL,
			`status` varchar(30) NOT NULL,
			PRIMARY KEY (`id`),
			KEY `post_id` (`post_id`),
			KEY `date_time` (`date_time`),
			KEY `user_id` (`user_id`),
			KEY `status` (`status`)
		) $charset_collate AUTO_INCREMENT=1;");

        // Comments table
        maybe_create_table($comments, "CREATE TABLE IF NOT EXISTS `{$comments}` (
			`id` bigint(20) NOT NULL AUTO_INCREMENT,
			`comment_id` bigint(20) NOT NULL,
			`date_time` datetime NOT NULL,
			`ip` varchar(100) NOT NULL,
			`user_id` varchar(100) NOT NULL,
			`status` varchar(30) NOT NULL,
			PRIMARY KEY (`id`),
			KEY `comment_id` (`comment_id`),
			KEY `date_time` (`date_time`),
			KEY `user_id` (`user_id`),
			KEY `status` (`status`)
		) $charset_collate AUTO_INCREMENT=1;");

        // Activities table
        maybe_create_table($activities, "CREATE TABLE IF NOT EXISTS `{$activities}` (
			`id` bigint(20) NOT NULL AUTO_INCREMENT,
			`activity_id` bigint(20) NOT NULL,
			`date_time` datetime NOT NULL,
			`ip` varchar(100) NOT NULL,
			`user_id` varchar(100) NOT NULL,
			`status` varchar(30) NOT NULL,
			PRIMARY KEY (`id`),
			KEY `activity_id` (`activity_id`),
			KEY `date_time` (`date_time`),
			KEY `user_id` (`user_id`),
			KEY `status` (`status`)
		) $charset_collate AUTO_INCREMENT=1;");

        // Forums table
        maybe_create_table($forums, "CREATE TABLE IF NOT EXISTS `{$forums}` (
			`id` bigint(20) NOT NULL AUTO_INCREMENT,
			`topic_id` bigint(20) NOT NULL,
			`date_time` datetime NOT NULL,
			`ip` varchar(100) NOT NULL,
			`user_id` varchar(100) NOT NULL,
			`status` varchar(30) NOT NULL,
			PRIMARY KEY (`id`),
			KEY `topic_id` (`topic_id`),
			KEY `date_time` (`date_time`),
			KEY `user_id` (`user_id`),
			KEY `status` (`status`)
		) $charset_collate AUTO_INCREMENT=1;");

        // Meta values table
        maybe_create_table($meta, "CREATE TABLE IF NOT EXISTS `{$meta}` (
			`meta_id` bigint(20) unsigned NOT NULL auto_increment,
			`item_id` bigint(20) unsigned NOT NULL default '0',
			`meta_group` varchar(100) default NULL,
			`meta_key` varchar(255) default NULL,
			`meta_value` longtext,
			PRIMARY KEY  (`meta_id`),
			KEY `item_id` (`item_id`),
			KEY `meta_group` (`meta_group`),
			KEY `meta_key` (`meta_key`($max_index_length))
		) $charset_collate AUTO_INCREMENT=1;");

    }

    public static function upgrade_0()
    {
        // Extract array to variables
        extract(self::$tables);

        // Upgrade Tables
        if (version_compare(get_option('wp_ulike_dbVersion', '1.6'), WP_ULIKE_DB_VERSION, '<')) {
            // Posts ugrades
            self::$database->query("
				ALTER TABLE $posts
				ADD INDEX( `post_id`, `date_time`, `user_id`, `status`),
				CHANGE `user_id` `user_id` VARCHAR(100) NOT NULL,
				CHANGE `ip` `ip` VARCHAR(100) NOT NULL;
			");
            // Comments ugrades
            self::$database->query("
				ALTER TABLE $comments
				ADD INDEX( `comment_id`, `date_time`, `user_id`, `status`),
				CHANGE `user_id` `user_id` VARCHAR(100) NOT NULL,
				CHANGE `ip` `ip` VARCHAR(100) NOT NULL;
			");
            // BuddyPress ugrades
            self::$database->query("
				ALTER TABLE $activities
				ADD INDEX( `activity_id`, `date_time`, `user_id`, `status`),
				CHANGE `user_id` `user_id` VARCHAR(100) NOT NULL,
				CHANGE `ip` `ip` VARCHAR(100) NOT NULL;
			");
            // bbPress upgrades
            self::$database->query("
				ALTER TABLE $forums
				ADD INDEX( `topic_id`, `date_time`, `user_id`, `status`),
				CHANGE `user_id` `user_id` VARCHAR(100) NOT NULL,
				CHANGE `ip` `ip` VARCHAR(100) NOT NULL;
			");
            // Update db version
            update_option('wp_ulike_dbVersion', WP_ULIKE_DB_VERSION);
        }
    }

    /**
     * Return an instance of this class.
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance()
    {
        // If the single instance hasn't been set, set it now.
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }
}