<?php

class wprp_utils
{
    /**
     * Get site.
     *
     * @since    1.0.0
     * @access   public
     * @return   string    The site.
     */
    public function get_site() {
        // get url and trim trailing slash
        $url = trim(site_url(), '/');

        // set site
        $site = preg_replace('#^https?://#', '', $url);

        // check if site starts with 'www.'
        if (substr($site, 0, 4) === 'www.') {

            // remove 'www.' from site
            $site = substr($site, 4);

        }

        return $site;
    }

    public function get_client_ip_address() {

        $ip_address = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ip_address = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip_address = 'UNKNOWN';
        }
        return $ip_address;
    }
}
