<?php

use App\Model\AdminSetting;
use App\Model\Category;
use App\Model\CategoryUnlock;
use App\Model\Question;
use App\Model\QuestionOption;
use App\Model\UserAnswer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

function allsetting($a = null)
{
    if ($a == null) {
        $allsettings = AdminSetting::get();
        if ($allsettings) {
            $output = [];
            foreach ($allsettings as $setting) {
                $output[$setting->slug] = $setting->value;
            }
            return $output;
        }
        return false;
    } else {
        $allsettings = AdminSetting::where(['slug' => $a])->first();
        if ($allsettings) {
            $output = $allsettings->value;
            return $output;
        }
        return false;
    }
}
//Random string
function randomString($a)
{
    $x = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $c = strlen($x) - 1;
    $z = '';
    for ($i = 0; $i < $a; $i++) {
        $y = rand(0, $c);
        $z .= substr($x, $y, 1);
    }
    return $z;
}
// random number
function randomNumber($a = 10)
{
    $x = '123456789';
    $c = strlen($x) - 1;
    $z = '';
    for ($i = 0; $i < $a; $i++) {
        $y = rand(0, $c);
        $z .= substr($x, $y, 1);
    }
    return $z;
}
//use array key for validator
function arrKeyOnly($array, $seperator = ',', $exception = [])
{
    $string = '';
    $sep = '';
    foreach ($array as $key => $val) {
        if (in_array($key, $exception) == false) {
            $string .= $sep . $key;
            $sep = $seperator;
        }
    }
    return $string;
}
function uploadimage($img,$path,$user_file_name=null,$width=null,$height=null)
{
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    if (isset($user_file_name) && $user_file_name != "" && file_exists( $path.$user_file_name)) {
        unlink($path.$user_file_name);
    }
    // saving image in target path
    $imgName = uniqid() . '.' . $img->getClientOriginalExtension();
    $imgPath = public_path($path.$imgName);
    // making image
    $makeImg = Image::make($img);
    if($width!=null && $height!=null && is_int($width) && is_int($height))
    {
        // $makeImg->resize($width, $height);
        $makeImg->fit($width, $height);
    }

    if($makeImg->save($imgPath))
    {
        return $imgName;
    }
    return false;
}

function fileUpload($new_file, $path, $old_file_name = null)
{
    if (!file_exists(public_path($path))) {
        mkdir(public_path($path), 0777, true);
    }
    if (isset($old_file_name) && $old_file_name != "" && file_exists($path . $old_file_name)) {
        unlink($path . '/' . $old_file_name);
    }
    $input['imagename'] = uniqid() . time() . '.' . $new_file->getClientOriginalExtension();
    $destinationPath = public_path($path);
    $new_file->move($destinationPath, $input['imagename']);

    return $input['imagename'];
}

//Image Thumb Upload System
function uploadthumb($img, $path, $name, $width = null, $height = null, $old_file_name = null)
{
    if (!file_exists(public_path($path))) {
        mkdir(public_path($path), 0755, true);
    }
    if (isset($old_file_name) && $old_file_name != "" && file_exists($path . $old_file_name)) {
        unlink($path . $old_file_name);
    }
    $imgName = $name . $img->getClientOriginalName();
    $imgPath = public_path($path . $imgName);

    // making image
    $makeImg = Image::make($img);
    if ($width != null && $height != null && is_int($width) && is_int($height)) {
        $makeImg->fit($width, $height);
    }

    if ($makeImg->save($imgPath)) {
        return $imgName;
    }
    return false;
}

function pathUserImage()
{
    return 'uploaded_file/files/userimg/';
}

function removeImage($path, $file_name)
{
    if (isset($file_name) && $file_name != "" && file_exists($path . $file_name)) {
        unlink($path . $file_name);
    }
}
//Advertisement image path
function path_image()
{
    return 'uploaded_file/files/img/';
}
function path_category_image()
{
    return 'uploaded_file/files/img/category/';
}
function path_question_image()
{
    return 'uploaded_file/files/img/question/';
}
function path_question_option1_image()
{
    return 'uploaded_file/files/img/question/options/option1/';
}
function path_question_option2_image()
{
    return 'uploaded_file/files/img/question/options/option2/';
}
function path_question_option3_image()
{
    return 'uploaded_file/files/img/question/options/option3/';
}
function path_question_option4_image()
{
    return 'uploaded_file/files/img/question/options/option4/';
}
function path_question_option5_image()
{
    return 'uploaded_file/files/img/question/options/option5/';
}
function path_landing_blog_image()
{
    return 'uploaded_file/files/img/landing/blog/';
}

