<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// lang file must be at the same directory


/**
 * \ingroup data
 *
 * Jalali Date function by Milad Rastian (miladmovie AT yahoo DOT com)
 * 
 * The main function which convert Gregorian to Jalali calendars is:
 * Copyright (C) 2000  Roozbeh Pournader and Mohammad Toossi
 * you can see complete note of those function in down of the page
 *
 *		AND JALAI DATE FUNCTION
 * this function is simillar than date function in PHP
 * you can find more about it in http://jdf.farsiprojects.com
 *		Copyright (C)2003 FARSI PROJECTS GROUP
 */
class JalaliCalendar
{

	function jdate($type,$maket="now")
	{
		$result="";
		if($maket=="now"){
			$year=date("Y");
			$month=date("m");
			$day=date("d");
			list( $jyear, $jmonth, $jday ) = JalaliCalendar::gregorian_to_jalali($year, $month, $day);
			$maket=JalaliCalendar::jmaketime(date("h")+_JDF_TZhours,date("i")+_JDF_TZminute,date("s"),$jmonth,$jday,$jyear);
		}else{
			$maket+=_JDF_TZhours*3600+_JDF_TZminute*60;
			$date=date("Y-m-d",$maket);
			list( $year, $month, $day ) = preg_split ( '/-/', $date );
	
			list( $jyear, $jmonth, $jday ) = JalaliCalendar::gregorian_to_jalali($year, $month, $day);
			}
	
		$need= $maket;
		$year=date("Y",$need);
		$month=date("m",$need);
		$day=date("d",$need);
		$i=0;
		while($i<strlen($type))
		{
			$subtype=substr($type,$i,1);
			switch ($subtype)
			{
	
				case "A":
					$result1=date("a",$need);
					if($result1=="pm") $result.=_JDF_PM_LONG;
					else $result.=_JDF_AM_LONG;
					break;
	
				case "a":
					$result1=date("a",$need);
					if($result1=="pm") $result.=_JDF_PM_SHORT;
					else $result.=_JDF_AM_SHORT;
					break;
				case "d":
					list( $jyear, $jmonth, $jday ) = JalaliCalendar::gregorian_to_jalali($year, $month, $day);
					if($jday<10)$result1="0".$jday;
					else 	$result1=$jday;
					if(_JDF_USE_PERSIANNUM) $result.=JalaliCalendar::Convertnumber2farsi($result1);
					else $result.=$result1;
					break;
				case "D":
					$result1=date("D",$need);
					if($result1=="Sat") $result1=_JDF_Sat_SHORT;
					else if($result1=="Sun") $result1=_JDF_Sun_SHORT;
					else if($result1=="Mon") $result1=_JDF_Mon_SHORT;
					else if($result1=="Tue") $result1=_JDF_Tue_SHORT;
					else if($result1=="Wed") $result1=_JDF_Wed_SHORT;
					else if($result1=="Thu") $result1=_JDF_Thu_SHORT;
	                                else if($result1=="Fri") $result1=_JDF_Fri_SHORT;
					$result.=$result1;
					break;
				case"F":
					list( $jyear, $jmonth, $jday ) = JalaliCalendar::gregorian_to_jalali($year, $month, $day);
					$result.=monthname($jmonth);
					break;
				case "g":
					$result1=date("g",$need);
					if(_JDF_USE_PERSIANNUM) $result.=JalaliCalendar::Convertnumber2farsi($result1);
					else $result.=$result1;
					break;
				case "G":
					$result1=date("G",$need);
					if(_JDF_USE_PERSIANNUM) $result.=JalaliCalendar::Convertnumber2farsi($result1);
					else $result.=$result1;
					break;
					case "h":
					$result1=date("h",$need);
					if(_JDF_USE_PERSIANNUM) $result.=JalaliCalendar::Convertnumber2farsi($result1);
					else $result.=$result1;
					break;
				case "H":
					$result1=date("H",$need);
					if(_JDF_USE_PERSIANNUM) $result.=JalaliCalendar::Convertnumber2farsi($result1);
					else $result.=$result1;
					break;
				case "i":
					$result1=date("i",$need);
					if(_JDF_USE_PERSIANNUM) $result.=JalaliCalendar::Convertnumber2farsi($result1);
					else $result.=$result1;
					break;
				case "j":
					list( $jyear, $jmonth, $jday ) = JalaliCalendar::gregorian_to_jalali($year, $month, $day);
					$result1=$jday;
					if(_JDF_USE_PERSIANNUM) $result.=JalaliCalendar::Convertnumber2farsi($result1);
					else $result.=$result1;
					break;
				case "l":
					$result1=date("l",$need);
					if($result1=="Saturday") $result1=_JDF_Sat_LONG;
					else if($result1=="Sunday") $result1=_JDF_Sun_LONG;
					else if($result1=="Monday") $result1=_JDF_Mon_LONG;
					else if($result1=="Tuesday") $result1=_JDF_Tue_LONG;
					else if($result1=="Wednesday") $result1=_JDF_Wed_LONG;
					else if($result1=="Thursday") $result1=_JDF_Thu_LONG;
					else if($result1=="Friday") $result1=_JDF_Fri_LONG;
					$result.=$result1;
					break;
				case "m":
					list( $jyear, $jmonth, $jday ) = JalaliCalendar::gregorian_to_jalali($year, $month, $day);
					if($jmonth<10) $result1="0".$jmonth;
					else	$result1=$jmonth;
					if(_JDF_USE_PERSIANNUM) $result.=JalaliCalendar::Convertnumber2farsi($result1);
					else $result.=$result1;
					break;
				case "M":
					list( $jyear, $jmonth, $jday ) = JalaliCalendar::gregorian_to_jalali($year, $month, $day);
					$result.=monthname($jmonth);
					break;
				case "n":
					list( $jyear, $jmonth, $jday ) = JalaliCalendar::gregorian_to_jalali($year, $month, $day);
					$result1=$jmonth;
					if(_JDF_USE_PERSIANNUM) $result.=JalaliCalendar::Convertnumber2farsi($result1);
					else $result.=$result1;
					break;
				case "s":
					$result1=date("s",$need);
					if(_JDF_USE_PERSIANNUM) $result.=JalaliCalendar::Convertnumber2farsi($result1);
					else $result.=$result1;
					break;
				case "S":
					$result.=_JDF_Suffix;
					break;
				case "t":
					$result.=JalaliCalendar::lastday ($month,$day,$year);
					break;
				case "w":
					$result1=date("w",$need);
					if(_JDF_USE_PERSIANNUM) $result.=JalaliCalendar::Convertnumber2farsi($result1);
					else $result.=$result1;
					break;
				case "y":
					list( $jyear, $jmonth, $jday ) = JalaliCalendar::gregorian_to_jalali($year, $month, $day);
					$result1=substr($jyear,2,4);
					if(_JDF_USE_PERSIANNUM) $result.=JalaliCalendar::Convertnumber2farsi($result1);
					else $result.=$result1;
					break;
				case "Y":
					list( $jyear, $jmonth, $jday ) = JalaliCalendar::gregorian_to_jalali($year, $month, $day);
					$result1=$jyear;
					if(_JDF_USE_PERSIANNUM) $result.=JalaliCalendar::Convertnumber2farsi($result1);
					else $result.=$result1;
					break;
				default:
					$result.=$subtype;
			}
		$i++;
		}
		return $result;
	}
	
	
	
