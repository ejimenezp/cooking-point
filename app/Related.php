<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Related extends Model
{

	protected $table = "related";
	
	public function __construct( $post_a = null, $post_b = null, array $attributes = array() )
	{
	    $this->post_a = $post_a;
	    $this->post_b = $post_b;

	    parent::__construct($attributes);
	}
}
