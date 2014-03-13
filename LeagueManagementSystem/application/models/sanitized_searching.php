<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sanitized_Searching extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function sanitize($search_query, $user_search)
	{
	//	$search_query = "SELECT * FROM riskyjobs";

    // Extract the search keywords into an array
    $clean_search = str_replace(',', ' ', $user_search);
    $search_words = explode(' ', $clean_search);
    $final_search_words = array();
    if (count($search_words) > 0) {
      foreach ($search_words as $word) {
        if (!empty($word)) {
          $final_search_words[] = $word;
        }
      }
    }

    // Generate a WHERE clause using all of the search keywords
    $where_list = array();
    if (count($final_search_words) > 0) 
	{
      foreach($final_search_words as $word) 
	  {
        $where_list[] = "description LIKE '%$word%'";
      }
    }
    $where_clause = implode(' OR ', $where_list);

    // Add the keyword WHERE clause to the search query
    if (!empty($where_clause)) 
	{
      $search_query .= " WHERE $where_clause";
    }

    return $search_query;
	}
}
