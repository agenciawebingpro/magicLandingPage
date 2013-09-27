<?php
	final class Loader {
		protected $registry;
		protected $file;
		public function __construct($registry){
			$this->registry = $registry;
		}
		public function library($library){
			$file = path_library."/".$library.".php";
			
			if (is_file($file)) {
				require_once($file);
			} else {
				return false;
			}
		}
		public function model($model,$alias=false,$params=false){
			if(!$alias){
				$alias = "M".$model;
			}
			$file = path_models."/".$model.".php";
			if($params) {
				if(!is_array($params)){
					$params = array($params);
				}
			} else {
				$params = array();
			}
		

			if (is_file($file)) {
				
				require_once($file);
				$class = preg_replace('/[^a-zA-Z0-9]/', '', $model);
				$reflection_class = new ReflectionClass($class);
				$obj = $reflection_class->newInstanceArgs($params);
				$this->registry->set($alias,$obj);

			}

		}
	}