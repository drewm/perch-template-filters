<?php
/**
 * Use like:
 * <perch:blog id="commentURL" type="url" filter="find_avatar" avatarsize="64" />
 * 
 * Uses Cloudinary. Define your cloud name with:
 * define('CLOUDINARY_NAME', 'your-name');
 */

class PerchTemplateFilter_find_avatar extends PerchTemplateFilter 
{
    public function filterAfterProcessing($value, $valueIsMarkup = false)
    {

        $size = $this->Tag->avatarsize;
        if (!$size) $size = 48;

        // Twitter
        if (stripos($value, 'twitter.com')) {
		
            if (stripos($value, 'favorited-by')) {

                $action       = 'twitter';
                $fragment     = parse_url($value, PHP_URL_FRAGMENT); 
                $twitter_user = str_replace('favorited-by-', '', $fragment);

            } else {

                $action = 'twitter_name';

                $url          = parse_url($value, PHP_URL_PATH);
                $parts        = explode('/', $url);
                $twitter_user = $parts[1];
            }

        	return 'https://res.cloudinary.com/'.CLOUDINARY_NAME.'/image/'.$action.'/w_'.$size.'/'.trim($twitter_user).'.jpg';
        }

        // Facebook
        if (stripos($value, 'facebook.com')) {

            if (stripos($value, 'liked-by')) {
                $fragment     = parse_url($value, PHP_URL_FRAGMENT); 
                $fb_user = str_replace('liked-by-', '', $fragment);
                return 'https://res.cloudinary.com/'.CLOUDINARY_NAME.'/image/facebook/'.trim($fb_user).'.jpg';
            }
        }

        $email_hash = md5($this->content['commentEmail']);

        return 'https://www.gravatar.com/avatar/'.$email_hash.'?s='.$size.'&amp;d=mm';
    }
}