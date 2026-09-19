<?php
/*
Plugin Name: Google Translate Widget
Plugin URI: http://seo.uk.net/google-translate-widget/
Description: Let your visitors to see your content in their language using a this simple Google Translate Widget.
Author: Seo UK Team
Version: 1.1.3
Author URI: http://seo.uk.net
*/

function google_translate_control() {

  $options = get_gt_options();

  if ($_POST['wp_gt_Submit']){

    $options['wp_gt_WidgetTitle'] = htmlspecialchars($_POST['wp_gt_WidgetTitle']);
    $options['wp_gt_sctext_wlink'] = htmlspecialchars($_POST['wp_gt_sctext_wlink']);
    update_option("widget_google_translate", $options); 

}
?>
  <p>Do you need help with SEO?. Visit our website <a href="http://seo.uk.net" title="Link will open in a new window" target="_blank">www.seo.uk.net</a> for more information.</p>
  <p><strong>Use options below to translate english labels</strong></p>
  <p>
    <label for="wp_gt_WidgetTitle">Text Title: </label>
    <input type="text" id="wp_gt_WidgetTitle" name="wp_gt_WidgetTitle" value="<?php echo ($options['wp_gt_WidgetTitle'] =="" ? "Translate" : $options['wp_gt_WidgetTitle']); ?>" />
  </p>
 
 <p>
    <label for="wp_gt_sctext_wlink">Please support our plugin by showing a small link under widget.</label><p align="right">Activate it: 
    <input type="checkbox" id="wp_gt_sctext_wlink" name="wp_gt_sctext_wlink" <?php echo ($options['wp_gt_sctext_wlink'] == "on" ? "checked" : "" ); ?> /></p>
  </p>
  
  <p>
    <input type="hidden" id="wp_gt_Submit" name="wp_gt_Submit" value="1" />
  </p>

<?php
}
function gtinst_activate() { 
add_option('installredirect_do_activation_redirect', true); wp_redirect('../wp-admin/widgets.php');
 };


function get_gt_options() {

  $options = get_option("widget_google_translate");
  if (!is_array( $options )) {
    $options = array(
                     'wp_gt_WidgetTitle' => 'Translate',
                     'wp_gt_sctext_wlink' => ''
                    );
  }
  return $options;
}

function get_infos ($sex, $unique, $hit=false) {

  global $wpdb;
  $table_name = $wpdb->prefix . "sc_log";
  $options = get_gt_options();
  $sql = '';
  $stime = time()-$sex;
  $sql = "SELECT COUNT(".($unique ? "DISTINCT IP" : "*").") FROM $table_name where Time > ".$stime;

  if ($hit)
   $sql .= ' AND IS_AHIT = 1 ';

  if ($options['wp_gt_sctext_bots_filter'] > 1)
      $sql .= ' AND IS_BOT <> 1';

  return number_format_i18n($wpdb->get_var($sql));
  }

function viewtranslate() {

  global $wpdb;
  $options = get_gt_options();
  $table_name = $wpdb->prefix . "sc_log";

?>

<div align="center">
<div id="google_translate_element"></div>
<span><script type="text/javascript">
//<![CDATA[
function googleTranslateElementInit() {
  new google.translate.TranslateElement({
    pageLanguage: 'en',
    layout: google.translate.TranslateElement.InlineLayout.SIMPLE
  }, 'google_translate_element');
}
//]]>
</script><script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</script></span></div>

<?php if ($options['wp_gt_sctext_wlink'] == "on") { ?>
<br /><p align="right"><small>Widget by <a href="http://seo.uk.net" target="_blank">seo.uk.net</a></small></p>
<?php } ?>

<?php
}

function widget_google_translate($args) {
  extract($args);

  $options = get_gt_options();

  echo $before_widget;
  echo $before_title.$options["wp_gt_WidgetTitle"];
  echo $after_title;
  viewtranslate();
  echo $after_widget;
}


function is_ahit ($ip) {

   global $wpdb;
   $table_name = $wpdb->prefix . "sc_log";

   $user_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name where ".time()." - Time <= 1000 and IP = '".$ip."'");

   return $user_count == 0;
}

function wp_gt_install_db () {
   global $wpdb;

   $table_name = $wpdb->prefix . "sc_log";
   $gTable = $wpdb->get_var("show tables like '$table_name'");
   $gColumn = $wpdb->get_results("SHOW COLUMNS FROM ".$table_name." LIKE 'IS_BOT'");
   $hColumn = $wpdb->get_results("SHOW COLUMNS FROM ".$table_name." LIKE 'IS_HIT'");

   if($gTable != $table_name) {

      $sql = "CREATE TABLE " . $table_name . " (
           IP VARCHAR( 17 ) NOT NULL ,
           Time INT( 11 ) NOT NULL ,
           IS_BOT BOOLEAN NOT NULL,
           IS_AHIT BOOLEAN NOT NULL,
           PRIMARY KEY ( IP , Time )
           );";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);

   } else {
     if (empty($gColumn)) {  //old table version update

       $sql = "ALTER TABLE ".$table_name." ADD IS_BOT BOOLEAN NOT NULL";
       $wpdb->query($sql);
     }

     if (empty($hColumn)) {  //old table version update

       $sql = "ALTER TABLE ".$table_name." ADD IS_HIT BOOLEAN NOT NULL";
       $wpdb->query($sql);
     }
   }
}

function google_translate_init() {

  wp_gt_install_db ();
  register_sidebar_widget(__('Google Translate'), 'widget_google_translate');
  register_widget_control(__('Google Translate'), 'google_translate_control', 300, 200 );
}

function uninstalltranslate_sc(){

  global $wpdb;
  $table_name = $wpdb->prefix . "sc_log";
  delete_option("widget_google_translate");
  delete_option("wp_gt_WidgetTitle");
  delete_option("wp_gt_sctext_wlink");

  $wpdb->query("DROP TABLE IF EXISTS $table_name");
}

function add_gt_stylesheet() {
            wp_register_style('scStyleSheets', plugins_url('gt-styles.css',__FILE__));
            wp_enqueue_style( 'scStyleSheets');
}

add_action("plugins_loaded", "google_translate_init");
add_action('wp_print_styles', 'add_gt_stylesheet');

register_deactivation_hook( __FILE__, 'uninstalltranslate_sc' );
register_activation_hook( __FILE__,'gtinst_activate');
add_action('admin_init', 'installredirecttranslate_redirect');

function installredirecttranslate_redirect() {
if (get_option('installredirecttranslate_do_activation_redirect', false)) { delete_option('installredirecttranslate_do_activation_redirect'); wp_redirect('../wp-admin/widgets.php');
}
}

?>