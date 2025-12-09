<?php
defined('BASEPATH') or exit('');

class functions_model extends CI_Model
{
    public function page_transfer($msg, $page = "home")
    {
        $data['msg'] = $msg;
        $data['url'] = $page;
        $this->load->view("transfer", $data);
    }

    public function strReplaceAssoc(array $replace, $subject)
    {
        return str_replace(array_keys($replace), array_values($replace), $subject);
    }

    public function pagination($base_url, $count, $perpage, $num_link, $query = false)
    {
        $config['base_url'] = $base_url;
        $config['total_rows'] = $count;
        $config['per_page'] = $perpage;
        if ($query == true) {
            $config['first_url'] = '0' . $this->config->item('url_suffix') . '?' . $_SERVER['QUERY_STRING'];
        } else {
            $config['first_url'] = '0' . $this->config->item('url_suffix');
        }

        $config['next_tag_open'] = '<li class="paginate_button page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="paginate_button page-item">';
        $config['first_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="paginate_button page-item">';
        $config['first_link'] = '&lsaquo;&lsaquo; Đầu';
        $config['last_link'] = 'Cuối &rsaquo;&rsaquo;';
        $config['last_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="paginate_button page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] =  '<li class="paginate_button page-item">';
        $config['num_tag_close'] =  '</li>';
        $config['num_links']    =  $num_link;
        $config['cur_tag_open'] =  '<li class="paginate_button page-item active"><a href="#" aria-controls="datatable" class="page-link">';
        $config['cur_tag_close'] =  '</a></li>';
        $config['attributes'] = array('class' => 'page-link', 'aria-controls' => 'datatable');
        $config['uri_segment']     =  3;
        $config['reuse_query_string'] = true;
        $config['suffix'] = $this->config->item('url_suffix');

        return $config;
    }
    public function non_signed($str)
    {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", "a", $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", "e", $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", "i", $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", "o", $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", "u", $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", "y", $str);
        $str = preg_replace("/(đ)/", "d", $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "A", $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", "E", $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", "I", $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "O", $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", "U", $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", "Y", $str);
        $str = preg_replace("/(Đ)/", "D", $str);
        //$str = str_replace(" ", "-", str_replace("&*#39;","",$str));
        return $str;
    }
    public function dbDateTime($strDateTime)
    {
        if ($strDateTime == '' || empty($strDateTime) || (strpos($strDateTime, '/')  === false && strpos($strDateTime, '-')  === false)) return '';
        $dts = explode(' ', $strDateTime);
        $date = date('Y-m-d', strtotime(implode('-', array_reverse(explode('/', $dts[0])))));
        $datetime = isset($dts[1]) ? date('Y-m-d H:i:s', strtotime($date . $dts[1])) : date('Y-m-d H:i:s', strtotime($date . ' 00:00:00'));
        return $datetime;
    }
    public function clientDateTime($strDateTime, $separator = '-')
    {
        if ($strDateTime == '' || empty($strDateTime) || (strpos($strDateTime, '/')  === false && strpos($strDateTime, '-')  === false)) return '';
        $dts = explode(' ', $strDateTime);
        $date = date('d-m-Y', strtotime(implode('-', array_reverse(explode('-', $dts[0])))));
        $datetime = isset($dts[1]) ? date('d' . $separator . 'm' . $separator . 'Y H:i:s', strtotime($date . $dts[1]))
            : date('d' . $separator . 'm' . $separator . 'Y H:i:s', strtotime($date . ' 00:00:00'));
        return $datetime;
    }
    public function array_search2d_value($needle, $haystack)
    {
        foreach ($haystack as $k => $v) {
            if (is_array($v) && in_array($needle, $v)) return $v;
        }
        return false;
    }

    public function convert_number_to_words_old($number)
    {
        $hyphen      = ' ';
        $conjunction = '  ';
        $separator   = ' ';
        $negative    = 'âm ';
        $decimal     = ' phẩy ';
        $dictionary  = array(
            0                   => 'không',
            1                   => 'một',
            2                   => 'hai',
            3                   => 'ba',
            4                   => 'bốn',
            5                   => 'năm',
            6                   => 'sáu',
            7                   => 'bảy',
            8                   => 'tám',
            9                   => 'chín',
            10                  => 'mười',
            11                  => 'mười một',
            12                  => 'mười hai',
            13                  => 'mười ba',
            14                  => 'mười bốn',
            15                  => 'mười năm',
            16                  => 'mười sáu',
            17                  => 'mười bảy',
            18                  => 'mười tám',
            19                  => 'mười chín',
            20                  => 'hai mươi',
            30                  => 'ba mươi',
            40                  => 'bốn mươi',
            50                  => 'năm mươi',
            60                  => 'sáu mươi',
            70                  => 'bảy mươi',
            80                  => 'tám mươi',
            90                  => 'chín mươi',
            100                 => 'trăm',
            1000                => 'nghìn',
            1000000             => 'triệu',
            1000000000          => 'tỷ',
            1000000000000       => 'nghìn tỷ',
            1000000000000000    => 'nghìn triệu triệu',
            1000000000000000000 => 'tỷ tỷ'
        );
        if (!is_numeric($number)) {
            return false;
        }
        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }
        if ($number < 0) {
            return $negative . convert_number_to_words(abs($number));
        }
        $string = $fraction = null;
        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }
        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $this->convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $this->convert_number_to_words($remainder);
                }
                break;
        }
        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }
        return $string;
    }

    public function convert_number_to_words1($sotien = 0, $currency = 'VND')
    {
        $sotienv = $sotien;
        $decimal = " phẩy ";
        $Text = array("không", "một", "hai", "ba", "bốn", "năm", "sáu", "bảy", "tám", "chín");
        $TextLuythua = array("", "nghìn", "triệu", "tỷ", "ngàn tỷ", "triệu tỷ", "tỷ tỷ");
        if ($sotien <= 0) {
            return $textnumber = "Tiền phải là số nguyên dương lớn hơn số 0";
        }
        $textnumber = "";
        $fraction = null;
        if (strpos($sotien, '.') !== false) {
            list($sotien, $fraction) = explode('.', $sotien);
        }

        $length = strlen($sotien);
        for ($i = 0; $i < $length; $i++)
            $unread[$i] = 0;
        for ($i = 0; $i < $length; $i++) {
            $so = substr($sotien, $length - $i - 1, 1);
            if (($so == 0) && ($i % 3 == 0) && ($unread[$i] == 0)) {
                for ($j = $i + 1; $j < $length; $j++) {
                    $so1 = substr($sotien, $length - $j - 1, 1);
                    if ($so1 != 0)
                        break;
                }
                if (intval(($j - $i) / 3) > 0) {
                    for ($k = $i; $k < intval(($j - $i) / 3) * 3 + $i; $k++)
                        $unread[$k] = 1;
                }
            }
        }
        for ($i = 0; $i < $length; $i++) {
            $so = substr($sotien, $length - $i - 1, 1);
            if ($unread[$i] == 1)
                continue;

            if (($i % 3 == 0) && ($i > 0))
                $textnumber = $TextLuythua[$i / 3] . " " . $textnumber;

            if ($i % 3 == 2)
                $textnumber = 'trăm ' . $textnumber;

            if ($i % 3 == 1)
                $textnumber = 'mươi ' . $textnumber;
            $textnumber = $Text[$so] . " " . $textnumber;
        }
        $textnumber = str_replace("không mươi", "lẻ", $textnumber);
        $textnumber = str_replace("lẻ không", "", $textnumber);
        $textnumber = str_replace("mươi không", "mươi", $textnumber);
        $textnumber = str_replace("một mươi", "mười", $textnumber);
        $textnumber = str_replace("mươi năm", "mươi lăm", $textnumber);
        $textnumber = str_replace("mươi một", "mươi mốt", $textnumber);
        $textnumber = str_replace("mười năm", "mười lăm", $textnumber);

        if (null !== $fraction && is_numeric($fraction) && (float)$fraction > 0) {
            switch ($currency) {
                case "USD":
                    $fraction = substr($fraction . "000000", 0, 2);
                    $textnumber .= ' đô-la Mỹ và ' . $this->convert_number_to_words($fraction) . ' cent.';
                    break;
                case "VND":
                    $textnumber .= ' đồng và ' . $this->convert_number_to_words($fraction) . ' hào.';
                    break;
                default:
                    $textnumber .= $decimal;
                    $words = array();
                    foreach (str_split((string) $fraction) as $number) {
                        $words[] = $Text[$number];
                    }
                    $textnumber .= implode(' ', $words);
                    break;
            }
        } else {
            switch ($currency) {
                case "USD":
                    $textnumber .= ' đô-La Mỹ';
                    break;
                case "VND":
                    $textnumber .= ' đồng';
                    break;
            }
        }

        if ($currency == 'USD') {
            $textnumber .= " (" . $this->convert_number_to_words_en($sotienv, $currency) . ")";
        }

        return ucfirst($textnumber);
    }

    public function convert_number_to_words($sotien = 0, $currency = 'VND')
    {
        $newSoTien = $sotien;
        $prefixReduce_vn = "";
        $prefixReduce_en = "";
        if ($sotien < 0) {
            $newSoTien = abs($sotien);
            $prefixReduce_vn = "Giảm ";
            $prefixReduce_en = " off";
        }

        $textnumber = $prefixReduce_vn . ucfirst($this->convert_number_to_words_vi($newSoTien, $currency));
        if ($currency == 'USD') {
            $textnumber .= " (" . ucfirst($this->convert_number_to_words_en($newSoTien, $currency)) . $prefixReduce_en . ")";
        }

        return preg_replace('/\s+/',' ', $textnumber);
    }

    public function convert_number_to_words_vi($sotien = 0, $currency = '')
    {
        $decimal = " phẩy ";
        $Text = array("không", "một", "hai", "ba", "bốn", "năm", "sáu", "bảy", "tám", "chín");
        $TextLuythua = array("", "nghìn", "triệu", "tỷ", "ngàn tỷ", "triệu tỷ", "tỷ tỷ");
        if ($sotien <= 0) {
            return $textnumber = "Tiền phải là số nguyên dương lớn hơn số 0";
        }
        $textnumber = "";
        $fraction = null;
        if (strpos($sotien, '.') !== false) {
            list($sotien, $fraction) = explode('.', $sotien);
        }

        $length = strlen($sotien);
        for ($i = 0; $i < $length; $i++)
            $unread[$i] = 0;
        for ($i = 0; $i < $length; $i++) {
            $so = substr($sotien, $length - $i - 1, 1);
            if (($so == 0) && ($i % 3 == 0) && ($unread[$i] == 0)) {
                for ($j = $i + 1; $j < $length; $j++) {
                    $so1 = substr($sotien, $length - $j - 1, 1);
                    if ($so1 != 0)
                        break;
                }
                if (intval(($j - $i) / 3) > 0) {
                    for ($k = $i; $k < intval(($j - $i) / 3) * 3 + $i; $k++)
                        $unread[$k] = 1;
                }
            }
        }
        for ($i = 0; $i < $length; $i++) {
            $so = substr($sotien, $length - $i - 1, 1);
            if ($unread[$i] == 1)
                continue;

            if (($i % 3 == 0) && ($i > 0))
                $textnumber = $TextLuythua[$i / 3] . " " . $textnumber;

            if ($i % 3 == 2)
                $textnumber = 'trăm ' . $textnumber;

            if ($i % 3 == 1)
                $textnumber = 'mươi ' . $textnumber;
            $textnumber = $Text[$so] . " " . $textnumber;
        }
        $textnumber = str_replace("không mươi", "lẻ", $textnumber);
        $textnumber = str_replace("lẻ không", "", $textnumber);
        $textnumber = str_replace("mươi không", "mươi", $textnumber);
        $textnumber = str_replace("một mươi", "mười", $textnumber);
        $textnumber = str_replace("mươi năm", "mươi lăm", $textnumber);
        $textnumber = str_replace("mươi một", "mươi mốt", $textnumber);
        $textnumber = str_replace("mười năm", "mười lăm", $textnumber);

        if (null !== $fraction && is_numeric($fraction) && (float)$fraction > 0) {
            switch ($currency) {
                case "USD":
                    $fraction = substr($fraction . "000000", 0, 2);
                    $textnumber .= ' Đô-La Mỹ và ' . $this->convert_number_to_words_vi($fraction) . ' cent.';
                    break;
                case "VND":
                    $textnumber .= ' đồng và ' . $this->convert_number_to_words_vi($fraction) . ' hào.';
                    break;
                default:
                    $textnumber .= $decimal;
                    $words = array();
                    foreach (str_split((string) $fraction) as $number) {
                        $words[] = $Text[$number];
                    }
                    $textnumber .= implode(' ', $words);
                    break;
            }
        } else {
            switch ($currency) {
                case "USD":
                    $textnumber .= ' Đô-La Mỹ';
                    break;
                case "VND":
                    $textnumber .= ' đồng';
                    break;
            }
        }

        return $textnumber;
    }

    public function convert_number_to_words_en($sotien = 0, $currency = '')
    {
        $decimal = " point ";
        $Text  = array(
            0 => "zero",
            1 => "one",
            2 => "two",
            3 => "three",
            4 => "four",
            5 => "five",
            6 => "six",
            7 => "seven",
            8 => "eight",
            9 => "nine",
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'forty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety'
        );
        $TextLuythua = array("", "thousand", "million", "billion", "trillion", "quadrillion", "quintillion");
        if ($sotien <= 0) {
            return $textnumber = "Money must be greater than 0";
        }
        $textnumber = "";
        $fraction = null;
        if (strpos($sotien, '.') !== false) {
            list($sotien, $fraction) = explode('.', $sotien);
        }

        $length = strlen($sotien);
        for ($i = 0; $i < $length; $i++)
            $unread[$i] = 0;
        for ($i = 0; $i < $length; $i++) {
            $so = substr($sotien, $length - $i - 1, 1);
            if (($so == 0) && ($i % 3 == 0) && ($unread[$i] == 0)) {
                for ($j = $i + 1; $j < $length; $j++) {
                    $so1 = substr($sotien, $length - $j - 1, 1);
                    if ($so1 != 0)
                        break;
                }
                if (intval(($j - $i) / 3) > 0) {
                    for ($k = $i; $k < intval(($j - $i) / 3) * 3 + $i; $k++)
                        $unread[$k] = 1;
                }
            }
        }
        for ($i = 0; $i < $length; $i++) {
            $so = substr($sotien, $length - $i - 1, 1);
            if ($unread[$i] == 1)
                continue;

            if (($i % 3 == 0) && ($i > 0))
                $textnumber = $TextLuythua[$i / 3] . " " . $textnumber;

            if ($i % 3 == 2)
                $textnumber = 'hundred ' . $textnumber;

            if ($i == 1 && $so == 1) {
                $sox = substr($sotien, -2);
                $textnumber = $Text[($sox)];
                continue;
            }

            if ($i % 3 == 1) {
                $textnumber = ($so > 0 ? $Text[($so * 10)] : "") . "-" . $textnumber;
                continue;
            }

            $textnumber = $Text[$so] . " " . $textnumber;
        }

        $textnumber = str_replace("zero-", "", $textnumber);
        $textnumber = str_replace("and zero", "", $textnumber);
        $textnumber = str_replace("-zero", "", $textnumber);

        if (null !== $fraction && is_numeric($fraction) && (float)$fraction > 0) {
            switch ($currency) {
                case "USD":
                    $fraction = substr($fraction . "000000", 0, 2);
                    $textnumber .= ' U.S. Dollars and ' . $this->convert_number_to_words_en($fraction) . ' Cents.';
                    break;
                case "VND":
                    $textnumber .= ' dong and ' . $this->convert_number_to_words_en($fraction) . ' hao.';
                    break;
                default:
                    $textnumber .= $decimal;
                    $words = array();
                    foreach (str_split((string) $fraction) as $number) {
                        $words[] = $Text[$number];
                    }
                    $textnumber .= implode(' ', $words);
                    break;
            }
        } else {
            switch ($currency) {
                case "USD":
                    $textnumber .= ' U.S. Dollars.';
                    break;
                case "VND":
                    $textnumber .= ' dong.';
                    break;
            }
        }

        return $textnumber;
    }

    public function newGuid()
    {
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public function generateQRCode($code)
    {
        require_once(APPPATH . 'third_party/phpqrcode/qrlib.php');

        $pngAbsoluteFilePath = sprintf("%s/assets/img/qrcode_gen/%s.png", FCPATH, $code);

        if (!file_exists($pngAbsoluteFilePath)) {
            $qrCode = new QRcode();
            $pngCode = $qrCode->png($code, $pngAbsoluteFilePath, QR_ECLEVEL_L, 4);
        }

        return;
    }
}
