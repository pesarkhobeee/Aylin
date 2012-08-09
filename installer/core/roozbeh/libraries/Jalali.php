<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* This file is part of:
 *    Jalali, a Gregorian to Jalali and inverse date convertor
 * Copyright (C) 2001  Roozbeh Pournader <roozbeh@sharif.edu>
 * Copyright (C) 2001  Mohammad Toossi <mohammad@bamdad.org>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You can receive a copy of GNU Lesser General Public License at the
 * World Wide Web address <http://www.gnu.org/licenses/lgpl.html>.
 *
 * For licensing issues, contact The FarsiWeb Project Group,
 * Computing Center, Sharif University of Technology,
 * PO Box 11365-8515, Tehran, Iran, or contact us the
 * email address <FWPG@sharif.edu>.
 */

/* Changes:
 *
 * 2009-Mar-20:
 *	Add several helper functions --Mohammad Sadegh At'hari
 *
 * 2005-Sep-06:
 *      General cleanup  --Behdad Esfahbod
 *
 * 2001-Sep-21:
 *	Fixed a bug with "30 Esfand" dates, reported by Mahmoud Ghandi
 *
 * 2001-Sep-20:
 *	First LGPL release, with both sides of conversions
 */

class Jalali {

	private $jdate = array();
	private $gdate = array();
	
