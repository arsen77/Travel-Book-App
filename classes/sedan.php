<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

if (!class_exists('TB_Sedan')) {

class TB_Sedan extends TB_Calculator {

    public function calculate($distance, $pickupDate, $type, $babySeats) {
    	$this->pickupDate = $pickupDate;

    	$firstKm = $this->options['sedan_first_km'];
    	$next49 = $distance > 1 ? ($distance - 1 > 49 ? 49 * $this->options['sedan_next_49'] : ($distance - 1) * $this->options['sedan_next_49']) : 0;
    	$after50 = max((($distance - 50) * $this->options['sedan_after_50']), 0);

    	$additionalCost = ($this->options['baby_seat'] * $babySeats) + $this->options['airport_pickup'];
    	$finalFare = $firstKm + $next49 + $after50 + $additionalCost;
    	
    	if ($this->isSpecialDay()) {
    		$finalFare = ($finalFare * ($this->specialDaySurcharge / 100)) + $finalFare;
    	}
    	elseif ($this->isPeakTime()) {
    		$finalFare = ($finalFare * ($this->peakTimeSurcharge / 100)) + $finalFare;
    	}
    	elseif ($this->isOffPeakTime()) {
    		$finalFare = $finalFare - ($finalFare * ($this->offPeakTimeDiscount / 100));
    	}
    	elseif ($this->isNightTime()) {
    		$finalFare = ($finalFare * ($this->nightTimeSurcharge / 100)) + $finalFare;
    	}

        return max($this->roundOff($finalFare), $this->options['sedan_min_fare']);
    }
}

} // class_exists check