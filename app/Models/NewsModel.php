<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'protokolle';
	
	public function getNews($slug = false)
	{
		if ($slug === false)
		{
			return $this->findAll();
			//return var_dump($this);
		}

		return $this->asArray()
					->where(['slug' => $slug])
					->first();
	}
}