	function jmaketime($hour,$minute,$second,$jmonth,$jday,$jyear)
	{
		list( $year, $month, $day ) = JalaliCalendar::jalali_to_gregorian($jyear, $jmonth, $jday);
		$i=mktime($hour,$minute,$second,$month,$day,$year);
		return $i;
	}
	
	
	///Find Day Begining Of Month
	function mstart($month,$day,$year)
	{
		list( $jyear, $jmonth, $jday ) = JalaliCalendar::gregorian_to_jalali($year, $month, $day);
		list( $year, $month, $day ) = JalaliCalendar::jalali_to_gregorian($jyear, $jmonth, "1");
		$timestamp=mktime(0,0,0,$month,$day,$year);
		return date("w",$timestamp);
	}
	
	//Find Number Of Days In This Month
	function lastday ($month,$day,$year)
	{
		$lastdayen=date("d",mktime(0,0,0,$month+1,0,$year));
		list( $jyear, $jmonth, $jday ) = JalaliCalendar::gregorian_to_jalali($year, $month, $day);
		$lastdatep=$jday;
		$jday=$jday2;
		while($jday2!="1")
		{
			if($day<$lastdayen)
			{
				$day++;
				list( $jyear, $jmonth, $jday2 ) = JalaliCalendar::gregorian_to_jalali($year, $month, $day);
				if($jdate2=="1") break;
				if($jdate2!="1") $lastdatep++;
			}
			else
			{
				$day=0;
				$month++;
				if($month==13)
				{
						$month="1";
						$year++;
				}
			}
	
		}
		return $lastdatep-1;
	}
	
