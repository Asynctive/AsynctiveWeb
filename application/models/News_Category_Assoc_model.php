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
	
	/**
	 * Deletes a set of rows
	 * @param arram
	 * @return int
	 */
	public function removeByArticleAndCategoryIds($article_id, $category_ids)
	{
		$this->db->where_in('category_id', $category_ids);
		$this->db->where('article_id', $article_id);
		$this->db->delete(TABLE_NEWS_CATEGORY_ASSOC);
		return $this->db->affected_rows();
	}
	
	/**
	 * Gets associations by article id
	 * @param int
	 * @return array
	 */
	public function getByArticleId($article_id)
	{
		$query = $this->db->get_where(TABLE_NEWS_CATEGORY_ASSOC, array('article_id' => $article_id));
		return $query->result();
	}
}
