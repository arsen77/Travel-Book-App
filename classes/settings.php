<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

if (!class_exists('TB_Settings')) {

class TB_Settings {

	private $optionsName = 'tb_app_options';
	private $data = array();
	private $fields = array(
		'sedan_min_fare' => '',
		'sedan_first_km' => '',
		'sedan_next_49' => '',
		'sedan_after_50' => '',
		'van_min_fare' => '',
		'van_first_km' => '',
		'van_next_49' => '',
		'van_after_50' => '',
		'peak_time' => '',
		'off_peak_time' => '',
		'night_time' => '',
		'start_date_1' => '',
		'end_date_1' => '',
		'surcharge_1' => '',
		'start_date_2' => '',
		'end_date_2' => '',
		'surcharge_2' => '',
		'start_date_3' => '',
		'end_date_3' => '',
		'surcharge_3' => '',
		'start_date_4' => '',
		'end_date_4' => '',
		'surcharge_4' => '',
		'start_date_5' => '',
		'end_date_5' => '',
		'surcharge_5' => '',
		'baby_seat' => '',
		'airport_pickup' => '',
		'admin_email' => '',
	);

    public function __construct($data = array()) {
    	if ($data) {
    		$this->data = $data;
    	}
    }

    public static function field($field) {
    	$settings = new TB_Settings();
    	
    	if (!in_array($field, array_keys($settings->fields))) {
    		return 'Not a valid field';
    	}
    	else {
    		$options = $settings->get();
    		return $options[$field];
    	}
    }

    public function get() {
    	return unserialize(get_option($this->optionsName));
    }

    public function save() {
    	if (!$this->data) {
    		return;
    	}
    	if ($this->get()) {
    		$this->update();
    		return;
    	}
		foreach ($this->data as $field => $value) {
			if (!in_array($field, array_keys($this->fields))) {
				continue;
			}
			$this->fields[$field] = $value;
		}
		update_option($this->optionsName, serialize($this->fields));
    }

    public function update() {
    	$options = $this->get();
    	foreach ($this->data as $field => $value) {
			if (!in_array($field, array_keys($this->fields)) || $value == $options[$field]) {
				continue;
			}
			$options[$field] = $value;
		}
		update_option($this->optionsName, serialize($options));
    }
}

} // class_exists check