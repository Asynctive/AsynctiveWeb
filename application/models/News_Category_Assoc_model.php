<?php
/**
 * Asynctive Web News Category Association Model
 * @author Andy Deveaux
 */
class News_Category_Assoc_model extends CI_Model
{
	/**
	 * Inserts a batch of category associations
	 * @param array
	 */
	public function insertBatch($data)
	{
		$this->db->insert_batch(TABLE_NEWS_CATEGORY_ASSOC, $data);
	}
}
