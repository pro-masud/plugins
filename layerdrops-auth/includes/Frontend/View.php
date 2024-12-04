<?php
namespace Layerdrops\Auth\Frontend;

use Google\Client;
use Google_Service_Oauth2;

class View {
    private $gClient;
    private $login_url;

    public function __construct() {
        $this->google_client_assets();

        add_shortcode('google-login', [$this, 'vm_login_with_google']);
        add_action('wp_ajax_vm_login_google', [$this, 'vm_login_google']);
        add_action('admin_init', [$this, 'add_google_ajax_actions']);
    }

    public function google_client_assets() {
        $this->gClient = new Client();
        $this->gClient->setClientId('1028134609395-i5b3okn0ujotsd5hlhhdlh2e0bktsrt2.apps.googleusercontent.com'); // Use environment variables for real use
        $this->gClient->setClientSecret('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'); // Use environment variables for real use
        $this->gClient->setApplicationName("Web Application");
        $this->gClient->setRedirectUri('https://your-public-domain.com/wp-admin/admin-ajax.php?action=vm_login_google');
        $this->gClient->addScope("https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile");


        $this->login_url = $this->gClient->createAuthUrl();
    }

    public function vm_login_with_google() {
        $btnContent = '
            <style>
                .googleBtn {
                    display: table;
                    margin: 0 auto;
                    background: #4285F4;
                    padding: 15px;
                    border-radius: 3px;
                    color: #fff;
                    text-decoration: none;
                }
            </style>
        ';

        if (!is_user_logged_in()) {
            if (!get_option('users_can_register')) {
                return $btnContent . 'Registration is closed!';
            } else {
                return $btnContent . '<a class="googleBtn" href="' . esc_url($this->login_url) . '">Login With Google</a>';
            }
        } else {
            $current_user = wp_get_current_user();
            return $btnContent . '<div class="googleBtn">Hi, ' . esc_html($current_user->first_name) . '! - <a href="' . esc_url(wp_logout_url()) . '">Log Out</a></div>';
        }
    }

    public function vm_login_google() {
        if (isset($_GET['code'])) {
            $token = $this->gClient->fetchAccessTokenWithAuthCode($_GET['code']);
            if (!isset($token['error'])) {
                $oAuth = new Google_Service_Oauth2($this->gClient);
                $userData = $oAuth->userinfo_v2_me->get();

                var_dump($userData);

                if (!email_exists($userData->email)) {
                    $bytes = openssl_random_pseudo_bytes(2);
                    $password = md5(bin2hex($bytes));
                    $user_login = $userData->id;

                    $new_user_id = wp_insert_user([
                        'user_login'     => $user_login,
                        'user_pass'      => $password,
                        'user_email'     => $userData->email,
                        'first_name'     => $userData->givenName,
                        'last_name'      => $userData->familyName,
                        'user_registered' => date('Y-m-d H:i:s'),
                        'role'           => 'subscriber',
                    ]);

                    if ($new_user_id) {
                        wp_new_user_notification($new_user_id);

                        wp_set_current_user($new_user_id);
                        wp_set_auth_cookie($new_user_id, true);
                        wp_redirect(home_url());
                        exit;
                    }
                } else {
                    $user = get_user_by('email', $userData->email);
                    wp_set_current_user($user->ID);
                    wp_set_auth_cookie($user->ID, true);
                    wp_redirect(home_url());
                    exit;
                }
            } else {
                // Log token error for debugging
                error_log('Google token error: ' . print_r($token, true));
                wp_redirect(home_url());
                exit();
            }
        } else {
            wp_redirect(home_url());
            exit();
        }
    }

    public function add_google_ajax_actions() {
        add_action('wp_ajax_nopriv_vm_login_google', [$this, 'vm_login_google']);
    }
}
