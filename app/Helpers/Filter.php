<?php

namespace App\Helpers;

class Filter
{
    public static function parse_string($str)
    {
        return addslashes(strip_tags($str));
    }

    public static function trim_str($str)
    {
        return preg_replace('/\s+/', ' ', $str);
    }

    public static function parse_int($str)
    {
        return intval($str);
    }

    public static function addslashes($str)
    {
        return addslashes($str);
    }

    public static function parse_numeric($str)
    {
        return preg_replace("([[:punct:]]|[[:alpha:]]| )", '', $str);
    }

    public static function parse_email($str)
    {
        return preg_match("/^[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\-]+\.[a-z]{2,4}$/", $str);
    }

    public static function parse_link($url)
    {
        $regex = array('/http|https\:\/\//', '/www./', '/\:\/\//');
        $link = preg_replace($regex, array('', '', ''), $url);
        return ($link != "") ? "http://" . $link : $link;
    }

    public static function parse_cpf($str)
    {
        return preg_match("preg_match('/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}-[0-9]{2}$/'", $str);
    }

    public static function parse_cnpj($str)
    {
        return preg_match("#^[0-9]{2}\.[0-9]{3}\.[0-9]{3}/[0-9]{4}-[0-9]{2}$#", $str);
    }

    public static function antiSQL($str, $strip = null)
    {
        if ($strip != null) {
            return strip_tags(addslashes($str));
        } else {
            return addslashes($str);
        }
    }

    public static function parse_to_date($str, $f = 'd/m/Y H:i')
    {
        $str = date($f, strtotime($str));
        return $str;
    }

    public static function parse_date($str)
    {
        $str = preg_replace('/\//', '-', $str);
        $str = date('Y-m-d', strtotime($str));
        return $str;
    }

    public static function decode_utf8($key, $data)
    {
        foreach ($data as $k => $v) {
            $data[$k][$key] = utf8_decode($data[$k][$key]);
        }
        return $data;
    }

    public static function pre($data)
    {
        echo "<pre>", @print_r($data, true), "</pre>";
    }

    public static function moedaArr($key, $data)
    {
        foreach ($data as $k => $v) {
            $data[$k][$key] = number_format($data[$k][$key], 2, ',', '.');
        }
        return $data;
    }

    public static function moeda($valor, $moeda = 'brl', $mostrar_zero = false)
    {
        if ($moeda == 'brl') {
            return floatval($valor) ? number_format(floatval($valor), 2, ',', '.') : ($mostrar_zero ? '0,00' : '');
        } else {
            return floatval($valor) ? number_format(floatval($valor), 2, '.', ',') : ($mostrar_zero ? '0,00' : '');
        }
    }

    public static function caracteresEsquerda($string, $num)
    {
        return substr($string, 0, $num);
    }

    public static function caracteresDireita($string, $num)
    {
        return substr($string, strlen($string) - $num, $num);
    }

    public static function memoryHuman($size)
    {
        $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }

    public static function slug($string)
    {
        $string = self::troca_acentos($string);
        $group_a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç',
            'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð',
            'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú',
            'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä',
            'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í',
            'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø',
            'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'A', 'a', 'A',
            'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c',
            'C', 'c', 'D', 'd', 'Ð', 'd', 'E', 'e', 'E',
            'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g',
            'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H',
            'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i',
            'I', 'i', '?', '?', 'J', 'j', 'K', 'k', 'L',
            'l', 'L', 'l', 'L', 'l', '?', '?', 'L', 'l',
            'N', 'n', 'N', 'n', 'N', 'n', '?', 'O', 'o',
            'O', 'o', 'O', 'o', '?', '?', 'R', 'r', 'R',
            'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's',
            '?', '?', 'T', 't', 'T', 't', 'T', 't', 'U',
            'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u',
            'U', 'u', 'W', 'w', 'Y', 'y', '?', 'Z', 'z',
            'Z', 'z', '?', '?', '?', '?', 'O', 'o', 'U',
            'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u',
            'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', '?',
            '?', '?', '?', '?', '?', 'ç');

        $group_b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C',
            'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D',
            'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U',
            'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a',
            'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i',
            'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o',
            'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A',
            'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c',
            'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E',
            'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g',
            'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H',
            'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i',
            'I', 'i', '', '', 'J', 'j', 'K', 'k', 'L',
            'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l',
            'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o',
            'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R',
            'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's',
            'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U',
            'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u',
            'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z',
            'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U',
            'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u',
            'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A',
            'a', 'AE', 'ae', 'O', 'o', 'c');
        $string = strtolower(str_replace($group_a, $group_b, utf8_decode($string)));
        $pattern = array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/');
        $replace = array(' ', '-', '');
        return preg_replace($pattern, $replace, $string);
    }

    public static function troca_acentos($str = '')
    {
        return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(ç)/", "/( Ç)/"),
            explode(" ", "a A e E i I o O u U n N c C"), $str);
    }

    public static function cut($str, $chars, $info)
    {
        try {
            $str = strip_tags($str);
            if (strlen($str) >= $chars) {
                $str = preg_replace('/\s\s+/', ' ', $str);
                $str = preg_replace('/\s\s+/', ' ', $str);
                $str = substr($str, 0, $chars);
                $str = preg_replace('/\s\s+/', ' ', $str);
                $arr = explode(' ', $str);
                array_pop($arr);
                $final = implode(' ', $arr) . $info;
            } else {
                $final = $str;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit;
        }
        return $final;
    }

    public static function hash($width = 8)
    {
        $chars = 'abcdefghijlmnopqrstuvxwzABCDEFGHIJLMNOPQRSTUVXYWZ0123456789-.^*%#@!';
        $max = strlen($chars) - 1;
        $pass = "";
        for ($i = 0; $i < $width; $i++) {
            $pass .= $chars[mt_rand(0, $max)];
        }
        return $pass;
    }

    public static function getLatLon($address)
    {
        $address = urlencode(utf8_encode($address));
        $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=Brazil";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        $json = json_decode($json);
        if (isset($json->status) && $json->status == "OK") {
            $lat = $json->results[0]->geometry->location->lat;
            $lon = $json->results[0]->geometry->location->lng;
            return (object) array('lat' => $lat, 'lon' => $lon);
        } else {
            return (object) array('lat' => '', 'lon' => '');
        }
    }

    public static function zeroEsquerda($str, $tam)
    {
        return (strlen($str) < $tam) ? "0$str" : $str;
    }
}
