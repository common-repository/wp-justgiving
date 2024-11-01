<?php
/**
 * Plugin Name: WP-JustGiving
 * Plugin URI: http://samcleathero.co.uk/wp-justgiving
 * Description: This plugin allows you to integrate your website with a JustGiving fundraising page. Read the documentation <a href="http://samcleathero.co.uk/wp-justgiving">here</a> to get started.
 * Version: 0.1
 * Author: Sam Cleathero
 * Author URI: http://samcleathero.co.uk
 * License: GPL2
 */

wp_register_style( 'wpjg_bootstrap', plugin_dir_path( __FILE__ ) . '/style.css' );
wp_enqueue_style( 'wpjg_bootstrap' );
 
function wpjg_register_settings() {
  register_setting( 'wpjg_settings', 'wpjg_apikey' );
  register_setting( 'wpjg_settings', 'wpjg_shortpagename' ); 
} 

add_action( 'admin_init', 'wpjg_register_settings' );

function wpjg_options_menu() {
  add_options_page( 'WP-JustGiving Settings', 'WP-JustGiving', 'manage_options', 'wp-justgiving', 'wpjg_options_page' );
}

add_action('admin_menu', 'wpjg_options_menu');

function wpjg_options_page() {
  if ( !current_user_can( 'manage_options' ) )  {
    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
  }
  ?><div class="wrap">
  <h2>WP-JustGiving Settings</h2>
  <form method="post" action="options.php">
  <?php settings_fields( 'wpjg_settings' ); ?>
  <?php do_settings_sections( 'wpjg_settings' ); ?>
  <table class="form-table">
  <tr valign="top">
  <th scope="row">JustGiving API Key</th>
  <td><input type="text" name="wpjg_apikey" value="<?php echo esc_attr( get_option('wpjg_apikey') ); ?>" /></td>
  <td><em>Register for an API key <a href="http://apimanagement.justgiving.com" target="_blank">here</a>.</em></td>
  </tr>
  <tr valign="top">
  <th scope="row">JustGiving Short Page Name</th>
  <td><input type="text" name="wpjg_shortpagename" value="<?php echo esc_attr( get_option('wpjg_shortpagename') ); ?>" /></td>
  <td><em>Can be found in the URL of the JustGiving page. Typically a person's name (eg "John-Smith").</em></td>
  </tr>
  </table>
  <?php submit_button(); ?>
  </form>
  <p>Plugin by <a href="http://samcleathero.co.uk" target="_blank">Sam Cleathero</a>. Powered by the <a href="https://www.justgiving.com/developer" target="_blank">JustGiving API</a>.</p>
  <p>For information on how to use plugin, please read documentation <a href="http://samcleathero.co.uk/wp-justgiving" target="_blank">here</a>.</p>
  </div><?
}