	//translate number of month to name of month
	function monthname($month)
	{
	
	    if($month=="01") return _JDF_Far;
	
	    if($month=="02") return _JDF_Ord;
	
	    if($month=="03") return _JDF_Kho;
	
	    if($month=="04") return _JDF_Tir;
	
	    if($month=="05") return _JDF_Mor;
	
	    if($month=="06") return _JDF_Sha;
	
	    if($month=="07") return _JDF_Meh;
	
	    if($month=="08") return _JDF_Aba;
	
	    if($month=="09") return _JDF_Aza;
	
	    if($month=="10") return _JDF_Dey;
	
	    if($month=="11") return _JDF_Bah;
	
	    if($month=="12") return _JDF_Esf;
	}
	
	////here convert to  number in persian
	function Convertnumber2farsi($srting)
	{
		$stringtemp="";
		$len=strlen($srting);
		for($sub=0;$sub<$len;$sub++)
		{
		 if(substr($srting,$sub,1)=="0")$stringtemp.=_JDF_Num0;
		 elseif(substr($srting,$sub,1)=="1")$stringtemp.=_JDF_Num1;
		 elseif(substr($srting,$sub,1)=="2")$stringtemp.=_JDF_Num2;
		 elseif(substr($srting,$sub,1)=="3")$stringtemp.=_JDF_Num3;
		 elseif(substr($srting,$sub,1)=="4")$stringtemp.=_JDF_Num4;
		 elseif(substr($srting,$sub,1)=="5")$stringtemp.=_JDF_Num5;
		 elseif(substr($srting,$sub,1)=="6")$stringtemp.=_JDF_Num6;
		 elseif(substr($srting,$sub,1)=="7")$stringtemp.=_JDF_Num7;
		 elseif(substr($srting,$sub,1)=="8")$stringtemp.=_JDF_Num8;
		 elseif(substr($srting,$sub,1)=="9")$stringtemp.=_JDF_Num9;
		 else {$stringtemp.=substr($srting,$sub,2);$sub++;}
	
		}
	return   $stringtemp;
	
	}///end convert to number in persian
	
	
	////here convert to  number in english
	function Convertnumber2english($srting)
	{
		$stringtemp="";
		$len=strlen($srting);
	
		for($sub=0;$sub<$len;$sub+=2)
		{
		 if(substr($srting,$sub,2)==_JDF_Num0)$stringtemp.="0";
		 elseif(substr($srting,$sub,2)==_JDF_Num1)$stringtemp.="1";
		 elseif(substr($srting,$sub,2)==_JDF_Num2)$stringtemp.="2";
		 elseif(substr($srting,$sub,2)==_JDF_Num3)$stringtemp.="3";
	         elseif(substr($srting,$sub,2)==_JDF_Num4)$stringtemp.="4";
		 elseif(substr($srting,$sub,2)==_JDF_Num5)$stringtemp.="5";
		 elseif(substr($srting,$sub,2)==_JDF_Num6)$stringtemp.="6";
		 elseif(substr($srting,$sub,2)==_JDF_Num7)$stringtemp.="7";
		 elseif(substr($srting,$sub,2)==_JDF_Num8)$stringtemp.="8";
		 elseif(substr($srting,$sub,2)==_JDF_Num9)$stringtemp.="9";
		 else {$stringtemp.=substr($srting,$sub,1);$sub--;}
	     }
	return   $stringtemp;
	
	}///end convert to number in english
	
	
	// "jalali.php" is convertor to and from Gregorian and Jalali calendars.
	// Copyright (C) 2000  Roozbeh Pournader and Mohammad Toossi
	//
	// This program is free software; you can redistribute it and/or
	// modify it under the terms of the GNU General Public License
	// as published by the Free Software Foundation; either version 2
	// of the License, or (at your option) any later version.
	//
	// This program is distributed in the hope that it will be useful,
	// but WITHOUT ANY WARRANTY; without even the implied warranty of
	// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	// GNU General Public License for more details.
	//
	// A copy of the GNU General Public License is available from:
	//
	//    <a href="http://www.gnu.org/copyleft/gpl.html" target="_blank">http://www.gnu.org/copyleft/gpl.html</a>
	//
	
	
	function div($a,$b) {
	    return (int) ($a / $b);
	}
	
	function gregorian_to_jalali ($g_y, $g_m, $g_d)
	{
	    $g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	    $j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);
	
	
	
	
	
	   $gy = $g_y-1600;
	   $gm = $g_m-1;
	   $gd = $g_d-1;
	
	   $g_day_no = 365*$gy+JalaliCalendar::div($gy+3,4)-JalaliCalendar::div($gy+99,100)+JalaliCalendar::div($gy+399,400);
	