function language()
{
    $lang = [];
    $path = base_path('resources/lang');
    foreach (glob($path . '/*.json') as $file) {
        $langName = basename($file, '.json');
        $lang[$langName] = $langName;
    }
    return empty($lang) ? false : $lang;
}
function langName($input=null){
    $output = [
        'en' => 'English',
        'pt-PT' => 'Português(Portugal)',
        'es' => 'Español',
        'ja' => '日本人',
        'zh' => '中文',
        'ko' => '한국어',
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
if (!function_exists('settings')) {

    function settings($keys = null)
    {
        if ($keys && is_array($keys)) {
            return Adminsetting::whereIn('slug', $keys)->pluck('value', 'slug')->toArray();
        } elseif ($keys && is_string($keys)) {
            $setting = Adminsetting::where('slug', $keys)->first();
            return empty($setting) ? false : $setting->value;
        }
        return Adminsetting::pluck('value', 'slug')->toArray();
    }
}
function set_lang($lang)
{
    $lang = strtolower($lang);
    $languages = language();
    if (in_array($lang, $languages)) {
        app()->setLocale($lang);
    } else {
        if (Auth::check() && (Auth::user()->role==USER_ROLE_ADMIN) && isset(allsetting()['lang'])) {
            $lang = allsetting()['lang'];
            app()->setLocale($lang);
        }
        elseif(Auth::check() && (Auth::user()->role==USER_ROLE_USER) && isset(Auth::user()->user_settings->language)) {
            $lang = Auth::user()->user_settings->language;
            app()->setLocale($lang);
        }
    }
}

if (!function_exists('role')) {
    function role($val = null)
    {
        $myrole = array(
            1 => __('Admin'),
            2 => __('User')
        );
        if ($val == null) {
            return $myrole;
        } else {
            return $myrole[$val];
        }
        return $myrole;
    }
}
if (!function_exists('option_type')) {
    function option_type($val = null)
    {
        $data = array(
            1 => __('Multiple Choise'),
//            2 => __('Puzzle'),
        );
        if ($val == null) {
            return $data;
        } else {
            return $data[$val];
        }
    }
}
if (!function_exists('active_statuses')) {
    function active_statuses($val = null)
    {
        $data = array(
            1 => __('Active'),
            0 => __('Inactive'),
        );
        if ($val == null) {
            return $data;
        } else {
            return $data[$val];
        }
    }
}

if (!function_exists('count_question')) {
    function count_question($cat_id)
    {
        $qs = 0;
        $category = Category::where('id',$cat_id)->first();
        if (isset($category->parent_id)) {
            $qs = Question::where(['status' => 1, 'sub_category_id' => $cat_id])->count();
        } else {
            $qs = Question::where(['status' => 1, 'category_id' => $cat_id])->count();
        }

        return $qs;
    }
}

if (!function_exists('answers')) {
    function answers($question_id)
    {
        $ans = '';
        $answer = QuestionOption::where(['is_answer' => 1, 'question_id' => $question_id])->orderBy('id', 'ASC')->first();
        if (isset($answer)) {
            $ans = $answer->option_title;
        }
        return $ans;
    }
}

if (!function_exists('calculate_ranking')) {
    function calculate_ranking($user_id)
    {
        $ranking = 0;
        $scores = UserAnswer::select(
            DB::raw('user_id, SUM(point) as score'))
            ->groupBy('user_id')
            ->orderBy('score', 'DESC')
            ->get();
        $items = [];
        if(isset($scores)) {
            foreach ($scores as $score) {
                $items[] = [
                    'user_id' => $score->user_id,
                    'score' => $score->score
                ];
            }
            $ranking = array_search($user_id, array_column($items, 'user_id'));
//dd($ranking);
            if($ranking === false) {
                $ranking= 0;
            } else {
                $ranking = $ranking+1;;
            }
        } else {
            $ranking = 0;
        }

        return $ranking;
    }
}

if (!function_exists('calculate_score')) {
    function calculate_score($user_id)
    {
        $score = 0;
        $scores = UserAnswer::select(
            DB::raw('SUM(point) as score'))
            ->where('user_id',$user_id)
            ->first();
        if(isset($scores)) {
            if ($scores->score > 0) {
                $score = $scores->score;
            } else {
                $score = 0;
            }
        } else {
            $score = 0;
        }

        return $score;
    }
}

if (!function_exists('check_category_unlock')) {
    function check_category_unlock($category_id, $coin)
    {
        $is_locked = 0;
        if ($coin > 0) {
            $alreadyUnlock = CategoryUnlock::where(['user_id'=> Auth::user()->id, 'category_id' => $category_id, 'status' => 0])->first();
            if(isset($alreadyUnlock)) {
                $is_locked = 0;
            } else {
                $is_locked = 1;
            }
        }

        return $is_locked;
    }
}

function get_question_count($id) {
    $item = Question::join('categories','categories.id','=','questions.sub_category_id')
        ->where(['categories.id'=>$id])
//        ->orWhere(['categories.parent_id'=>$id])
        ->count();
    return $item;
}

//google firebase
function pushNotification($registrationIds,$type, $data_id, $count)
{
    $cat = \App\Model\Category::find($data_id);
    $fields = array
    (
        'to' => $registrationIds,
        "delay_while_idle" => true,
        "time_to_live" => 3,
        /*    'notification' => [
                'body' => strip_tags(str_limit($news->description,30)),
                'title' => str_limit($news->title,25),
            ],*/
        'data'=> [
//            'message' => strip_tags(str_limit($news->description,30)),
            'name' => $cat->name,
            'id' => $cat->id,
            'is_background' => true,
            'content_available'=>true,
        ]
    );


    $headers = array
    (
        'Authorization: key=' . API_ACCESS_KEY,
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    curl_close($ch);

    return $fields;

}

//google firebase
function pushNotificationIos($registrationIds,$type, $data_id, $count)
{

    $news = \App\News::find($data_id);

    $fields = array
    (
        'to' => $registrationIds,
        "delay_while_idle" => true,

        "time_to_live" => 3,
        'notification' => [
            'body' => strip_tags(str_limit($news->description,30)),
            'title' => str_limit($news->title,25),
            'vibrate' => 1,
            'sound' => 'default',
        ],
        'data'=> [
            'message' => strip_tags(str_limit($news->description,30)),
            'title' => str_limit($news->title,25),
            'id' => $news->id,
            'is_background' => true,
            'content_available'=>true,


        ]
    );

    $headers = array
    (
        'Authorization: key=' . API_ACCESS_KEY,
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    curl_close($ch);

    return $fields;

}

// country list

function country($lang = null)
{
    $output = [
        'AF' => __('Afghanistan'),
        'AL' => __('Albania'),
        'DZ' => __('Algeria'),
        'DS' => __('American Samoa'),
        'AD' => __('Andorra'),
        'AO' => __('Angola'),
        'AI' => __('Anguilla'),
        'AQ' => __('Antarctica'),
        'AG' => __('Antigua and Barbuda'),
        'AR' => __('Argentina'),
        'AM' => __('Armenia'),
        'AW' => __('Aruba'),
        'AU' => __('Australia'),
        'AT' => __('Austria'),
        'AZ' => __('Azerbaijan'),
        'BS' => __('Bahamas'),
        'BH' => __('Bahrain'),
        'BD' => __('Bangladesh'),
        'BB' => __('Barbados'),
        'BY' => __('Belarus'),
        'BE' => __('Belgium'),
        'BZ' => __('Belize'),
        'BJ' => __('Benin'),
        'BM' => __('Bermuda'),
        'BT' => __('Bhutan'),
        'BO' => __('Bolivia'),
        'BA' => __('Bosnia and Herzegovina'),
        'BW' => __('Botswana'),
        'BV' => __('Bouvet Island'),
        'BR' => __('Brazil'),
        'IO' => __('British Indian Ocean Territory'),
        'BN' => __('Brunei Darussalam'),
        'BG' => __('Bulgaria'),
        'BF' => __('Burkina Faso'),
        'BI' => __('Burundi'),
        'KH' => __('Cambodia'),
        'CM' => __('Cameroon'),
        'CA' => __('Canada'),
        'CV' => __('Cape Verde'),
        'KY' => __('Cayman Islands'),
        'CF' => __('Central African Republic'),
        'TD' => __('Chad'),
        'CL' => __('Chile'),
        'CN' => __('China'),
        'CX' => __('Christmas Island'),
        'CC' => __('Cocos (Keeling) Islands'),
        'CO' => __('Colombia'),
        'KM' => __('Comoros'),
        'CG' => __('Congo'),
        'CK' => __('Cook Islands'),
        'CR' => __('Costa Rica'),
        'HR' => __('Croatia (Hrvatska)'),
        'CU' => __('Cuba'),
        'CY' => __('Cyprus'),
        'CZ' => __('Czech Republic'),
        'DK' => __('Denmark'),
        'DJ' => __('Djibouti'),
        'DM' => __('Dominica'),
        'DO' => __('Dominican Republic'),
        'TP' => __('East Timor'),
        'EC' => __('Ecuador'),
        'EG' => __('Egypt'),
        'SV' => __('El Salvador'),
        'GQ' => __('Equatorial Guinea'),
        'ER' => __('Eritrea'),
        'EE' => __('Estonia'),
        'ET' => __('Ethiopia'),
        'FK' => __('Falkland Islands (Malvinas)'),
        'FO' => __('Faroe Islands'),
        'FJ' => __('Fiji'),
        'FI' => __('Finland'),
        'FR' => __('France'),
        'FX' => __('France, Metropolitan'),
        'GF' => __('French Guiana'),
        'PF' => __('French Polynesia'),
        'TF' => __('French Southern Territories'),
        'GA' => __('Gabon'),
        'GM' => __('Gambia'),
        'GE' => __('Georgia'),
        'DE' => __('Germany'),
        'GH' => __('Ghana'),
        'GI' => __('Gibraltar'),
        'GK' => __('Guernsey'),
        'GR' => __('Greece'),
        'GL' => __('Greenland'),
        'GD' => __('Grenada'),
        'GP' => __('Guadeloupe'),
        'GU' => __('Guam'),
        'GT' => __('Guatemala'),
        'GN' => __('Guinea'),
        'GW' => __('Guinea-Bissau'),
        'GY' => __('Guyana'),
        'HT' => __('Haiti'),
        'HM' => __('Heard and Mc Donald Islands'),
        'HN' => __('Honduras'),
        'HK' => __('Hong Kong'),
        'HU' => __('Hungary'),
        'IS' => __('Iceland'),
        'IN' => __('India'),
        'IM' => __('Isle of Man'),
        'ID' => __('Indonesia'),
        'IR' => __('Iran (Islamic Republic of)'),
        'IQ' => __('Iraq'),
        'IE' => __('Ireland'),
        'IL' => __('Israel'),
        'IT' => __('Italy'),
        'CI' => __('Ivory Coast'),
        'JE' => __('Jersey'),
        'JM' => __('Jamaica'),
        'JP' => __('Japan'),
        'JO' => __('Jordan'),
        'KZ' => __('Kazakhstan'),
        'KE' => __('Kenya'),
        'KI' => __('Kiribati'),
        'KP' => __('Korea, Democratic People\'s Republic of'),
        'KR' => __('Korea, Republic of'),
        'XK' => __('Kosovo'),
        'KW' => __('Kuwait'),
        'KG' => __('Kyrgyzstan'),
        'LA' => __('Lao People\'s Democratic Republic'),
        'LV' => __('Latvia'),
        'LB' => __('Lebanon'),
        'LS' => __('Lesotho'),
        'LR' => __('Liberia'),
        'LY' => __('Libyan Arab Jamahiriya'),
        'LI' => __('Liechtenstein'),
        'LT' => __('Lithuania'),
        'LU' => __('Luxembourg'),
        'MO' => __('Macau'),
        'MK' => __('Macedonia'),
        'MG' => __('Madagascar'),
        'MW' => __('Malawi'),
        'MY' => __('Malaysia'),
        'MV' => __('Maldives'),
        'ML' => __('Mali'),
        'MT' => __('Malta'),
        'MH' => __('Marshall Islands'),
        'MQ' => __('Martinique'),
        'MR' => __('Mauritania'),
        'MU' => __('Mauritius'),
        'TY' => __('Mayotte'),
        'MX' => __('Mexico'),
        'FM' => __('Micronesia, Federated States of'),
        'MD' => __('Moldova, Republic of'),
        'MC' => __('Monaco'),
        'MN' => __('Mongolia'),
        'ME' => __('Montenegro'),
        'MS' => __('Montserrat'),
        'MA' => __('Morocco'),
        'MZ' => __('Mozambique'),
        'MM' => __('Myanmar'),
        'NA' => __('Namibia'),
        'NR' => __('Nauru'),
        'NP' => __('Nepal'),
        'NL' => __('Netherlands'),
        'AN' => __('Netherlands Antilles'),
        'NC' => __('New Caledonia'),
        'NZ' => __('New Zealand'),
        'NI' => __('Nicaragua'),
        'NE' => __('Niger'),
        'NG' => __('Nigeria'),
        'NU' => __('Niue'),
        'NF' => __('Norfolk Island'),
        'MP' => __('Northern Mariana Islands'),
        'NO' => __('Norway'),
        'OM' => __('Oman'),
        'PK' => __('Pakistan'),
        'PW' => __('Palau'),
        'PS' => __('Palestine'),
        'PA' => __('Panama'),
        'PG' => __('Papua New Guinea'),
        'PY' => __('Paraguay'),
        'PE' => __('Peru'),
        'PH' => __('Philippines'),
        'PN' => __('Pitcairn'),
        'PL' => __('Poland'),
        'PT' => __('Portugal'),
        'PR' => __('Puerto Rico'),
        'QA' => __('Qatar'),
        'RE' => __('Reunion'),
        'RO' => __('Romania'),
        'RU' => __('Russian Federation'),
        'RW' => __('Rwanda'),
        'KN' => __('Saint Kitts and Nevis'),
        'LC' => __('Saint Lucia'),
        'VC' => __('Saint Vincent and the Grenadines'),
        'WS' => __('Samoa'),
        'SM' => __('San Marino'),
        'ST' => __('Sao Tome and Principe'),
        'SA' => __('Saudi Arabia'),
        'SN' => __('Senegal'),
        'RS' => __('Serbia'),
        'SC' => __('Seychelles'),
        'SL' => __('Sierra Leone'),
        'SG' => __('Singapore'),
        'SK' => __('Slovakia'),
        'SI' => __('Slovenia'),
        'SB' => __('Solomon Islands'),
        'SO' => __('Somalia'),
        'ZA' => __('South Africa'),
        'GS' => __('South Georgia South Sandwich Islands'),
        'ES' => __('Spain'),
        'LK' => __('Sri Lanka'),
        'SH' => __('St. Helena'),
        'PM' => __('St. Pierre and Miquelon'),
        'SD' => __('Sudan'),
        'SR' => __('Suriname'),
        'SJ' => __('Svalbard and Jan Mayen Islands'),
        'SZ' => __('Swaziland'),
        'SE' => __('Sweden'),
        'CH' => __('Switzerland'),
        'SY' => __('Syrian Arab Republic'),
        'TW' => __('Taiwan'),
        'TJ' => __('Tajikistan'),
        'TZ' => __('Tanzania, United Republic of'),
        'TH' => __('Thailand'),
        'TG' => __('Togo'),
        'TK' => __('Tokelau'),
        'TO' => __('Tonga'),
        'TT' => __('Trinidad and Tobago'),
        'TN' => __('Tunisia'),
        'TR' => __('Turkey'),
        'TM' => __('Turkmenistan'),
        'TC' => __('Turks and Caicos Islands'),
        'TV' => __('Tuvalu'),
        'UG' => __('Uganda'),
        'UA' => __('Ukraine'),
        'AE' => __('United Arab Emirates'),
        'UK' => __('United Kingdom'),
        'US' => __('United States'),
        'UM' => __('United States minor outlying islands'),
        'UY' => __('Uruguay'),
        'UZ' => __('Uzbekistan'),
        'VU' => __('Vanuatu'),
        'VA' => __('Vatican City State'),
        'VE' => __('Venezuela'),
        'VN' => __('Vietnam'),
        'VG' => __('Virgin Islands (British)'),
        'VI' => __('Virgin Islands (U.S.)'),
        'WF' => __('Wallis and Futuna Islands'),
        'EH' => __('Western Sahara'),
        'YE' => __('Yemen'),
        'ZR' => __('Zaire'),
        'ZM' => __('Zambia'),
        'ZW' => __('Zimbabwe')
    ];

    if ($lang == null) {
        return $output;
    } else if (is_array($lang)) {
        return array_intersect($output, $lang);
    } else {
        return isset($output[$lang]) ? $output[$lang] : $lang;
    }
}

if (!function_exists('all_month')) {
    function all_month($val = null)
    {
        $data = array(
            12 => 12,
            11 => 11,
            10 => 10,
            9 => 9,
            8 => 8,
            7 => 7,
            6 => 6,
            5 => 5,
            4 => 4,
            3 => 3,
            2 => 2,
            1 => 1,
        );
        if ($val == null) {
            return $data;
        } else {
            return $data[$val];
        }
    }
}

if (!function_exists('all_months')) {
    function all_months($val = null)
    {
        $data = array(
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6,
            7 => 7,
            8 => 8,
            9 => 9,
            10 => 10,
            11 => 11,
            12 => 12,
        );
        if ($val == null) {
            return $data;
        } else {
            return $data[$val];
        }
    }
}