function wpjg_list_donations() {
  $pageNum = isset($_GET['pagenum']) ? $_GET['pagenum'] : '1';
  $previous = intval($pageNum) - 1;
  $next = intval($pageNum) + 1;
  $supportXml = simplexml_load_file("https://api.justgiving.com/".esc_attr( get_option('wpjg_apikey') )."/v1/fundraising/pages/".esc_attr( get_option('wpjg_shortpagename') )."/donations/?pagenum=".$pageNum);
  $totalPages = $supportXml->pagination->totalPages;

  $output = "<div class=\"text-center\"><nav>
    <ul class=\"pagination pagination-lg\">
      <li"; if ($pageNum == 1) { $output .= " class=\"disabled\""; } $output .= ">
        <a href=\""; if ($pageNum == 1 || $pageNum == 2) { $output .= get_permalink(); } else { $output .= "?pagenum=".$previous; } $output .= "\">&laquo;</a>
      </li>";
  for ($count = 1; $count <= $totalPages; $count++) {
    $output .= "<li"; if ($pageNum == $count) { $output .= " class=\"active\""; } $output .= "><a href=\""; if ($count == 1) { $output .= get_permalink(); } else { $output .= "?pagenum=".$count; } $output .= "\">".$count."</a></li>";
  }
    $output .= "<li"; if ($pageNum == $totalPages) { $output .= " class=\"disabled\""; } $output .= ">
      <a href=\""; if ($pageNum == $totalPages) { $output .= "?pagenum=".$pageNum; } else { $output .= "?pagenum=".$next; } $output .= "\">&raquo;</a>
      </li>
    </ul>
  </nav></div>";


  foreach ($supportXml->donations->donation as $donation) { 
    $amountRaw = floatval($donation->amount);
    $amount = number_format($amountRaw, 2, '.', ',');
    $giftAidRaw = floatval($donation->estimatedTaxReclaim);
    $giftAid = number_format($giftAidRaw, 2, '.', ',');
    $date = date("jS F Y", strtotime($donation->donationDate));
    $output .= "<div class=\"row\"><div class=\"col-md-3\">"; if($amount != 0) { $output .= "<h3><strong>£".$amount."</strong></h3>"; if($giftAid != 0) { $output .= "<span style=\"font-size:12px;\">+ £".$giftAid." Gift Aid</span>"; } } $output .= "</div><div class=\"col-md-9\"><blockquote><p>".$donation->message."</p><footer>Donation by <strong>".$donation->donorDisplayName."</strong> on ".$date.".</footer></blockquote></div></div><br /><hr />"; 
  } 

  $output .= "<div class=\"text-center\"><nav>
    <ul class=\"pagination pagination-lg\">
      <li"; if ($pageNum == 1) { $output .= " class=\"disabled\""; } $output .= ">
        <a href=\""; if ($pageNum == 1 || $pageNum == 2) { $output .= get_permalink(); } else { $output .= "?pagenum=".$previous; } $output .= "\">&laquo;</a>
      </li>";
  for ($count = 1; $count <= $totalPages; $count++) {
    $output .= "<li"; if ($pageNum == $count) { $output .= " class=\"active\""; } $output .= "><a href=\""; if ($count == 1) { $output .= get_permalink(); } else { $output .= "?pagenum=".$count; } $output .= "\">".$count."</a></li>";
  }
    $output .= "<li"; if ($pageNum == $totalPages) { $output .= " class=\"disabled\""; } $output .= ">
      <a href=\""; if ($pageNum == $totalPages) { $output .= "?pagenum=".$pageNum; } else { $output .= "?pagenum=".$next; } $output .= "\">&raquo;</a>
      </li>
    </ul>
  </nav></div>";
return $output;
}

add_shortcode( 'wpjg_donations', 'wpjg_list_donations' );

function wpjg_donation_details() {
  $donationId = $_GET['donationId'];
  $donationXml=simplexml_load_file("https://api.justgiving.com/".esc_attr( get_option('wpjg_apikey') )."/v1/donation/".$donationId);
  $donationRef = $donationXml->donationRef;
  $donationDate = date("jS F Y @ g:ia", strtotime($donationXml->donationDate));
  $donationAmountRaw = floatval($donationXml->amount);
  $donationAmount = number_format($donationAmountRaw, 2, '.', ',');
  $donorName = $donationXml->donorDisplayName;
  $donorMessage = $donationXml->message;
  $donationStatus = $donationXml->status;
  $output = "<strong>Donation reference:</strong> D".$donationRef."<br /><strong>Date/time:</strong> ".$donationDate."<br /><strong>Name:</strong> ".$donorName."<br /><strong>Amount:</strong> "; if ($donationAmount == 0.00) { $output .= "Hidden"; } else { $output .= "£".$donationAmount; } $output .= "<br /><strong>Status:</strong> ".$donationStatus; if($donorMessage != "") { $output .= "<br /><br /><br />You also included the following message with your donation:<br /><br /><blockquote><p>".$donorMessage."</p></blockquote>"; }
return $output;
}

add_shortcode( 'wpjg_details', 'wpjg_donation_details' );


?>