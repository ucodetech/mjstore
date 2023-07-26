<?php

use App\Models\Shipping;

function hasPermission($permission){
    $permissions = auth()->user()->permission;
    $userPermissions = explode(',', $permissions);
    if(in_array($permission, $userPermissions, true)){
        return true;
    }
    return false;

}

// function isClient($user){
//     $whoisuser =$user->whoIsUser;
//     if($whoisuser == 1){
//         return true;
//     }else{
//         return false;
//     }
// }


function slugUrl($checkSlug, $slug_url){
    if($checkSlug){

        foreach($checkSlug as $slug){
            $data[] = $slug->image_slug_url;
        }
        if(in_array($slug_url, $data)){
            $count = 0;
            while(in_array(($slug_url.'-'.$count++), $data)){
                $slug_url = $slug_url .'-' . $count;
            }
        }
        return $slug_url;
    }
   
}


function generateKey(){
    $keyLength = 32;
    $str = "1234567890abcdefghijklmnopqrstuvwxyz";
    $randStr = substr(str_shuffle($str), 0, $keyLength);
    return $randStr;
}

function generateKey8(){
    $keyLength = 8;
    $str = "1234567890abcdefghijklmnopqrstuvwxyz()/\@#$[]";
    $randStr = substr(str_shuffle($str), 0, $keyLength);
    return $randStr;
}

function generateKey2(){
    $keyLength = '6';
    $str = "1234567890abcdefghijklmnopqrstuvwxyz";
    $randStr = substr(str_shuffle($str), 0, $keyLength);
    return $randStr;
}

function endOFMonth($date){
    $date = new DateTime($date);
    $date->modify('last day of this month');
    return $date->format('Y-m-d');
}
function Yestarday($date){
    $date = new DateTime($date);
    $date->modify('yestarday');
    return $date->format('d');
}

// get last 7 days 
function last7days($date){
    if(strtotime($date) < strtotime('-7 days')){
        return $date;
    }
}

function pretty_days($date)
{
return date('t', strtotime($date));
}

function pretty_dated($date){
        return date("Y-m-d", strtotime($date));
    }


function pretty_date($date){
        return date("M d, Y h:i A", strtotime($date));
    }
function pretty_dates($dates){
        return date("M d, Y ", strtotime($dates));
    }
function pretty_datee($dates){
        return date("h:i A ", strtotime($dates));
    }

function    pretty_num($m){
    return date('m', strtotime($m));
}
function    pretty_numD($d){
    return date('d', strtotime($d));
}
function pretty_year($year)
{
    return date("Y", strtotime($year));
}

function pretty_day($day)
{
    return date("d", strtotime($day));
}
function pretty_dayLetterd($day)
{
    return date("D", strtotime($day));
}
function pretty_monthLetter($month)
{
    return date("M", strtotime($month));
}
function pretty_monthNumber($month)
{
    return date("m", strtotime($month));
}

function pretty_time($time){
        return date("h:i a");
    }
function pretty_time1($time){
        return date("h:i");
    }
function pretty_nameDay($day){
    return date('D d  M, Y');
}
function timeAgo($time){
    date_default_timezone_set('Africa/Lagos');
    $time = strtotime($time) ? strtotime($time) : $time;
    $timed = time() - $time;

    switch ($timed) {
        case $timed <= 60:
            return 'Just Now!';
        break;
        case $timed >= 60 && $timed < 3600:
            return (round($timed/60) == 1) ? 'a minute ago' : round($timed/60). ' minutes ago';
        break;
        case $timed >= 3600 && $timed < 86400:
            return (round($timed/3600) == 1) ? 'an hour ago' : round($timed/3600). '  hours ago';
        break;
        case $timed >= 86400 && $timed < 604800:
            return (round($timed/86400 ) == 1) ? 'a day ago' : round($timed/86400 ). '  days ago';
        break;

        case $timed >= 604800 && $timed < 2600640:
            return (round($timed/604800 ) == 1) ? 'a week ago' : round($timed/604800 ). '  weeks ago';
            break;
        case $timed >=  2600640 && $timed < 31207680:
            return (round($timed/604800 ) == 1) ? 'a month ago' : round($timed/604800 ). '  months ago';
            break;
        case $timed >= 31207680:
            return (round($timed/31207680 ) == 1) ? 'a year ago' : round($timed/31207680 ). '  years ago';
            break;
    }

}
// is date a month
function IsOneMonth($date){
    date_default_timezone_set('Africa/Lagos');
    $dated = new Carbon\Carbon($date);
    if($dated->diffInMonths() < 1){
        return true;
    }
    return false;
    
    
   
}
function dateDiffInDays($date1, $date2)
{
    // Calculating the difference in timestamps
    $diff = strtotime($date2) - strtotime($date1);

    // 1 day = 24 hours
    // 24 * 60 * 60 = 86400 seconds
    return abs(round($diff / 86400));
}
function wrap2($string) {
    $wstring = explode("\n", wordwrap($string, 20, "\n") );
    return $wstring[0];
}
function wrap($string) {
    $wstring = explode("\n", wordwrap($string, 30, "\n") );
    return $wstring[0];
}
function wrap3($string) {
    $wstring = explode("\n", wordwrap($string, 100, "\n") );
    return $wstring[0];
}
function wrap50($string) {
    $wstring = explode("\n", wordwrap($string, 50, "\n"));
    return $wstring[0].'....';
}
function wrap20($string) {
    $wstring = explode("\n", wordwrap($string, 20, "\n"));
    return $wstring[0].'....';
}
function sizeFilter( $bytes )
{
    $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
    for( $i = 0; $bytes >= 1024 && $i < ( count( $label ) -1 ); $bytes /= 1024, $i++ );
    return( round( $bytes, 2 ) . " " . $label[$i] );
}


