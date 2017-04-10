<?php

namespace MABEL_BHI_LITE\Core\Models
{

	class Text_Option extends Option
	{

		public $placeholder;

		public $value;

		public function __construct( $id, $title, $value = null, $placeholder = null, $extra_info = null, Option_Dependency $dependency = null )
		{
			parent::__construct( $id, $value, $title, $extra_info, $dependency );

			$this->placeholder = $placeholder;

					}



	}

}