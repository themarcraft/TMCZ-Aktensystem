<?php
namespace de\themarcraft\utils;

use de\themarcraft\ad\AdManager;
use de\themarcraft\cookies\AllowedCookies;
use de\themarcraft\cookies\CookieManager;
/**
 * TMCZ Utils
 * Different Methods for more efficient coding
 * @author Marvin Niermann <marvin@niermanns.net>
 * @version 22.11.2024
 * @copyright 2024 themarcraft.de
 */
class Utils
{

    /**
     * Remove every HTML or PHP Tag from a string to get plain text
     * @param $string string
     * @return array|string|null
     */
    public static function removeTags(string $string): array|string|null
    {

        //$string = str_ireplace("<br>", "[tmczln]", $string);

        $pattern = '/<[^>]*>/';

        $new_string = preg_replace($pattern, '', $string);

        $pattern2 = '/<?[^>]*?>/';

        $new_string2 = preg_replace($pattern2, '', $new_string);

        $pattern2 = '/<script[^>]*>.*?<\/script>/is';

        $new_string3 = preg_replace($pattern2, '', $new_string2);

        //$new_string = str_ireplace("[tmczln]", "<br>", $new_string);

        return $new_string3;
    }

    public static function getRandomString(int $length): string
    {
        $pattern = "abcefghijkmoABCDEFGHJKLMNPQRSTUVWY1234578";

        $rs = str_shuffle($pattern);
        return substr($rs, 0, $length);
    }

    public static function convertBB(string $string): string
    {
        $cm = new CookieManager(false, false);
        $string = str_replace("<", "&lt;", $string);
        $string = str_replace(">", "&gt;", $string);
        $string = str_replace("\n", "<br>", $string);

        $ad = new AdManager();
        $string = str_replace("<br>[AD]", $ad, $string);
        $ad1 = new AdManager();
        $string = str_replace("[AD]", $ad1, $string);
        $ad2 = new AdManager();
        $string = str_replace("<br>[AD2]", $ad2, $string);
        $ad3 = new AdManager();
        $string = str_replace("<br>[AD3]", $ad3, $string);

        $string = str_replace("[B]", "<b>", $string);
        $string = str_replace("[/B]", "</b>", $string);

        $string = str_replace("[I]", "<i>", $string);
        $string = str_replace("[/I]", "</i>", $string);

        $string = str_replace("[U]", "<u>", $string);
        $string = str_replace("[/U]", "</u>", $string);

        $string = str_replace("[SIZE=1]", "<span style=\"font-size:5px\">", $string);
        $string = str_replace("[SIZE=2]", "<span style=\"font-size:10px\">", $string);
        $string = str_replace("[SIZE=3]", "<span style=\"font-size:15px\">", $string);
        $string = str_replace("[SIZE=4]", "<span style=\"font-size:20px\">", $string);
        $string = str_replace("[SIZE=5]", "<span style=\"font-size:25px\">", $string);
        $string = str_replace("[SIZE=6]", "<span style=\"font-size:30px\">", $string);
        $string = str_replace("[/SIZE]", "</span>", $string);

        $string = str_replace("[CENTER]", "<p style=\"text-align: center;\">", $string);
        $string = str_replace("[/CENTER]", "</p>", $string);

        if ($cm->checkAllowedCookies(AllowedCookies::GOOGLE)){
            $string = str_replace("<br>[MEDIA=youtube]", "<iframe allow=\"accelerometer; encrypted-media; gyroscope\" allowfullscreen=\"\" frameborder=\"0\"
                        src=\"https://www.youtube.com/embed/", $string);
            $string = str_replace("[/MEDIA]", "\" style=\"width: 100%; height: 400px;\" title=\"Neustes Video\"
                        width=\"auto\"></iframe>", $string);
        }

        $string = str_replace("<br>[MEDIA=youtube]", "<span style=\"display: none;\">", $string);
        $string = str_replace("[/MEDIA]", "</span>".file_get_contents("de/themarcraft/cookies/cookiesEmbed.html"), $string);

        $string = str_replace("[URL='", "<a href=\"", $string);
        $string = str_replace("']", "\">", $string);
        $string = str_replace("[/URL]", "</a>", $string);

        $string = str_replace("<br>[code]", "<pre><code style=\"background: gray;display: block;overflow-x: auto;padding: 1em;\">Code</code><code class=\"hljs\">", $string);
        $string = str_replace("<br>[/code]", "</code></pre>", $string);

        $string = str_replace("[IMG]", "<img src='", $string);
        $string = str_replace("[/IMG]", "' style=\"max-width:100%\">", $string);

        $string = str_replace("<br>[LIST]", "<ul>", $string);
        $string = str_replace("[/LIST]", "</ul>", $string);

        $string = str_replace("[*]", "<li>", $string);
        $string = str_replace("[/*]", "</li>", $string);

        //$string = str_replace("]", ">", $string);

        return $string;
    }
}