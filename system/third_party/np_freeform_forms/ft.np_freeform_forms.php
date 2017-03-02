<?php if ( ! defined('EXT')) exit('Invalid file request');

// Get config file
require(PATH_THIRD.'np_freeform_forms/config.php');


/**
* Freeform Forms Fieldtype
*
* @package		np-freeform-forms
* @version		1.0
* @author		Nathan Pitman ~ <hello@nathanpitman.com>
* @copyright	Copyright 2015, Nathan Pitman
*/
class Np_freeform_forms_ft extends EE_Fieldtype {

	/**
	* Info array
	*
	* @var	array
	*/
	var $info = array(
		'name'		=> NP_FFT_NAME,
		'version'	=> NP_FFT_VERSION
	);
	static $composer_forms_only = TRUE;

	// --------------------------------------------------------------------

	/**
	* PHP4 Constructor
	*
	* @see	__construct()
	*/
	function np_freeform_forms_ft()
	{
		$this->__construct();
	}

	// --------------------------------------------------------------------

	/**
	* PHP5 Constructor
	*
	* @return	void
	*/
	function __construct()
	{
		parent::__construct();
	}

	// --------------------------------------------------------------------

	/**
	* Displays the field in publish form
	*
	* @param	string
	* @param	bool
	* @return	string
	*/
	function display_field($data, $cell = FALSE)
	{
		// Load helper
		$this->EE->load->helper('form');

		// Build SQL query
		$sql = "SELECT form_name AS name, form_label AS label FROM exp_freeform_forms";
		
		// Filter composer forms
		if ($composer_forms_only) {
			$sql .= " WHERE composer_id != 0";
		}
		
		// Order by
		$sql .= " ORDER BY form_label ASC";
		
		// Get data from DB
		$query = $this->EE->db->query($sql);

		// Generate drop down
		$options = array('' => 'Please Select...');
		foreach ($query->result_array() AS $row)
		{
			$options[$row['name']] = $row['label'];
		}

		// Field name depending on Matrix cell or not
		$field_name = $cell ? $this->cell_name : $this->field_name;

		return form_dropdown($field_name, $options, $data);
	}

	// --------------------------------------------------------------------

	/**
	* Displays the field in matrix
	*
	* @param	string
	* @return	string
	*/
	function display_cell($cell_data)
	{
		return $this->display_field($cell_data, TRUE);
	}

	// --------------------------------------------------------------------

	/**
	* Displays the field in Low Variables
	*
	* @param	string
	* @return	string
	*/
	function display_var_field($var_data)
	{
		return $this->display_field($var_data);
	}

	// --------------------------------------------------------------------

}

/* End of file ft.np_freeform_forms_ft.php */
