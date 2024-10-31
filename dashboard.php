<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<style>

</style>
<div class="pii-dashboard-container">
    <div class="pii-dashboard-header">
        <h1 class="pii-dashboard-header-text">Welcome to PieEye: GDPR + CPRA Cookie Consent + DSR</h1>
    </div>
<?php 

function pieeye_inject_banner(){
    $pieeye_consent = get_option('pieeye_optin_consent', false);
    if($pieeye_consent == "true"){
        $url = get_site_url();
        $body = array(
            'site' => $url,
        );
        $header = array(
            'Content-Type' => 'application/json',
        );
        $args = array(
            'method'      => 'POST',
            'timeout'     => '45',
            'headers'     => $header,
            'body'        => json_encode($body),
            'cookies'     => array(),
        );
        $response = wp_remote_post(PIEEYE_CONF_API . '/site-exists', $args);
        $body = wp_remote_retrieve_body($response);
        $resp_url = json_decode($body);
        return $resp_url->message;
    } else {
        return '#';
    }
}
function pieeye_display_variable_or_zero($my_variable) {
    if (!isset($my_variable)) {
        return 0;
    } else {
        return $my_variable;
    }
}
function pieeye_display_icon($connected){
    if($connected == true){
        return array(
            'pieeye_bool'=>'',
            'pieeye_icon_class'=>'dashicons dashicons-yes-alt'
        );
    } else {
        return array(
            'pieeye_bool'=>'not',
            'pieeye_icon_class'=>'dashicons dashicons-no'
        );
    }
}
function pieeye_statistics(){
    $pieeye_consent = get_option('pieeye_optin_consent', false);
    $body = NULL;
    if($pieeye_consent == "true"){
        $url = get_site_url();
        $body = array(
            'shop' => $url,
        );
        $header = array(
            'Content-Type' => 'application/json',
        );
        $args = array(
            'method'      => 'POST',
            'timeout'     => '105',
            'headers'     => $header,
            'body'        => json_encode($body),
            'cookies'     => array(),
        );
        $response = wp_remote_post(PIEEYE_CONF_API . '/statistics', $args);
        $body = wp_remote_retrieve_body($response);
    }
    $statistics = json_decode($body);
    // Initialize all statistics variable to zero, and assign values only if data is present
    if(isset($statistics->script)){
        if($statistics->script){
            $host = get_site_url();
            set_transient('pieeye_banner_script_inserted_' . $host,  false, 2147483647);
        }
    }
    $pieeye_cookies = 0; $pieeye_impression = 0; $pieeye_consented = 0; $pieeye_rejected = 0;
    if (isset($statistics->cookie->data->count)){
        $pieeye_cookies = pieeye_display_variable_or_zero($statistics->cookie->data->count);
    } 

    if (isset($statistics->banner->count)){
        $pieeye_impression = pieeye_display_variable_or_zero($statistics->banner->count);
    } 

    if (isset($statistics->cookie_consent->categoryDistribution->optin)){
        $pieeye_consented = pieeye_display_variable_or_zero($statistics->cookie_consent->categoryDistribution->optin);
    } 

    if (isset($statistics->cookie_consent->categoryDistribution->optout)){
        $pieeye_rejected = pieeye_display_variable_or_zero($statistics->cookie_consent->categoryDistribution->optout);
    } 
    $domain = json_decode($statistics->domain->data->data);
    $plan = $statistics->plans->data->plan_details;
    $domain_name = trim( str_replace( array( 'http://', 'https://' ), '', get_site_url() ));
    $script = get_transient('pieeye_banner_script_inserted_' . get_site_url());
    $isConnected = esc_html( $domain->isConnected );
    $icon = pieeye_display_icon( $isConnected );
    $redirect_url = pieeye_inject_banner();
    $optin_consent = get_option('pieeye_optin_consent');
    $checked = '';
    $button_class = 'redirect-button-disabled';
    if($optin_consent == "true"){
        $checked = 'checked';
        $button_class = '';
    }
    if(!isset($statistics->messages)){
        echo '<div class="pii-dashboard-body">
        <div class="pii-top-card">
            <div class="pii-top-card-left">
                <h3>User Consent Settings</h3>
                <p class="pii-content-text">Please grant your consent to enable registration and dashboard access.
                Once you have given the consent, the <strong>"Go to PieEye Dashboard"</strong> button will be activated.
                Please note that we are linking your website to our application services to enhance your experience. We utilize your domain name for registration and to provide user consent statistics.
                Upon withdrawing consent, the site will deactivate services and the banner.</p>
                <div class="pii-toggle-button">
                    <span class="pii-content-text">Enable Authorize/Consent Prompt</span>
                    <label class="switch">
                    <input type="checkbox" id="toggle-switch" ' . esc_attr($checked) . '>
                    <span class="slider round"></span>
                    </label>
                    
                </div>
            </div>
            <div class="pii-top-card-right">
                <h3>' . esc_html($domain_name) . ' is ' . esc_html($icon['pieeye_bool']) . ' connected with PieEye <span class="' . esc_attr($icon['pieeye_icon_class']) . '"></span></h3>
                <p class="pii-content-text">You can access all the plugin settings, including Consent and Data Subject Request configurations, customize banners, and unlock additional features such as Cookie Scan and Language Translation on the web app.</p>
                <a href="' . esc_url($redirect_url) . '" target="_blank" id="pieeye_redirect" class="' . esc_attr($button_class) . '">Go to PieEye Dashboard</a>
            </div>
        </div>
        <h2 class="pii-header">Overview</h2>
        
        <div class="pii-statistics-section">
            <div class="pii-statistics">
                <div>
                    <div class="pii-circle-container">
                    <div class="pii-circle">
                        <span class="count"><img src="' . esc_url(plugin_dir_url( __FILE__ )) . '/assets/images/cookie-bite-solid.svg"></span>
                    </div>
                    </div>
                    <div class="pii-text">
                        <span class="pii-content-text stats-count">' . esc_html($pieeye_cookies) . '</span>
                        <span class="pii-content-text"># OF COOKIES</span>
                    </div>
                </div>
            </div>
            <div class="pii-statistics">
                <div>
                    <div class="pii-circle-container">
                    <div class="pii-circle">
                        <span class="count"><img src="' . esc_url(plugin_dir_url( __FILE__ )) . '/assets/images/lightbulb-solid.svg"></span>
                    </div>
                    </div>
                    <div class="pii-text">
                        <span class="pii-content-text stats-count">' . esc_html($pieeye_impression) . '</span>
                        <span class="pii-content-text">IMPRESSIONS</span>
                    </div>
                </div>
            </div>
            <div class="pii-statistics">
                <div>
                    <div class="pii-circle-container">
                    <div class="pii-circle">
                        <span class="count"><img src="' . esc_url(plugin_dir_url( __FILE__ )) . '/assets/images/user-check-solid.svg"></span>
                    </div>
                    </div>
                    <div class="pii-text">
                        <span class="pii-content-text stats-count">' . esc_html($pieeye_consented) . '</span>
                        <span class="pii-content-text">USER CONSENTED</span>
                    </div>
                </div>
            </div>
            <div class="pii-statistics">
                <div>
                    <div class="pii-circle-container">
                    <div class="pii-circle">
                        <span class="count"><img src="' . esc_url(plugin_dir_url( __FILE__ )) . '/assets/images/user-xmark-solid.svg"></span>
                    </div>
                    </div>
                    <div class="pii-text">
                        <span class="pii-content-text stats-count">' . esc_html($pieeye_rejected) . '</span>
                        <span class="pii-content-text">USER REJECTED</span>
                    </div>
                </div>
            </div>
        </div>
        <h2 class="pii-header">Plan Info</h2>
        <div class="pii-information-section">
            <div class="pii-plan-left">';
            if(isset($plan)){
                echo '<p class="pii-content-text">Current Plan: <strong>' . esc_html($plan->planName)  . '  ($ ' . esc_html($plan->priceDetails) . ')</strong></p>
                <ul style="list-style-type: circle" class="pii-plan-ul">
                    <li>
                        <strong>' . esc_html($plan->cookieCompliance) . '</strong>
                        <ul>
                            <li>' . esc_html($plan->domain) . '</li>
                            <li>' . esc_html($plan->scanFreq) . '</li>
                            <li>' . esc_html($plan->geolocation) . '</li>
                            <li>' . esc_html($plan->max_quota_bannerimpression) . '</li>
                            <li>' . esc_html($plan->language) . '</li>
                        </ul>
                    </li>
                    <li>
                        <strong>' . esc_html($plan->dsr) . '</strong>
                        <ul>
                            <li>' . esc_html($plan->datasouce) . '</li>
                            <li>' . esc_html($plan->dsrProcess) . '</li>
                        </ul>
                    </li>
                </ul>';
            } else {
                echo '<p class="pii-content-text">Please register with PieEye to view your plan details. Sign up now!</p>';
            }
            echo '</div>
            <div class="pii-plan-right">
                <h3 class="pii-header">Upgrade your plan</h3>
                <p class="pii-content-text">To upgrade your plan, please reach out to us at <a href="mailto:support@pii.ai">support@pii.ai</a></p>
            </div>
        </div>
    </div>';
    }
}
pieeye_statistics()
?>
    
    