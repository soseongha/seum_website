<?php
/* vim: set expandtab tabstop=4 shiftwidth=4:
 +--------------------------------------------------------+
 | PHP version 5.x                                        |
 +--------------------------------------------------------+
 | Copyright : Song, Hyo-Jin <shj at xenosi.de>           |
 | Modifier  : Z&Mee <znmee at naver.com>                 |
 +--------------------------------------------------------+
 | License  : GPLv3                                       |
 +--------------------------------------------------------+
 $Id: autolink.inc.php, 2010-01-18. crucify, znmee Exp $
*/
function autolink($html) {
    return preg_replace_callback('~((?:https?|ftps?|ed2k|mmst?)://|//)?((\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}|(?:[a-z\d\-\.]+(?:\.(com|net|org|af|al|dz|as|ad|ao|ai|aq|ag|ar|am|aw|au|at|az|bs|bh|bd|bb|by|be|bz|bj|bm|bt|bo|ba|bw|bv|br|io|vg|bn|bg|bf|bi|kh|cm|ca|cv|ky|cf|td|cl|cn|cx|cc|co|km|cd|cg|ck|cr|ci|cu|cy|cz|dk|dj|dm|do|ec|eg|sv|gq|er|ee|et|fo|fk|fj|fi|fr|gf|pf|tf|ga|gm|ge|de|gh|gi|gr|gl|gd|gp|gu|gt|gn|gw|gy|ht|hm|va|hn|hk|hr|hu|is|in|id|ir|iq|ie|il|it|jm|jp|jo|kz|ke|ki|kp|kr|kw|kg|la|lv|lb|ls|lr|ly|li|lt|lu|mo|mk|mg|mw|my|mv|ml|mt|mh|mq|mr|mu|yt|mx|fm|md|mc|mn|ms|ma|mz|mm|na|nr|np|an|nl|nc|nz|ni|ne|ng|nu|nf|mp|no|om|pk|pw|ps|pa|pg|py|pe|ph|pn|pl|pt|pr|qa|re|ro|ru|rw|sh|kn|lc|pm|vc|ws|sm|st|sa|sn|cs|sc|sl|sg|sk|si|sb|so|za|gs|es|lk|sd|sr|sj|sz|se|ch|sy|tw|tj|tz|th|tl|tg|tk|to|tt|tn|tr|tm|tc|tv|vi|ug|ua|ae|gb|um|us|uy|uz|vu|ve|vn|wf|eh|ye|zm|zw))))(:\d+)?(?:([^/\s\)\x80-\xff])|/[^ \)<>\r\n]*)?)~im', 'autolink_callback', $html);
}
function autolink_callback($matches) {
    if( isset($matches[6]) ) {
        if( $matches[6] != '' ) { return $matches[0]; }
    }
    $link = '';
    if( $matches[1] != '' ) {
        $link .= $matches[1];
    } else {
        $link .= 'http://';
    }
    $link .= $matches[2];
    $url = $link;
    $arr = explode('?',$link);
    if ( isset($arr[1]) ) {
        $ar = explode('&',$arr[1]);
        foreach ( $ar as &$v ) {
            $i = explode('=',$v);
            $v = $i[0];
            if ( isset($i[1]) ) {
                $str = $i[1];
                if ( preg_match('/[\x80-\xff]+/',$str) ) {
                    $v .= '='.urlencode($i[1]);
                } else {
                    $v .= '='.$i[1];
                }
            }
        }
        $arr[1] = implode('&amp;',$ar);
        $url = $arr[0].'?'.$arr[1];
    }
    $urlHtm = htmlspecialchars($matches[0]);
    return '<a href="'.$url.'" title="'.$urlHtm.'" onclick="window.open(this.href); return false;">'.$urlHtm.'</a>';
    }
    ?>