<?php

namespace App\Core\Helpers;

use App\Core\Helpers\__static;
use Carbon\Carbon;
use Str;

class __dataType{




    public static function string_to_boolean($value){

       if($value == 'true'){ return true; }
       elseif($value == 'false'){ return false; }

    }
    





    public static function boolean_to_string($value){

       if($value == true){ return 'true'; }
       elseif($value == false){ return 'false'; }

    }






    public static function date_parse($value, $format = 'Y-m-d'){

        $date = null;

        if($value != null || $value != ''){
          $date = Carbon::parse($value)->format($format);
        }

        return $date;

    }






    public static function time_parse($value, $format = 'H:i:s'){

      $time = null;

      if($value != null || $value != ''){
        $time = date($format, strtotime($value));
      }

      return $time;

    }






    public static function string_to_num($value){

      $num = null;

      if($value != null || $value != ''){
        $num = str_replace(',', '', $value);
      }

      return $num;

    }






    public static function construct_time_HM($hrs, $mins){

        while ($mins >= 60) {
          
          $hrs = $hrs + 1;
          $mins = $mins - 60;

        }    

        return sprintf("%02d", $hrs) .':'. sprintf("%02d", $mins);

    }





    public static function fileFilterReservedChar($filename, $extention){

        $filename = str_replace($extention, '', $filename);

        $filename = Str::limit($filename, 150);

        $filename = str_replace(['?', '%', '*', ':', ';', '|', '"', '<', '>', '.', '//', '/'], '', $filename);

        $filename = stripslashes($filename);

        return $filename . $extention;

    }






    public static function date_scope($from, $to){

      $date_scope = "";

      if (!empty($from) && !empty($to)) {
          
        $f = self::date_parse($from, 'F d, Y');
        $mf = self::date_parse($from, 'F');
        $df = self::date_parse($from, 'd');
        $yf = self::date_parse($from, 'Y');
        $mdf = self::date_parse($from, 'F d');
        $t = self::date_parse($to, 'F d, Y');
        $mt = self::date_parse($to, 'F');
        $dt = self::date_parse($to, 'd');
        $yt = self::date_parse($to, 'Y');
        $mdt = self::date_parse($to, 'M d');

        if($mf == $mt && $yf == $yt){
          if($mdf == $mdt){
            $date_scope =  $mf .' '. $df .', '. $yf;
          }else{
            $date_scope = $mf .' '. $df .' - '. $dt .', '. $yt;
          }
        }elseif($mf != $mt && $yf == $yt){
          $date_scope = $mf .' '. $df .' - '. $mt .' '. $dt .', '. $yt;
        }else{
          $date_scope = $f .' - '. $t;
        }

      }

      return $date_scope;

    }




    public static function num_to_words($num){ 

      $ones = array( 
          0 => "",
          1 => "one", 
          2 => "two", 
          3 => "three", 
          4 => "four", 
          5 => "five", 
          6 => "six", 
          7 => "seven", 
          8 => "eight", 
          9 => "nine", 
          10 => "ten", 
          11 => "eleven", 
          12 => "twelve", 
          13 => "thirteen", 
          14 => "fourteen", 
          15 => "fifteen", 
          16 => "sixteen", 
          17 => "seventeen", 
          18 => "eighteen", 
          19 => "nineteen" 
      ); 

      $tens = array( 
          0 => "",
          1 => "ten",
          2 => "twenty", 
          3 => "thirty", 
          4 => "forty", 
          5 => "fifty", 
          6 => "sixty", 
          7 => "seventy", 
          8 => "eighty", 
          9 => "ninety" 
      ); 

      $hundreds = array( 
          "hundred", 
          "thousand", 
          "million", 
          "billion", 
          "trillion", 
          "quadrillion" 
      );

      $num = number_format($num,2,".",","); 
      $num_arr = explode(".",$num); 
      $wholenum = $num_arr[0]; 
      $decnum = $num_arr[1]; 
      $whole_arr = array_reverse(explode(",",$wholenum)); 
      krsort($whole_arr); 
      $rettxt = ""; 

      foreach($whole_arr as $key => $i){ 

        if($i > 0 && $i < 20){ 
          $rettxt .= $ones[$i]; 
        }elseif($i > 0 && $i < 100){
          if(substr($i,1,1) == 0) {
             $rettxt .= $tens[substr($i,0,1)];
          }else{
            if (substr($i,0,1) == 0) {
              $rettxt .= $tens[substr($i,1,1)];
              $rettxt .= " ".$ones[substr($i,2,1)];
            }else{
              $rettxt .= $tens[substr($i,0,1)];
              $rettxt .= " ".$ones[substr($i,1,1)];
            }
          } 
        }elseif($i == 0){
          $rettxt .= "";
        }else{
          $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0];
          if(substr($i,1,1) == 1){
            $rettxt .= " ".$ones[substr($i,-2)];
          }elseif(substr($i,1,1) == 0){
            $rettxt .= " ".$ones[substr($i,2,1)];
          }elseif(substr($i,1,1) == 0 && substr($i,2,1) == 0){
            $rettxt .= "";
          }else{
            $rettxt .= " ".$tens[substr($i,1,1)];
            $rettxt .= " ".$ones[substr($i,2,1)];
          }
        }

        if($i > 0 && $key > 0){ 
          $rettxt .= " ".$hundreds[$key]." "; 
        }

      } 


      if($decnum > 0){ 
        $rettxt .= " point "; 
        if($decnum < 20){ 
          $rettxt .= $ones[$decnum]; 
        }elseif($decnum < 100){ 
          $rettxt .= $tens[substr($decnum,0,1)]; 
          $rettxt .= " ".$ones[substr($decnum,1,1)]; 
        } 
      }
          

      return strtoupper($rettxt); 


    }






}