	   for ($i=0; $i < $gm; ++$i)
	      $g_day_no += $g_days_in_month[$i];
	   if ($gm>1 && (($gy%4==0 && $gy%100!=0) || ($gy%400==0)))
	      /* leap and after Feb */
	      $g_day_no++;
	   $g_day_no += $gd;
	
	   $j_day_no = $g_day_no-79;
	
	   $j_np = JalaliCalendar::div($j_day_no, 12053); /* 12053 = 365*33 + 32/4 */
	   $j_day_no = $j_day_no % 12053;
	
	   $jy = 979+33*$j_np+4*JalaliCalendar::div($j_day_no,1461); /* 1461 = 365*4 + 4/4 */
	
	   $j_day_no %= 1461;
	
	   if ($j_day_no >= 366) {
	      $jy += JalaliCalendar::div($j_day_no-1, 365);
	      $j_day_no = ($j_day_no-1)%365;
	   }
	
	   for ($i = 0; $i < 11 && $j_day_no >= $j_days_in_month[$i]; ++$i)
	      $j_day_no -= $j_days_in_month[$i];
	   $jm = $i+1;
	   $jd = $j_day_no+1;
	
	   return array($jy, $jm, $jd);
	}
	
	function jalali_to_gregorian($j_y, $j_m, $j_d)
	{
	    $g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	    $j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);
	
	
	
	   $jy = $j_y-979;
	   $jm = $j_m-1;
	   $jd = $j_d-1;
	
	   $j_day_no = 365*$jy + JalaliCalendar::div($jy, 33)*8 + JalaliCalendar::div($jy%33+3, 4);
	   for ($i=0; $i < $jm; ++$i)
	      $j_day_no += $j_days_in_month[$i];
	
	   $j_day_no += $jd;
	
	   $g_day_no = $j_day_no+79;
	
	   $gy = 1600 + 400*JalaliCalendar::div($g_day_no, 146097); /* 146097 = 365*400 + 400/4 - 400/100 + 400/400 */
	   $g_day_no = $g_day_no % 146097;
	
	   $leap = true;
	   if ($g_day_no >= 36525) /* 36525 = 365*100 + 100/4 */
	   {
	      $g_day_no--;
	      $gy += 100*JalaliCalendar::div($g_day_no,  36524); /* 36524 = 365*100 + 100/4 - 100/100 */
	      $g_day_no = $g_day_no % 36524;
	
	      if ($g_day_no >= 365)
	         $g_day_no++;
	      else
	         $leap = false;
	   }
	
	   $gy += 4*JalaliCalendar::div($g_day_no, 1461); /* 1461 = 365*4 + 4/4 */
	   $g_day_no %= 1461;
	
	   if ($g_day_no >= 366) {
	      $leap = false;
	
	      $g_day_no--;
	      $gy += JalaliCalendar::div($g_day_no, 365);
	      $g_day_no = $g_day_no % 365;
	   }
	
	   for ($i = 0; $g_day_no >= $g_days_in_month[$i] + ($i == 1 && $leap); $i++)
	      $g_day_no -= $g_days_in_month[$i] + ($i == 1 && $leap);
	   $gm = $i+1;
	   $gd = $g_day_no+1;
	
	   return array($gy, $gm, $gd);
	}
	
	/*
	 * Function to Convert user input time (yyyy-mm-dd hh:mm:ss) in persian to english && Hegira date to Gregorian - by irmtfan (www.jadoogaran.org)
	 */
	function inputTimeToGregorian($usertime)
	{
	
	    list( $jfdate, $ftime) = preg_split ( '/ /', $usertime );
	    list( $fhour, $fminut, $fsec ) =  preg_split ( '/:/', $ftime);
	    // convert persian numbers to english if exist
	    $hour=JalaliCalendar::Convertnumber2english($fhour);
	    $minut=JalaliCalendar::Convertnumber2english($fminut);
	    $sec=JalaliCalendar::Convertnumber2english($fsec);
	    list( $jfyear, $jfmonth, $jfday ) =  preg_split ( '/-/', $jfdate);
	    // convert persian numbers to english if exist
	    $jyear=JalaliCalendar::Convertnumber2english($jfyear);
	    $jmonth=JalaliCalendar::Convertnumber2english($jfmonth);
	    $jday=JalaliCalendar::Convertnumber2english($jfday);
	
	    if (_USE_HEGIRADATE) {
	        $maket=JalaliCalendar::jmaketime($hour - _JDF_TZhours,$minut - _JDF_TZminute,$sec,$jmonth,$jday,$jyear);
	    } else {
	        $maket=mktime($hour,$minut,$sec,$jmonth,$jday,$jyear);
	    }
	    $usertime=date("Y-m-d H:i:s",$maket);
	    return $usertime;
	}
}

?>