function weekOfMonth($date) {
    //Get the first day of the month.
    $firstOfMonth = strtotime(date("Y-m-01", $date));
    //Apply above formula.
    return weekOfYear($date) - weekOfYear($firstOfMonth) + 1;
}

function weekOfYear($date) {
    $weekOfYear = intval(date("W", $date));
    if (date('n', $date) == "1" && $weekOfYear > 51) {
    // It's the last week of the previous year.
    return 0;
}
else if (date('n', $date) == "12" && $weekOfYear == 1) {
    // It's the first week of the next year.
    return 53;
}
else {
    // It's a "normal" week.
    return $weekOfYear;
}

}



//naira money format
function Naira($money){
    return '₦'.number_format($money, 2);
}
function NairaSign(){
    return '₦';
}
//dollar money format
function Dollar($money){
    return '$'.number_format($money, 2);
}

//get percentage
function N2P($var){
    return round((int)$var / 100 ) . '%';
}

function cal_percentage($num) {
    $count1 = $num / 100;
    $count2 = $count1 * 100;
    $count = number_format($count2, 0);
    return $count;
}
//input to string
function IN2String($str){
    return strval($str);
}

function removeTag($string){
    return strip_tags($string);
}

function Filter($value){
    return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
}
function removeComma($value){
    return filter_var($value, FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_THOUSAND);
}

function muser(){
    if(auth()->check()){
        return auth()->user();
    }
}

function userPhone($phone){
    $phone = explode(',' ,$phone);
    return $phone;
}

function productPhoto($photo){
    $photo = explode(',' ,$photo);
    return $photo;
}

function getShippingMethod($shipping_id){
    return App\Models\Shipping::where('id', $shipping_id)->get()->first();
}

function formattedOrderStatus($order_status){
    switch ($order_status) {
        case 'pending':
            return "badge-warning";
            break;
        case 'processing':
           return "badge-info";
            break;
        case 'delivered':
            return "badge-success";
            break;
        default:
            break;
    }
    
}

//load currency
function currency_load(){
    if(!session()->has('default_currency')){
        session()->put('default_currency', App\Models\Currency::where('code', 'NGN')->first());
    }
}

//currency sign 
function CurrencySign(){
    return currency_symbol();
}

//currency converter
function currency_converter($price){
    return format_price(convert_price($price));
}

//convert price
if(!function_exists('convert_price')){
    function convert_price($price){
      
        // if(session()->has('default_currency')){
        //     session()->flush('default_currency');
        // }
        currency_load();
        $default_currency = session('default_currency');
        $price = floatval($price)/floatval($default_currency->exchange_rate);
        
        if(session()->has('currency_exchange_rate'))
        $exchange = session('currency_exchange_rate');
        else
        $exchange = $default_currency->exchange_rate;

        $price = floatval($price) * floatval($exchange);
        return $price;

    }
}

//currency symbol
if(!function_exists('currency_symbol')){
    function currency_symbol(){
        currency_load();
        if(session()->has('currency_symbol')){
            $symbol = session('currency_symbol');
        }else{
            $default_currency = session('default_currency');
            $symbol = $default_currency->symbol;
        }
        return $symbol;
    }
}

//format currency
if(!function_exists('format_price')){
    function format_price($price){
        return currency_symbol() .  number_format($price, 2);
    }
}