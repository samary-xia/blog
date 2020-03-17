<?php

class wprp_analytics {
    /**
     * The utils instance of this class.
     *
     * @since    1.1.0
     * @access   protected
     * @var      sovrn\workbench\utils    $utils    The utils instance of this class.
     */
    protected $utils;


    /**
     * The Mixpanel library instance of this class.
     *
     * @since    1.1.0
     * @access   private
     * @var      Mixpanel    $mp    The Mixpanel library instance of this class.
     */
    protected $mp;


    /**
     * Initialize the class and set its properties.
     *
     * @since    1.1.0
     */
    public function __construct($mixpanel_token) {
        // set utils instance to this class
        $this->utils = new wprp_utils(False);

        // get site as distinct id
        $this->distinct_id = $this->utils->get_site();

        // get client ip address
        $this->ip_address = $this->utils->get_client_ip_address();

        // set mixpanel options
        $mixpanel_options = ['fork' => true, 'consumer' => 'socket', 'async' => false, 'connect_timeout' => 1];
        if (getenv('SOVRN_ENV') == "QA") {
            $mixpanel_options = ['fork' => true, 'consumer' => 'file', 'async' => false, 'connect_timeout' => 0, 'file' => '/tmp/mixpanel.txt'];
        }

        // set mixpanel library
        $this->mp = Mixpanel::getInstance($mixpanel_token, $mixpanel_options);

        // set mixpanel identity
        $this->mp->identify($this->distinct_id);

        // end function
        return null;
    }


    public function get_label($label_id) {
        // set list of labels
        $labels = [
            'name'                          => '$name',
            'created'                       => 'Created',
            'installed'                     => 'Installed',
            'uninstalled'                   => 'Uninstalled',
            'workbench_activated'           => 'Activated - WB',
            'workbench_active_install'      => 'Active Install - WB',
            'ednet_activated'               => 'Activated - EA',
            'ednet_active_install'          => 'Active Install - EA',
            'rpbs_activated'                => 'Activated - RPBS',
            'rpbs_active_install'           => 'Active Install - RPBS',
            'wprp_activated'                => 'Activated - WPRP',
            'wprp_active_install'           => 'Active Install - WPRP',
            'rp_activated'                  => 'Activated - RP',
            'rp_active_install'             => 'Active Install - RP',
            'platform'                      => 'Platform',
            'url'                           => 'URL',
            'acknowledged_legal'            => 'Acknowledged Legal',
            'registered'                    => 'Registered',
            'forgot_password'               => 'Forgot Password',
            'logged_in'                     => 'Logged In',
            'logged_out'                    => 'Logged Out',
            'email'                         => '$email',
            'shared_post'                   => 'Shared Post',
            'included_status'               => 'Included Status',
            'channels'                      => 'Channels',

            'php_version'                   => 'PHP Version',
        ];

        // get label
        $label = $label_id && isset($labels[$label_id]) ? $labels[$label_id] : null;

        // return label
        return $label;

    }

    public function create_profile($props, $platform) {
        // set defaults
        $props['name'] = $this->distinct_id;
        $props['created'] = date(DATE_ATOM);
        $props['php_version'] = phpversion();
        $props[$platform . '_activated'] = true;

        // set profile properties with labels
        $props_with_labels = [];

        // iterate on props
        foreach ($props as $label_id => $value) {
            // get label by label id
            $label = $this->get_label($label_id);
            // check if have label
            if ($label) {
                // add to event label and value to props_with_labels
                $props_with_labels[$label] = $value;
            }
        }

        // set mixpanel profile properties
        $this->mp->people->setOnce($this->distinct_id, $props_with_labels, $this->ip_address);

        // end function
        return $props_with_labels;
    }

    public function update_profile_property($label_id, $value) {

        // get label by label id
        $label = $this->get_label($label_id);

        // set property array
        $prop = [$label => $value];

        // update mixpanel profile property
        $this->mp->people->set($this->distinct_id, $prop, $this->ip_address);

        // end function
        return null;
    }


    public function track($label_id, $props=[]) {

        // get event label by event id
        $label = $this->get_label($label_id);

        // set profile properties with labels
        $props_with_labels = [];

        // iterate on props
        foreach ($props as $prop_label_id => $value) {

            // get label by label id
            $prop_label = $this->get_label($prop_label_id);

            // check if have label
            if ($prop_label) {

                // add to event label and value to props_with_labels
                $props_with_labels[$prop_label] = $value;

            }

        }

        // track mixpanel event
        $this->mp->track($label, $props_with_labels);


        // end function
        return null;

    }

    /**
     * active_install
     *
     * Is this an active install?
     * Only check once per day
     *
     * WordPress ONLY method
     */
    public function active_install($platform) {
        $last_sent = get_option($platform . "_last_sent", 0);
        if (date('Ymd') != date('Ymd', strtotime($last_sent))) {
            // track "active install"
            $this->track($platform . "_active_install");
            update_option($platform . "_last_sent", date('Ymd', time()));
        }
    }
}
