<?php
/*
Plugin Name: Simple Social Share Buttons
Description: Simple Social Share Buttons - Facebook Like, Twitter, Google +, Buffer, LinkedIn, StumbleUpon, Pinterest Share Buttons after post contents.
Version: 1.0.1
Author: promag
Author URI: http://freebloggingtricks.com/
*/
/**
 * This file is part of facebook-twitter-googleplus-linkedin-buffer-share-buttons.
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with facebook-twitter-googleplus-linkedin-buffer-share-buttons.  If not, see <http://www.gnu.org/licenses/>.
 */
        /*
        Contents:
        1.Head js: Pinterest,Google + 
        2.Footer js: Twitter,Linkedin
        3.Get the Image for Pinterest
        4.Display the Social Share Buttons and Print Button
        */

##### 1. Head js: Pinterest,Google +#####################

function FTGSB_head() {
if (is_single()) { ?> 
<script type="text/javascript">
(function() {
    window.PinIt = window.PinIt || { loaded:false };
    if (window.PinIt.loaded) return;
    window.PinIt.loaded = true;
    function async_load(){
        var s = document.createElement("script");
        s.type = "text/javascript";
        s.async = true;
        if (window.location.protocol == "https:")
            s.src = "https://assets.pinterest.com/js/pinit.js";
        else
            s.src = "http://assets.pinterest.com/js/pinit.js";
        var x = document.getElementsByTagName("script")[0];
        x.parentNode.insertBefore(s, x);
    }
    if (window.attachEvent)
        window.attachEvent("onload", async_load);
    else
        window.addEventListener("load", async_load, false);
})();
</script>
<script type="text/javascript">
(function() {
var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
po.src = 'https://apis.google.com/js/plusone.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
</script>
<?php }
 }
add_action('wp_head', 'FTGSB_head',20);

############2.Footer js: Twitter,linkedin Share#################
function FTGSB_footer() {
    if (is_single()) { ?> 
        <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
        <script src="http://platform.linkedin.com/in.js" type="text/javascript"></script>
    <?php }
 }
add_action('wp_footer', 'FTGSB_footer');


###############3.Get the Image for Pinterest#####################

function pinterest_image() {
  global $post, $posts;
  //if you set p-img custom field, then set it as pinterest_image
  $pinterest_image = get_post_meta($post->ID, 'p-img', true);  
  
  //if not,get the first image in the post as pinterest_image
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches [1] [0];

  //return pinterest_image URL
  if(empty($pinterest_image)){    
    $pinterest_image = $first_img;
  }
  return $pinterest_image;
}


###############4.Display the Social Share Buttons################

add_filter ('the_content', 'FTGSB');
function FTGSB($content) {
if(is_single()) {
global $post, $posts;
$content.= '
<style>#socialbuttonnav li{list-style:none;overflow:hidden;margin:1 auto;background:none;overflow:hidden;width:92px; height:25px; line-height:10px; margin-right:1px; padding: 20px 0px 0px 0px; float:left; text-align:center;}</style>
<ul id="socialbuttonnav">
<li><!-- Facebook like--><iframe src="//www.facebook.com/plugins/like.php?href='.urlencode(get_permalink($post->ID)).
'&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=220231561331594" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe></li>
</ul>';
}
return $content;
}