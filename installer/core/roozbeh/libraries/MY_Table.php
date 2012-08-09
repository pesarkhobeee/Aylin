<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Table extends CI_Table {

	/**
	 * Set the table heading
	 *
	 * Can be passed as an array or discreet params
	 *
	 * @access	public
	 * @param	mixed
	 * @return	void
	 */
	function set_heading()
	{
		$args = func_get_args();
		$this->heading = (is_array($args[0]) && array_key_exists('content',$args[0])) ? $args : $args[0];
	}

	// --------------------------------------------------------------------
	
	/**
	 * Add a table row
	 *
	 * Can be passed as an array or discreet params
	 *
	 * @access	public
	 * @param	mixed
	 * @return	void
	 */
	function add_row()
	{
		$args = func_get_args();
		$this->rows[] = (is_array($args[0]) && array_key_exists('content',$args[0])) ? $args : $args[0];
	}

	// --------------------------------------------------------------------

	/**
	 * Generate the table
	 *
	 * @access	public
	 * @param	mixed
	 * @return	string
	 */
	function generate($table_data = NULL)
	{
		// The table data can optionally be passed to this function
		// either as a database result object or an array
		if ( ! is_null($table_data))
		{
			if (is_object($table_data))
			{
				$this->_set_from_object($table_data);
			}
			elseif (is_array($table_data))
			{
				$set_heading = (count($this->heading) == 0 AND $this->auto_heading == FALSE) ? FALSE : TRUE;
				$this->_set_from_array($table_data, $set_heading);
			}
		}

		// Is there anything to display?  No?  Smite them!
		if (count($this->heading) == 0 AND count($this->rows) == 0)
		{
			return 'Undefined table data';
		}

		// Compile and validate the template date
		$this->_compile_template();


		// Build the table!

		$out = $this->template['table_open'];
		$out .= $this->newline;

		// Add any caption here
		if ($this->caption)
		{
			$out .= $this->newline;
			$out .= '<caption>' . $this->caption . '</caption>';
			$out .= $this->newline;
		}

		// Is there a table heading to display?
		if (count($this->heading) > 0)
		{
			$out .= $this->template['heading_row_start'];
			$out .= $this->newline;

			foreach($this->heading as $heading)
			{
				$properties = substr($this->template['heading_cell_start'],0,-1);
				
				if(array_key_exists('attributes', $heading))
						$properties .= ' '.$heading['attributes'].' ';
				
				$keys = array_keys ($heading);
				foreach($keys as $key){
					if($key == 'content')
						continue;

					if($key == 'attributes')
						continue;
					$properties .= ' '.$key.'="'.$heading[$key].'"';
				}
				
				$out .= $properties.'>';

				if ($heading['content'] === "")
				{
					$out .= $this->empty_cells;
				}
				else
				{
					$out .= $heading['content'];
				}

				$out .= $this->template['heading_cell_end'];
			}

			$out .= $this->template['heading_row_end'];
			$out .= $this->newline;
		}

		// Build the table rows
		if (count($this->rows) > 0)
		{
			$i = 1;
			foreach($this->rows as $row)
			{
				if ( ! is_array($row))
				{
					break;
				}

				// We use modulus to alternate the row colors
				$name = (fmod($i++, 2)) ? '' : 'alt_';

				$out .= $this->template['row_'.$name.'start'];
				$out .= $this->newline;

				foreach($row as $cell)
				{						
					$properties = substr($this->template['cell_'.$name.'start'],0,-1);
					
					if(array_key_exists('attributes', $cell))
						$properties .= ' '.$cell['attributes'].' ';

					$keys = array_keys ($cell);
					foreach($keys as $key){
						if($key == 'content')
							continue;
						
						if($key == 'attributes')
							continue;

						$properties .= ' '.$key.'="'.$cell[$key].'"';
					}
					$out .= $properties.'>';

					if ($cell['content'] === "")
					{
						$out .= $this->empty_cells;
					}
					else
					{
						$out .= $cell['content'];
					}

					$out .= $this->template['cell_'.$name.'end'];
				}

				$out .= $this->template['row_'.$name.'end'];
				$out .= $this->newline;
			}
		}

		$out .= $this->template['table_close'];

		return $out;
	}

}

// END MY_Table class

/* End of file MY_Table.php */
/* Location: ./system/application/libraries/MY_Table.php */
