<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class CaptchaController extends Controller {

    /**
     * Return a new captcha code.
     *
     * @return JSON object containing an image in base64 and an expiration time
     */
    public function create()
    {
        ob_start();

        $image_width = 240;
        $image_height = 80;
        $captcha_code = substr(md5(mt_rand()), 0, 7);
        $image = @imagecreatetruecolor($image_width, $image_height)
                or die('Cannot initialize image stream');

        imagesavealpha($image, true);

        $background_color = imagecolorallocatealpha($image, 0, 0, 0, 127);
        $text_color = imagecolorallocate($image, 233, 14, 91);

        imagefill($image, 0, 0, $background_color);

        for ($i = 0; $i < strlen($captcha_code); $i++) 
        {
            $min_x = ($i * ($image_width / strlen($captcha_code))) / $image_width;
            $max_x = $min_x + 30;
            $min_y = ($image_width % strlen($captcha_code)) + 30;
            $max_y = $min_y + 20;

            imagestring($image, 5, mt_rand($min_x, $max_x),
                        mt_rand($min_y, $max_y), $captcha_code[$i], $text_color);
        }

        imagepng($image);
        imagedestroy($image);

        $image_data = ob_get_contents();
        ob_end_clean();

        return base64_encode($image_data);
    }

    /**
     * Validate a captcha response.
     *
     * @return Response
     */
    public function store()
    {
        
    }

}