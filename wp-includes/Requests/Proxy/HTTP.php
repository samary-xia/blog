<?php
/**
 * HTTP Proxy connection interface
 *
 * @package Requests
 * @subpackage Proxy
 * @since 1.6
 */

/**
 * HTTP Proxy connection interface
 *
 * Provides a handler for connection via an HTTP proxy
 *
 * @package Requests
 * @subpackage Proxy
 * @since 1.6
 */
class Requests_Proxy_HTTP implements Requests_Proxy
{
    /**
     * Proxy host and port
     *
     * Notation: "host:port" (eg 127.0.0.1:8080 or someproxy.com:3128)
     *
     * @var string
     */
    public $proxy;

    /**
     * Username
     *
     * @var string
     */
    public $user;

    /**
     * Password
     *
     * @var string
     */
    public $pass;

    /**
     * Do we need to authenticate? (ie username & password have been provided)
     *
     * @var boolean
     */
    public $use_authentication;

    /**
     * Constructor
     *
     * @param array|null $args Array of user and password. Must have exactly two elements
     * @throws Requests_Exception On incorrect number of arguments (`authbasicbadargs`)
     * @since 1.6
     */
    public function __construct($args = null)
    {
        if (is_string($args)) {
            $this->proxy = $args;
        } elseif (is_array($args)) {
            if (count($args) == 1) {
                list($this->proxy) = $args;
            } elseif (count($args) == 3) {
                list($this->proxy, $this->user, $this->pass) = $args;
                $this->use_authentication = true;
            } else {
                throw new Requests_Exception('Invalid number of arguments', 'proxyhttpbadargs');
            }
        }
    }

    /**
     * Register the necessary callbacks
     *
     * @param Requests_Hooks $hooks Hook system
     * @see curl_before_send
     * @see fsockopen_remote_socket
     * @see fsockopen_remote_host_path
     * @see fsockopen_header
     * @since 1.6
     */
    public function register(Requests_Hooks &$hooks)
    {
        $hooks->register('curl.before_send', array(&$this, 'curl_before_send'));

        $hooks->register('fsockopen.remote_socket', array(&$this, 'fsockopen_remote_socket'));
        $hooks->register('fsockopen.remote_host_path', array(&$this, 'fsockopen_remote_host_path'));
        if ($this->use_authentication) {
            $hooks->register('fsockopen.after_headers', array(&$this, 'fsockopen_header'));
        }
    }

    /**
     * Set cURL parameters before the data is sent
     *
     * @param resource $handle cURL resource
     * @since 1.6
     */
    public function curl_before_send(&$handle)
    {
        curl_setopt($handle, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
        curl_setopt($handle, CURLOPT_PROXY, $this->proxy);

        if ($this->use_authentication) {
            curl_setopt($handle, CURLOPT_PROXYAUTH, CURLAUTH_ANY);
            curl_setopt($handle, CURLOPT_PROXYUSERPWD, $this->get_auth_string());
        }
    }

    /**
     * Alter remote socket information before opening socket connection
     *
     * @param string $remote_socket Socket connection string
     * @since 1.6
     */
    public function fsockopen_remote_socket(&$remote_socket)
    {
        $remote_socket = $this->proxy;
    }

    /**
     * Alter remote path before getting stream data
     *
     * @param string $path Path to send in HTTP request string ("GET ...")
     * @param string $url Full URL we're requesting
     * @since 1.6
     */
    public function fsockopen_remote_host_path(&$path, $url)
    {
        $path = $url;
    }

    /**
     * Add extra headers to the request before sending
     *
     * @param string $out HTTP header string
     * @since 1.6
     */
    public function fsockopen_header(&$out)
    {
        $out .= sprintf("Proxy-Authorization: Basic %s\r\n", base64_encode($this->get_auth_string()));
    }

    /**
     * Get the authentication string (user:pass)
     *
     * @return string
     * @since 1.6
     */
    public function get_auth_string()
    {
        return $this->user . ':' . $this->pass;
    }
}