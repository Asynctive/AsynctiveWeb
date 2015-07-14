<?php
/**
 * Asynctive Web Search Helper
 * @author Andy Deveaux
 */
 
 /**
  * Searches for a search prefix and returns the value for it
  * Also removes it from the search string
  * @param &string
  * @param string
  * @return string
  */
function getSearchPrefixValue(&$search_str, $prefix)
{
	$value = '';
	$prefix_length = strlen($prefix);
	$find_pos = stripos($search_str, $prefix);	
	if ($find_pos !== FALSE)
	{
		$end_pos = strpos($search_str, ' ', $find_pos);
		if ($end_pos === FALSE)
			$end_pos = strlen($search_str);
		
		$value = substr($search_str, $find_pos + $prefix_length, $end_pos - $find_pos - $prefix_length);
		$search_str = str_replace($prefix . $value, '', $search_str);
	}
	return $value;
}
