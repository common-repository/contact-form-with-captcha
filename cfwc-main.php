<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly
/*
Plugin Name: Contact Form With Captcha
Plugin URI: http://www.teqlog.com/
Description: Creates a contact form with captcha. For more details you can visit plugin page <a href="http://www.teqlog.com/wordpress-contact-form-with-captcha-plugin.html"><strong>CFWC Plugin home page</strong></a>.
Version: 1.6.8
Date: 29 Aug 2022
Author: Teqlog
Author URI: http://www.teqlog.com/

    Copyright 2022  Teqlog  (email : teknocrat.com@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/


wp_enqueue_style('cfwccss',plugins_url( 'cfwc.css', __FILE__ ),false);


// add the admin options page

add_action('admin_menu', 'cfwc_plugin_admin_add_page');

function cfwc_plugin_admin_add_page() {

	add_options_page(
                       'Contact Form With Captcha Plugin Page', 
                       'Contact Form With Captcha', 
                       'manage_options', 
                       'contact-form-with-captcha', 
                       'cfwc_plugin_options_page'
                      );

}

// display the admin options page
function cfwc_plugin_options_page() {
?>

<div>
	<h2>Contact Form With Captcha Plugin Menu</h2>
	Options relating to the Contact Form With Captcha Plugin Plugin.
	<form action="options.php" method="post">
            <?php settings_fields('cfwc_options_group'); ?>
            <?php do_settings_sections('contact-form-with-captcha'); ?>
	<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
	</form>
</div>

<?php 
}

// add the admin settings and such

add_action('admin_init', 'cfwc_plugin_admin_init');

function cfwc_plugin_admin_init(){

	register_setting( 'cfwc_options_group', 'cfwc_private_key_value', 'cfwc_plugin_options_validate' );
	register_setting( 'cfwc_options_group', 'cfwc_public_key_value',  'cfwc_plugin_options_validate' );
	register_setting( 'cfwc_options_group', 'cfwc_to_value',          'cfwc_plugin_options_validate' );
    register_setting( 'cfwc_options_group', 'cfwc_success_msg_value', 'cfwc_plugin_options_validate' );
    register_setting( 'cfwc_options_group', 'cfwc_failure_msg_value',   'cfwc_plugin_options_validate' );
	register_setting( 'cfwc_options_group', 'cfwc_full_name_value',   'cfwc_plugin_options_validate' );
	register_setting( 'cfwc_options_group', 'cfwc_e_mail_value',      'cfwc_plugin_options_validate' );
	register_setting( 'cfwc_options_group', 'cfwc_subj_value',        'cfwc_plugin_options_validate' );
	register_setting( 'cfwc_options_group', 'cfwc_message_value',     'cfwc_plugin_options_validate' );
	register_setting( 'cfwc_options_group', 'cfwc_button_value',      'cfwc_plugin_options_validate' );
	register_setting( 'cfwc_options_group', 'cfwc_subject_value',     'cfwc_plugin_options_validate' );
	register_setting( 'cfwc_options_group', 'cfwc_subject_prefix_value',     'cfwc_plugin_options_validate' );
	register_setting( 'cfwc_options_group', 'cfwc_subject_suffix_value',     'cfwc_plugin_options_validate' );
    register_setting( 'cfwc_options_group', 'cfwc_credit_value' );
    register_setting( 'cfwc_options_group', 'cfwc_captcha_theme_value' );
    register_setting( 'cfwc_options_group', 'cfwc_form_theme_value' );

	add_settings_section('plugin_main', 'Main Settings', 'cfwc_plugin_section_text', 'contact-form-with-captcha');

	add_settings_field('cfwc_private_key_field_id', 'Specify your private or secret key',  'cfwc_private_key_field_callback', 'contact-form-with-captcha', 'plugin_main');
	add_settings_field('cfwc_public_key_field_id',  'Specify your public or site key',   'cfwc_public_key_field_callback',  'contact-form-with-captcha', 'plugin_main');
	add_settings_field('cfwc_to_field_id',          'Specify your email address','cfwc_to_field_callback',          'contact-form-with-captcha', 'plugin_main');
    add_settings_field('cfwc_success_msg_field_id',   'Specify Success Message (Optional)'   ,'cfwc_success_msg_field_callback',   'contact-form-with-captcha', 'plugin_main');
    add_settings_field('cfwc_failure_msg_field_id',   'Specify Failure Message (Optional)'   ,'cfwc_failure_msg_field_callback',   'contact-form-with-captcha', 'plugin_main');
    add_settings_field('cfwc_full_name_field_id',   'Specify Full Name Label (Optional)'   ,'cfwc_full_name_field_callback',   'contact-form-with-captcha', 'plugin_main');
    add_settings_field('cfwc_e_mail_field_id',      'Specify E-Mail Label (Optional)'      ,'cfwc_e_mail_field_callback',      'contact-form-with-captcha', 'plugin_main');
    add_settings_field('cfwc_subj_field_id',        'Specify Subject Label (Optional)'     ,'cfwc_subj_field_callback',        'contact-form-with-captcha', 'plugin_main');
    add_settings_field('cfwc_message_field_id',     'Specify Message Label (Optional)'     ,'cfwc_message_field_callback',     'contact-form-with-captcha', 'plugin_main');
    add_settings_field('cfwc_button_field_id',      'Specify Button Label (Optional)'      ,'cfwc_button_field_callback',      'contact-form-with-captcha', 'plugin_main');      
    add_settings_field('cfwc_subject_field_id',     'Specify predefined subject for drop down menu (Use : between different options)','cfwc_subject_field_callback', 'contact-form-with-captcha', 'plugin_main');
    add_settings_field('cfwc_subject_prefix_field_id','Specify a subject prefix (Optional)','cfwc_subject_prefix_field_callback', 'contact-form-with-captcha', 'plugin_main');
    add_settings_field('cfwc_subject_suffix_field_id','Specify a subject suffix (Optional)','cfwc_subject_suffix_field_callback', 'contact-form-with-captcha', 'plugin_main');      
    add_settings_field('cfwc_credit_field_id',      'Do not give credit to developer (Please consider <b>NOT</b> checking this box)' ,'cfwc_credit_field_callback', 'contact-form-with-captcha', 'plugin_main');
    add_settings_field('cfwc_captcha_theme_field_id','Pick a reCaptcha theme' ,'cfwc_captcha_theme_field_callback', 'contact-form-with-captcha', 'plugin_main');
    add_settings_field('cfwc_form_theme_field_id',  'Pick a form theme'       ,'cfwc_form_theme_field_callback',    'contact-form-with-captcha', 'plugin_main');


}

function cfwc_plugin_section_text() {

	echo '<p>Specify your captcha key (Get a key from https://www.google.com/recaptcha/admin/create)</p>';

} 

function cfwc_to_field_callback() {

	$options = get_option('cfwc_to_value');
	echo "<input id='cfwc_to_field_id' name='cfwc_to_value[text_string]' size='50' type='text' value='" . esc_attr($options['text_string']) ."' />";

}

function cfwc_private_key_field_callback() {

	$options = get_option('cfwc_private_key_value');
	echo "<input id='cfwc_private_key_field_id' name='cfwc_private_key_value[text_string]' size='50' type='text' value='" . esc_attr($options['text_string']) ."' />";

}

function cfwc_public_key_field_callback()  {

      $options = get_option('cfwc_public_key_value');
      echo "<input id='cfwc_public_key_field_id' name='cfwc_public_key_value[text_string]' size='50' type='text' value='" . esc_attr($options['text_string']) ."' />";
}

function cfwc_subject_field_callback()  {

      $options = get_option('cfwc_subject_value');
      echo "<input id='cfwc_subject_field_id' name='cfwc_subject_value[text_string]' size='100' type='text' value='" . esc_attr($options['text_string']) ."' />";
}

function cfwc_subject_prefix_field_callback()  {

      $options = get_option('cfwc_subject_prefix_value');
      echo "<input id='cfwc_subject_prefix_field_id' name='cfwc_subject_prefix_value[text_string]' size='50' type='text' value='" . esc_attr($options['text_string']) ."' />";
}

function cfwc_subject_suffix_field_callback()  {

      $options = get_option('cfwc_subject_suffix_value');
      echo "<input id='cfwc_subject_suffix_field_id' name='cfwc_subject_suffix_value[text_string]' size='50' type='text' value='" . esc_attr($options['text_string']) ."' />";
}

function cfwc_success_msg_field_callback()  {

      $options = get_option('cfwc_success_msg_value');
      echo "<input id='cfwc_success_msg_field_id' name='cfwc_success_msg_value[text_string]' size='100' type='text' value='" . esc_attr($options['text_string']) ."' />";
}

function cfwc_failure_msg_field_callback()  {

      $options = get_option('cfwc_failure_msg_value');
      echo "<input id='cfwc_failure_msg_field_id' name='cfwc_failure_msg_value[text_string]' size='100' type='text' value='" . esc_attr($options['text_string']) ."' />";
}

function cfwc_full_name_field_callback()  {

      $options = get_option('cfwc_full_name_value');
      echo "<input id='cfwc_full_name_field_id' name='cfwc_full_name_value[text_string]' size='50' type='text' value='" . esc_attr($options['text_string']) ."' />";
}

function cfwc_e_mail_field_callback()  {

      $options = get_option('cfwc_e_mail_value');
      echo "<input id='cfwc_e_mail_field_id' name='cfwc_e_mail_value[text_string]' size='50' type='text' value='" . esc_attr($options['text_string']) ."' />";
}

function cfwc_subj_field_callback()  {

      $options = get_option('cfwc_subj_value');
      echo "<input id='cfwc_subj_field_id' name='cfwc_subj_value[text_string]' size='50' type='text' value='" . esc_attr($options['text_string']) ."' />";
}

function cfwc_message_field_callback()  {

      $options = get_option('cfwc_message_value');
      echo "<input id='cfwc_message_field_id' name='cfwc_message_value[text_string]' size='50' type='text' value='" . esc_attr($options['text_string']) ."' />";
}
function cfwc_button_field_callback()  {

      $options = get_option('cfwc_button_value');
      echo "<input id='cfwc_button_field_id' name='cfwc_button_value[text_string]' size='50' type='text' value='" . esc_attr($options['text_string']) ."' />";
}

function cfwc_credit_field_callback()  {

      $options = get_option('cfwc_credit_value');
      echo "<input id='cfwc_credit_field_id' name='cfwc_credit_value[text_string]' type='checkbox' value='true' " ; if ("true" == esc_attr($options['text_string'])) {echo "checked='checked'"; } echo "/>";
}

function cfwc_captcha_theme_field_callback()  {

      $options = get_option('cfwc_captcha_theme_value');
      echo "<input id='cfwc_captcha_theme_field_id' name='cfwc_captcha_theme_value[text_string]' type='radio' value='red' " ; if ("red" == $options['text_string']) {echo "checked='checked'"; } echo "/>Red<br>";
      echo "<input id='cfwc_captcha_theme_field_id' name='cfwc_captcha_theme_value[text_string]' type='radio' value='white' " ; if ("white" == $options['text_string']) {echo "checked='checked'"; } echo "/>white<br>";
      echo "<input id='cfwc_captcha_theme_field_id' name='cfwc_captcha_theme_value[text_string]' type='radio' value='blackglass' " ; if ("blackglass" == $options['text_string']) {echo "checked='checked'"; } echo "/>Blackglass<br>";
      echo "<input id='cfwc_captcha_theme_field_id' name='cfwc_captcha_theme_value[text_string]' type='radio' value='clean' " ; if ("clean" == $options['text_string']) {echo "checked='checked'"; } echo "/>Clean<br>";

}

function cfwc_form_theme_field_callback()  {

      $options = get_option('cfwc_form_theme_value');
      echo "<input id='cfwc_form_theme_field_id' name='cfwc_form_theme_value[text_string]' type='radio' value='parallel' " ; if ("parallel" == $options['text_string']) {echo "checked='checked'"; } echo "/>Parallel<br>";
      echo "<input id='cfwc_form_theme_field_id' name='cfwc_form_theme_value[text_string]' type='radio' value='stacked' " ; if ("stacked" == $options['text_string']) {echo "checked='checked'"; } echo "/>Stacked<br>";

}



// validate our options
function cfwc_plugin_options_validate($input) {

	$newinput['text_string'] = trim($input['text_string']);
//	if(!preg_match('/^[a-z0-9]{32}$/i', $newinput['text_string'])) {
//		$newinput['text_string'] = '';
//	}
	return $newinput;
}

// [cfwc publickey="abc" privatekey="def"]

add_shortcode( 'cfwc', 'cfwc_func' );
function cfwc_func( $atts ) {
	extract( shortcode_atts( array(
		'publickey' => 'something',
		'privatekey' => 'something else',
	), $atts ) );
      
      
      ob_start(); 
      $privatekey     = get_option('cfwc_private_key_value');
      $publickey      = get_option('cfwc_public_key_value');
      $cfwc_to        = get_option('cfwc_to_value');
      $cfwc_success_msg = get_option('cfwc_success_msg_value');
      $cfwc_failure_msg = get_option('cfwc_failure_msg_value');
      $cfwc_full_name = get_option('cfwc_full_name_value');
      $cfwc_e_mail    = get_option('cfwc_e_mail_value');
      $cfwc_subj      = get_option('cfwc_subj_value');
      $cfwc_message   = get_option('cfwc_message_value');
      $cfwc_button    = get_option('cfwc_button_value');
      $cfwc_subject   = get_option('cfwc_subject_value');
      $cfwc_subject_prefix = get_option('cfwc_subject_prefix_value');
      $cfwc_subject_suffix = get_option('cfwc_subject_suffix_value');
      //$cfwc_credit    = get_option('cfwc_credit_value');
      $cfwc_captcha_theme    = get_option('cfwc_captcha_theme_value');
      $cfwc_form_theme    = get_option('cfwc_form_theme_value');


      $privatekey     = $privatekey['text_string'] ;
      $publickey      = $publickey['text_string'] ;
      $cfwc_to        = $cfwc_to['text_string'];
      $cfwc_success_msg = $cfwc_success_msg['text_string'];
      $cfwc_failure_msg = $cfwc_failure_msg['text_string'];
      $cfwc_full_name = $cfwc_full_name['text_string'];
      $cfwc_e_mail    = $cfwc_e_mail['text_string'];
      $cfwc_subj      = $cfwc_subj['text_string'];
      $cfwc_message   = $cfwc_message['text_string'];
      $cfwc_button    = $cfwc_button['text_string'];
      $cfwc_subject   = $cfwc_subject['text_string'];
      $cfwc_subject_prefix   = $cfwc_subject_prefix['text_string'];
      $cfwc_subject_suffix   = $cfwc_subject_suffix['text_string'];
      //$cfwc_credit    = $cfwc_credit['text_string'];
      $cfwc_captcha_theme   = $cfwc_captcha_theme['text_string'];
      $cfwc_form_theme   = $cfwc_form_theme['text_string'];

require_once __DIR__ . '/recaptcha-master/src/autoload.php';

if (isset($_POST['g-recaptcha-response']))
{
       $recaptcha = new \ReCaptcha\ReCaptcha($privatekey);

       $resp = $recaptcha->verify(sanitize_text_field($_POST['g-recaptcha-response']), sanitize_text_field($_SERVER['REMOTE_ADDR']));

        if ($resp->isSuccess()) {
                
                {  
                    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
                    if (!wp_verify_nonce($token,'token')) 
                      exit;
          
                    //$_POST = str_replace("\\","",$_POST);//
      
                    // --- CONFIG PARAMETERS --- //
                    $email_recipient    = $cfwc_to;
                    $email_sender       = sanitize_text_field($_POST["contact_name"]);
                    $email_return_to    = sanitize_email($_POST["contact_email"]);
                    $email_content_type = "text/html; charset=UTF-8";
                    $email_client       = "PHP/" . phpversion();

                    // --- SUBJECT --- //
                    $email_subject = $cfwc_subject_prefix . ' ' . sanitize_text_field($_POST["contact_subject"]) . ' ' . $cfwc_subject_suffix ;


                    // --- DEFINE HEADERS --- //
                    $domain = sanitize_text_field($_SERVER['SERVER_NAME']);
                    if (substr($domain, 0, 4) == 'www.') {
                        $domain = substr($domain, 4);
                    }

                    $email_header  = "From:         =?UTF-8?B?".base64_encode($email_sender)."?=" . " <do_not_reply@" . $domain . ">" . "\r\n";

                    //$email_header .= "Subject:      =?UTF-8?B?".base64_encode($email_subject)."?=" . "\r\n";

                    $email_header .= "Reply-To:     " . $email_return_to . "\r\n";
                    $email_header .= "Return-Path:  " . $email_return_to . "\r\n";
                    $email_header .= "Content-type: " . $email_content_type . "\r\n";
                    $email_header .= "X-Mailer:     " . $email_client . "\r\n";

                    // --- CONTENTS --- //
                    
                    $email_contents = "<html>";
                    $email_contents .= "<h2>"                                . sanitize_text_field($_POST["contact_subject"]) . "</h2>";
                    $email_contents .= "<br><b>Sender Name:</b>         "    . $email_sender;
                    $email_contents .= "<br><b>Sender Email:</b>         "   . $email_return_to;
                    $email_contents .= '<br><b>Sender IP Address:</b> ' . sanitize_text_field($_SERVER["REMOTE_ADDR"]) . ' <strong>(<a href="http://www.teqlog.com/find-my-ip-address.html">Find location for this IP</a></strong>)';
                    $email_contents .= "<br><br>" . sanitize_text_field($_POST["contact_message"]);    
                    $email_contents .= "</html>";
 
                    if (mail($email_recipient, $email_subject, $email_contents, $email_header))
                    {     
                        if ($cfwc_success_msg != null)
                        {
                            echo "<center><h2>" . esc_html($cfwc_success_msg) . "</h2></center>";
                        }
                        else
                        {
                            echo "<center><h2>Thank you for contacting us!</h2></center>";
                        }
                    }       
                    else 
                    {     
                        if ($cfwc_failure_msg != null)
                        {
                            echo "<center><h2>" . esc_html($cfwc_failure_msg) . "</h2></center>";
                        }
                        else
                        {
                            echo "<center><h2>Can't send email to Administrator. Please try later</h2></center>";
                        }      
                    } 
                }
        } 
        else 
        {?>



<h2>Something went wrong</h2>
        <p>The following error was returned: <?php
            foreach ($resp->getErrorCodes() as $code) {
                echo '<tt>' . esc_html($code) , '</tt> ';
            }
            ?></p>
        <p>Check the error code reference at <tt><a href="https://developers.google.com/recaptcha/docs/verify#error-code-reference">https://developers.google.com/recaptcha/docs/verify#error-code-reference</a></tt>.
        <p><strong>Note:</strong> Error code <tt>missing-input-response</tt> may mean the user just didn't complete the reCAPTCHA.</p>

            
        <?php
           echo "<center><h2>Incorrect Captcha!</h2></center>";
        
        }
}



?>

<script language="JavaScript" type="text/javascript">

function focuson() { document.cfwc_contactform.number.focus()}

function check(){
var str1 = document.getElementById("contact_email").value;
var filter=/^(.+)@(.+).(.+)$/i
if (!( filter.test( str1 ))){alert("Incorrect email address!");return false;}
if(document.getElementById("recaptcha_response_field").value=="")
   {
       alert("Please enter captcha");
       return false;
   }
}
</script>

<script type="text/javascript">
 var RecaptchaOptions = {
    theme : '<?php echo esc_html($cfwc_captcha_theme); ?>'
 };
</script>




<div id="cfwc_contactform">
<!-- Contact form with Captcha - For more details visit http://www.teqlog.com/wordpress-contact-form-with-captcha-plugin.html -->
<form action="" method="POST" name="ContactForm" onsubmit="return check();">

<table>
       <tbody>
         <tr>
             <td>
             <input type="hidden" name="token" value="<?php echo wp_create_nonce('token'); ?>"/>
             <?php 
                 if ($cfwc_full_name != null)
                 {
                     echo esc_html($cfwc_full_name) ;
                 }
                 else
                 {
                     echo "Full Name:"; 
                 }
             ?>
             <?php if ($cfwc_form_theme == "stacked") {echo "<br>";} else {echo "</td><td>";} ?>
             <input name="contact_name" type="text" value="<?php if(isset($_POST['contact_name']) && !$resp->is_valid ) echo esc_attr($_POST['contact_name']); ?>"/>
             </td>
         </tr>
         <tr/><tr/><tr/><tr/>
         <tr>
             <td>
             <?php 
                 if ($cfwc_e_mail != null)
                 {
                     echo esc_html($cfwc_e_mail) ;
                 }
                 else
                 {
                     echo "E Mail:";
                 }
             ?>
             <?php if ($cfwc_form_theme == "stacked") {echo "<br>";} else {echo "</td><td>";} ?>
             <input id="contact_email" name="contact_email" type="text" value="<?php if(isset($_POST['contact_email']) && !$resp->is_valid ) echo $_POST['contact_email']; ?>"/></td>
         </tr>
         <tr/><tr/><tr/><tr/>
         <tr>
             <td>
             <?php 
                 if ($cfwc_subj != null)
                 {
                     echo esc_html($cfwc_subj) ;
                 }
                 else
                 {
                     echo "Subject:"; 
                 }
             ?>
             <?php if ($cfwc_form_theme == "stacked") {echo "<br>";} else {echo "</td><td>";} ?>
             <?php
                 if ($cfwc_subject == null)
                 {
                     echo '<input name="contact_subject" class="cfwc_inputdata" type="text" value="'; if(isset($_POST['contact_subject']) && !$resp->is_valid ) echo  esc_attr($_POST['contact_subject']); echo '"/>';
                 }
                 else
                 {
                     $subject_tok = explode(":",$cfwc_subject);
                     echo '<select name="contact_subject">';
                     foreach ($subject_tok as $v) 
                     {
                         echo '<option value="' . esc_html($v) . '">' . esc_html($v) . '</option>';
                     }
                     echo '</select>';
                 }
             ?>
             </td>
         </tr>
         <tr/><tr/><tr/><tr/>
         <tr>
             <td>
             <?php 
                 if ($cfwc_message != null)
                 {
                     echo esc_html($cfwc_message) ;
                 }
                 else
                 {
                     echo "Message:"; 
                 }
             ?>
             <?php if ($cfwc_form_theme == "stacked") {echo "<br>";} else {echo "</td><td>";} ?>
             <textarea name="contact_message" id="contact_message" ><?php if(isset($_POST['contact_message']) && !$resp->is_valid ) echo esc_attr($_POST['contact_message']); ?></textarea></td>
         </tr>
         <tr/><tr/><tr/><tr/>
         <tr>
            <td>
            <?php if ($cfwc_form_theme == "stacked") {echo "<br>";} else {echo "</td><td>";} ?>
         <?php
            if ($publickey != null)
            {?>
                <div class="g-recaptcha" data-sitekey="<?php echo esc_html($publickey); ?>"></div>
            <script type="text/javascript"
                    src="https://www.google.com/recaptcha/api.js?hl=en">
            </script>
            <?php
            }
            else
            {
                echo "To use reCAPTCHA you must get an API key from <a href='https://www.google.com/recaptcha/admin/create'>https://www.google.com/recaptcha/admin/create</a> and enter it from the plugin menu";
            }
         ?>
            </td>
         </tr>
         <tr/><tr/><tr/><tr/>
         <tr>
            <td>
             <?php if ($cfwc_form_theme == "stacked") {echo "<br>";} else {echo "</td><td>";} ?>
             <input name="Contact_Send" value="<?php if ($cfwc_button != null){ echo esc_html($cfwc_button) ; } else { echo "Send Message";} ?> " type="submit">            
             <input name="SendMessage"  value="1" type="hidden">
            </td>
         </tr>
         <tr>
            <td>
             <?php 
              /*if ($cfwc_credit != "true")
              echo '<p class="credit">Powered by <a href="http://www.teqlog.com">Technology blog</a></p>';
              else
              {
                  echo '<div id="cimg"><a title="Technology Blog" href="http://www.teqlog.com/"><img src="' ; echo plugin_dir_url(__DIR__); echo '/1.gif" alt="Technology Blog" /></a></div>';
              }*/
            ?>
            </td>
         </tr>
     </tbody>
</table>

</form>
<!-- Contact form with Captcha - For more details visit http://www.teqlog.com/wordpress-contact-form-with-captcha-plugin.html -->
</div>



<?
    
      $output_string=ob_get_contents();
      ob_end_clean();

      return $output_string;
}
?>


