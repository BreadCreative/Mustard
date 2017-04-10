<?php

namespace MABEL_BHI_LITE\Core\Linq
{
	use Exception;
	use ArrayIterator;

	class Enumerable
	{
		private $iterator;

		private function __construct (ArrayIterator $iterator)
		{
			$this->iterator = $iterator;
			$this->iterator->rewind();
		}

		public static function from ($source)
		{
			$iterator = null;

			if ($source instanceof Enumerable)
				return $source;
			if (is_array($source))
				$iterator = new ArrayIterator($source);

			if ($iterator !== null)
			{
				return new Enumerable($iterator);
			}
			throw new Exception("Invalid source for Enumerable.");
		}

		#region Query functions

		public function where ($predicate){
			$predicate = Linq_Helpers::create_lambda($predicate);

			$this->iterator->rewind();

			$keys = array();
			while ($this->iterator->valid())
			{
				if(!$predicate($this->iterator->current()))
					array_push($keys, $this->iterator->key());
				$this->iterator->next();
			}

			foreach($keys as $key){
				$this->iterator->offsetUnset($key);
			}

			return $this;
		}

		public function firstOrDefault($predicate)
		{
			$predicate = Linq_Helpers::create_lambda($predicate);

			$this->iterator->rewind();
			if(!$this->iterator->valid()) return null;

			while ($this->iterator->valid())
			{
				if($predicate($this->iterator->current()))
					return $this->iterator->current();
				$this->iterator->next();
			}

			return null;
		}

		#endregion

		#region Boolean Functions
		public function any($predicate = null)
		{
			if($predicate === null)
				return iterator_count($this->iterator) > 0;

			return $this->firstOrDefault($predicate) != null;
		}

		#endregion

		#region Integer Functions
		public function count($predicate = null)
		{
			if($predicate === null)
				return iterator_count($this->iterator);
			return iterator_count($this->where($predicate)->iterator);
		}
		#endregion

		#region String Functions

		public function join($value, $separator)
		{
			$value = Linq_Helpers::create_lambda($value);

			$this->iterator->rewind();

			$result = array();
			while ($this->iterator->valid())
			{
				array_push($result, $value($this->iterator->current()));
				$this->iterator->next();
			}

			return join($separator, $result);
		}

		#endregion

		#region Conversion Functions
		public function toArray()
		{
			$this->iterator->rewind();

			if ($this->iterator instanceof ArrayIterator)
				return $this->iterator->getArrayCopy();

			$result = array();
			foreach ($this->iterator as $k => $v) {
				$result[ $k ] = $v;
			}
			return $result;
		}
		#endregion

	}
}