	private $g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    private $j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);
	
	private $date = '';
	
	var $jsep = '-';
	var $gsep = '-';
	var $tsep = ':';
	
	function Jalali()
	{		
		$this->set_date_now();
	}

	private function div($a,$b) {
		return (int) ($a / $b);
	}
	/***************************************************************/
	function gregorian_to_jalali($g_y, $g_m, $g_d)
	{
	   $gy = $g_y-1600;
	   $gm = $g_m-1;
	   $gd = $g_d-1;

	   $g_day_no = 365*$gy+$this->div($gy+3,4)-$this->div($gy+99,100)+$this->div($gy+399,400);

	   for ($i=0; $i < $gm; ++$i)
		  $g_day_no += $this->g_days_in_month[$i];
	   if ($gm>1 && (($gy%4==0 && $gy%100!=0) || ($gy%400==0)))
		  /* leap and after Feb */
		  ++$g_day_no;
	   $g_day_no += $gd;

	   $j_day_no = $g_day_no-79;

	   $j_np = $this->div($j_day_no, 12053); /* 12053 = 365*33 + 32/4 */
	   $j_day_no = $j_day_no % 12053;

	   $jy = 979+33*$j_np+4*$this->div($j_day_no,1461); /* 1461 = 365*4 + 4/4 */

	   $j_day_no %= 1461;

	   if ($j_day_no >= 366) {
		  $jy += $this->div($j_day_no-1, 365);
		  $j_day_no = ($j_day_no-1)%365;
	   }

	   for ($i = 0; $i < 11 && $j_day_no >= $this->j_days_in_month[$i]; ++$i)
		  $j_day_no -= $this->j_days_in_month[$i];
	   $jm = $i+1;
	   $jd = $j_day_no+1;

	   return array($jy, $jm, $jd);
	}
	/***************************************************************/
	function jalali_to_gregorian($j_y, $j_m, $j_d)
	{
	   $jy = $j_y-979;
	   $jm = $j_m-1;
	   $jd = $j_d-1;

	   $j_day_no = 365*$jy + $this->div($jy, 33)*8 + $this->div($jy%33+3, 4);

	   for ($i=0; $i < $jm; ++$i)
		  $j_day_no += $this->j_days_in_month[$i];

	   $j_day_no += $jd;

	   $g_day_no = $j_day_no+79;

	   $gy = 1600 + 400 * $this->div($g_day_no, 146097); /* 146097 = 365*400 + 400/4 - 400/100 + 400/400 */
	   $g_day_no = $g_day_no % 146097;

	   $leap = true;
	   if ($g_day_no >= 36525) /* 36525 = 365*100 + 100/4 */
	   {
		  $g_day_no--;
		  $gy += 100*$this->div($g_day_no,  36524); /* 36524 = 365*100 + 100/4 - 100/100 */
		  $g_day_no = $g_day_no % 36524;

		  if ($g_day_no >= 365)
		     $g_day_no++;
		  else
		     $leap = false;
	   }

	   $gy += 4*$this->div($g_day_no, 1461); /* 1461 = 365*4 + 4/4 */
	   $g_day_no %= 1461;

	   if ($g_day_no >= 366) {
		  $leap = false;

		  $g_day_no--;
		  $gy += $this->div($g_day_no, 365);
		  $g_day_no = $g_day_no % 365;
	   }

	   for ($i = 0; $g_day_no >= $this->g_days_in_month[$i] + ($i == 1 && $leap); $i++)
          $g_day_no -= $this->g_days_in_month[$i] + ($i == 1 && $leap);
	   $gm = $i+1;
	   $gd = $g_day_no+1;

	   return array($gy, $gm, $gd);
	}
	/***************************************************************/
	private function jalali_update()
	{
		$this->jdate = $this->gregorian_to_jalali($this->gdate[0], $this->gdate[1], $this->gdate[2]);

	}
	/***************************************************************/
	private function gregorian_update()
	{
		$this->gdate = $this->jalali_to_gregorian($this->jdate[0], $this->jdate[1], $this->jdate[2]);
	}
	/***************************************************************/
	function is_jalali_valid($j_y, $j_m, $j_d)
	{
		list($gy, $gm, $gd) = $this->jalali_to_gregorian($j_y, $j_m, $j_d);
		list($jy, $jm, $jd) = $this->gregorian_to_jalali($gy, $gm, $gd);

		if($jy == $j_y &&
		   $jm == $j_m &&
		   $jd == $j_d)
			return true;
		else
			return false;
	}
	/***************************************************************/
	function is_gregorian_valid($g_y, $g_m, $g_d)
	{
		list($jy, $jm, $jd) = $this->gregorian_to_jalali($g_y, $g_m, $g_d);
		list($gy, $gm, $gd) = $this->jalali_to_gregorian($jy, $jm, $jd);


		if($gy == $g_y &&
		   $gm == $g_m &&
		   $gd == $g_d)
			return true;
		else
			return false;
	}
	/***************************************************************/
	function is_jalali_leap_year($j_y)
	{
		return $this->is_jalali_valid($j_y, 12, 30);
	}
	/***************************************************************/
	function set_date_now()
	{
		$this->set_gregorian_dmy(date('Y'), date('m'), date('d'));
	}
	/***************************************************************/
	function set_jalali_dmy($j_y, $j_m, $j_d)
	{
		if($this->is_jalali_valid($j_y, $j_m, $j_d))
		{
			$this->jdate[0] = $j_y;
			$this->jdate[1] = $j_m;
			$this->jdate[2] = $j_d;

			$this->gregorian_update();
			return true;
		}
		else
			return false;
	}
	/***************************************************************/
	function set_gregorian_dmy($g_y, $g_m, $g_d)
	{
		if($this->is_gregorian_valid($g_y, $g_m, $g_d))
		{
			$this->gdate[0] = $g_y;
			$this->gdate[1] = $g_m;
			$this->gdate[2] = $g_d;

			$this->jalali_update();
			return true;
		}
		else
			return false;

	}
	/***************************************************************/
	function jalali_parse($str)
	{
		$l = strlen($str);

		if($l == 8){
			$year = substr($str,0,4);
			$month = substr($str,-4,-2);
			$day = substr($str,6);

			if($year<0 || $month<0 || $day<0)
				return false;
			else
				return $this->set_jalali_dmy($year, $month, $day);
		}

		if($l == 10)
		{
			$year = substr($str,0,4);
			$month = substr($str,-5,-3);
			$day = substr($str,8);

			if($year<0 || $month<0 || $day<0)
				return false;
			else
				return $this->set_jalali_dmy($year, $month, $day);
		}
		return false;
	}
	/***************************************************************/
	function gregorian_parse($str)
	{
		if($str == '0000-00-00 00:00:00' || $str == '0000-00-00')
			return false;
		
		$this->date = $str;

		return $this->set_gregorian_dmy(date('Y',strtotime($str)),
										date('m',strtotime($str)),
										date('d',strtotime($str)));
	}
	/***************************************************************/
	function get_jalali_date($sep=NULL)
	{
		$sep = ($sep) ? $sep : $this->jsep;
		return sprintf('%s%s%02s%s%02s',$this->jdate[0],$sep,
										$this->jdate[1],$sep,
										$this->jdate[2]);
	}
	/***************************************************************/
	function get_gregorian_date($sep=NULL)
	{
		$sep = ($sep) ? $sep : $this->gsep;
		return sprintf('%s%s%02s%s%02s',$this->gdate[0],$sep,
										$this->gdate[1],$sep,
										$this->gdate[2]);
	}
	/***************************************************************/
	function convert_to_jalali($str,$sep=NULL)
	{
		if(!$this->gregorian_parse($str))
			return '';
		else
			return $this->get_jalali_date($sep);
	}
	/***************************************************************/
	function convert_to_gregorian($str,$sep=NULL)
	{
		if(!$this->jalali_parse($str))
			return '';
		else
			return $this->get_gregorian_date($sep);
	}
	/***************************************************************/
	function get_jalali_month_name()
	{
		$j_month_name = array("",
							/*Bahar*/   "فروردین", "اردیبهشت", "خرداد",
							/*Tabestan*/"تیر", "مرداد", "شهریور",
							/*Paeiz*/   "مهر", "آبان", "آذر",
							/*Zemestan*/"دی", "بهمن", "اسفند");
							
		return $j_month_name[$this->jdate[1]];
	}
	/***************************************************************/
	function get_jalali_weekday()
	{
		$j_weekday = array('یک شنبه','دوشنبه','سه شنبه','چهارشنبه','پنج شنبه','جمعه','شنبه');
		
		$date = $this->get_gregorian_date('/');
		return $j_weekday[date('w',strtotime($date))];
	}
	
	/***************************************************************/
	function get_jalali_full_date_time($str='', $dsep=NULL, $tsep=NULL)
	{
		$str = ($str != '') ? $str : date('h:i:s , Y-m-d');
		$tsep = ($tsep) ? $tsep : $this->tsep;
		
		$result =  date('H'.$tsep.'i', strtotime($str)).' '.
				$this->convert_to_jalali($str,$dsep).' '.
				$this->get_jalali_weekday();
		
		return $result;
	}
	/***************************************************************/
	function get_jalali_day()
	{
		return $this->jdate[2];
	}
	/***************************************************************/
	function get_jalali_mon()
	{
		return $this->jdate[1];
	}
	/***************************************************************/
	function get_jalali_year()
	{
		return $this->jdate[0];
	}
	/***************************************************************/
	function get_gregorian_day()
	{
		return $this->gdate[2];
	}
	/***************************************************************/
	function get_gregorian_mon()
	{
		return $this->gdate[1];
	}
	/***************************************************************/
	function get_gregorian_year()
	{
		return $this->gdate[0];
	}

}

/* End of file Jalali.php */
/* Location: ./system/application/libraries/Jalali.php */
