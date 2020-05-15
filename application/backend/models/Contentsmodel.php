<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contentsmodel extends CI_Model {
	
    public function __construct()
    {
        parent::__construct();
    }

	function getContentCategoriesByLangCode($lang_code){
		
		$ci =& get_instance();
		
		$categories = $ci->db
						  ->from('contents_categories')
						  ->where(array('lang_code' => $lang_code))
						  ->get()
						  ->result();
		return $categories;
		
	}
	
	public function getcategoriesrecursive($parent_id = 0, $delimiter = '')
	{
		
    	$elements = $this->db->from('contents_categories')->where('parent_id', $parent_id)->where('status !=', 'D')->get()->result();
	    $branch = array();
		
		$delimiter = '-';
		
	    foreach ($elements as $element) {
	        
			$element->delimiter = $delimiter;
			if(substr($element->id_path,0,2) == '6/'){
				$element->parent_category_name = $this->db->from('contents_categories')->where('id', $element->parent_id)->where('status !=', 'D')->get()->row()->title;
			}
	        $branch[] = $element;
	        
	        if ($element->parent_id == $parent_id) {
	            $children = $this->getcategoriesrecursive($element->id, $delimiter);
	        }

            if ($children) {
                //$element->children = $children;
                foreach($children as $child){
                	$child->delimiter .= $delimiter;
                	$branch[] = $child;
                }
            }
	            	        
	    }
	
	    return $branch;
	}	

	public function total_words()
	{

			//with lessons
			$with = $this->db
				->from('contents_words')
				->like('phase1', '[keyword]', 'both')
				->or_like('phase2', '[keyword]', 'both')
				->or_like('phase3', '[keyword]', 'both')
				->or_like('phase4', '[keyword]', 'both')
				->or_like('phase5', '[keyword]', 'both')
				->or_like('phase6', '[keyword]', 'both')
				->or_like('phase7', '[keyword]', 'both')
				->or_like('phase8', '[keyword]', 'both')
				->or_like('phase9', '[keyword]', 'both')
				->or_like('phase10', '[keyword]', 'both')
				->or_like('phase11', '[keyword]', 'both')
				->or_like('phase12', '[keyword]', 'both')
				->or_like('phase13', '[keyword]', 'both')
				->or_like('phase14', '[keyword]', 'both')
				->or_like('phase15', '[keyword]', 'both')
				->or_like('phase16', '[keyword]', 'both')
				->or_like('phase17', '[keyword]', 'both')
				->or_like('phase18', '[keyword]', 'both')
				->or_like('phase19', '[keyword]', 'both')
				->or_like('phase20', '[keyword]', 'both')
				->or_like('phase21', '[keyword]', 'both')
				->or_like('phase22', '[keyword]', 'both')
				->or_like('phase23', '[keyword]', 'both')
				->or_like('phase24', '[keyword]', 'both')
				->or_like('phase25', '[keyword]', 'both')
				->count_all_results();
	
			
			//without lessons
			$without = $this->db
				->from('contents_words')
				->not_like('phase1', '[keyword]', 'both')
				->not_like('phase2', '[keyword]', 'both')
				->not_like('phase3', '[keyword]', 'both')
				->not_like('phase4', '[keyword]', 'both')
				->not_like('phase5', '[keyword]', 'both')
				->not_like('phase6', '[keyword]', 'both')
				->not_like('phase7', '[keyword]', 'both')
				->not_like('phase8', '[keyword]', 'both')
				->not_like('phase9', '[keyword]', 'both')
				->not_like('phase10', '[keyword]', 'both')
				->not_like('phase11', '[keyword]', 'both')
				->not_like('phase12', '[keyword]', 'both')
				->not_like('phase13', '[keyword]', 'both')
				->not_like('phase14', '[keyword]', 'both')
				->not_like('phase15', '[keyword]', 'both')
				->not_like('phase16', '[keyword]', 'both')
				->not_like('phase17', '[keyword]', 'both')
				->not_like('phase18', '[keyword]', 'both')
				->not_like('phase19', '[keyword]', 'both')
				->not_like('phase20', '[keyword]', 'both')
				->not_like('phase21', '[keyword]', 'both')
				->not_like('phase22', '[keyword]', 'both')
				->not_like('phase23', '[keyword]', 'both')
				->not_like('phase24', '[keyword]', 'both')
				->not_like('phase25', '[keyword]', 'both')
				->count_all_results();
		
		return array($with, $without);
	}
		
	public function generate($keyword = NULL, $url = NULL, $type = array())
	{
		
		if(empty($type)){
			$type[0] = rand(3,4);
			$type[1] = rand(6,8);
		}
		
		$ids = array();
		$words = array();
		
		if(!empty($keyword))
		{
			//with lessons
			$lessons = $this->db
				->select('id')
				->from('contents_words')
				->like('phase1', '[keyword]', 'both')
				->or_like('phase2', '[keyword]', 'both')
				->or_like('phase3', '[keyword]', 'both')
				->or_like('phase4', '[keyword]', 'both')
				->or_like('phase5', '[keyword]', 'both')
				->or_like('phase6', '[keyword]', 'both')
				->or_like('phase7', '[keyword]', 'both')
				->or_like('phase8', '[keyword]', 'both')
				->or_like('phase9', '[keyword]', 'both')
				->or_like('phase10', '[keyword]', 'both')
				->or_like('phase11', '[keyword]', 'both')
				->or_like('phase12', '[keyword]', 'both')
				->or_like('phase13', '[keyword]', 'both')
				->or_like('phase14', '[keyword]', 'both')
				->or_like('phase15', '[keyword]', 'both')
				->or_like('phase16', '[keyword]', 'both')
				->or_like('phase17', '[keyword]', 'both')
				->or_like('phase18', '[keyword]', 'both')
				->or_like('phase19', '[keyword]', 'both')
				->or_like('phase20', '[keyword]', 'both')
				->or_like('phase21', '[keyword]', 'both')
				->or_like('phase22', '[keyword]', 'both')
				->or_like('phase23', '[keyword]', 'both')
				->or_like('phase24', '[keyword]', 'both')
				->or_like('phase25', '[keyword]', 'both')
				->limit($type[0])
				->order_by('id', 'RANDOM')
				->get()->result();
			foreach($lessons as $lesson){
				$ids[] = $lesson->id;
			}
			
			//without lessons
			$lessons = $this->db
				->select('id')
				->from('contents_words')
				->not_like('phase1', '[keyword]', 'both')
				->not_like('phase2', '[keyword]', 'both')
				->not_like('phase3', '[keyword]', 'both')
				->not_like('phase4', '[keyword]', 'both')
				->not_like('phase5', '[keyword]', 'both')
				->not_like('phase6', '[keyword]', 'both')
				->not_like('phase7', '[keyword]', 'both')
				->not_like('phase8', '[keyword]', 'both')
				->not_like('phase9', '[keyword]', 'both')
				->not_like('phase10', '[keyword]', 'both')
				->not_like('phase11', '[keyword]', 'both')
				->not_like('phase12', '[keyword]', 'both')
				->not_like('phase13', '[keyword]', 'both')
				->not_like('phase14', '[keyword]', 'both')
				->not_like('phase15', '[keyword]', 'both')
				->not_like('phase16', '[keyword]', 'both')
				->not_like('phase17', '[keyword]', 'both')
				->not_like('phase18', '[keyword]', 'both')
				->not_like('phase19', '[keyword]', 'both')
				->not_like('phase20', '[keyword]', 'both')
				->not_like('phase21', '[keyword]', 'both')
				->not_like('phase22', '[keyword]', 'both')
				->not_like('phase23', '[keyword]', 'both')
				->not_like('phase24', '[keyword]', 'both')
				->not_like('phase25', '[keyword]', 'both')
				->limit($type[1])
				->order_by('id', 'RANDOM')
				->get()->result();
			foreach($lessons as $lesson){
				$ids[] = $lesson->id;
			}	
		}
		
		if(!empty($ids)){
			shuffle($ids);
			$words[] = '<p>';
			foreach($ids as $key => $id){
				if($key == $type[0]){
					$words[] = '</p><p>';
				}
				$words[] = $this->_make_word($id, $keyword, $url);
			}
			$words[] = '</p>';
		}
		return implode(' ', $words);
	}

	public function word_test($keyword = NULL, $id = NULL)
	{
		if(empty($id)) return false;
		
		$word = $this->db->from('contents_words')->where('id', $id)->get()->row();
		if(!empty($word))
		{
			$w = array();
			for($i=1;$i<=25;$i++)
			{
				$phase = 'phase'.$i;
				if(!empty($word->$phase))
				{
					$phases = explode(PHP_EOL, $word->$phase);
					$k = array_rand($phases);
					$w[] = trim($phases[$k]);
				}
			}
			
			$final = implode(' ', $w);

			$final = str_replace('[keyword]', "<strong>".txtWordUpper($keyword)." Özel Ders</strong>", $final);
						
			$final = str_replace('  ', ' ', $final);
			$final = str_replace(' , ', ', ', $final);
			
			return $final;
		}
	}	
		
	public function _make_word($id = NULL, $keyword = NULL, $url = NULL)
	{
		if(empty($id)) return false;
		
		$word = $this->db->from('contents_words')->where('id', $id)->get()->row();
		if(!empty($word))
		{
			$w = array();
			for($i=1;$i<=25;$i++)
			{
				$phase = 'phase'.$i;
				if(!empty($word->$phase))
				{
					$phases = explode(PHP_EOL, $word->$phase);
					$k = array_rand($phases);
					$w[] = trim($phases[$k]);
				}
			}
			
			$final = implode(' ', $w);

			if(empty($url)){
				$final = str_replace('[keyword]', "<strong>".txtWordUpper($keyword)." Özel Ders</strong>", $final);
			} else {
				$final = str_replace('[keyword]', "<strong><a href=\"$url\" target=\"_blank\">".txtWordUpper($keyword)." Özel Ders</a></strong>", $final);
			}
						
			$final = str_replace('  ', ' ', $final);
			$final = str_replace(' , ', ', ', $final);
			
			return $final;
		}
	}	
}
?>