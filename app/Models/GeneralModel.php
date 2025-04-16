<?php
namespace App\Models;
use CodeIgniter\Model;
	class GeneralModel extends Model {

		function __construct()
		{

			parent::__construct();
			// $db      = \Config\Database::connect();
			// $session = \Config\Services::session();
		}

        /** Fetch data **/
		function fetch_data($table,$condition=null,$orderby=null,$select=null){

			if($condition){

				$query = $this->db->table($table);
				if(!empty($select)){
					$query->select($select); // specify the columns to select
				}
				$query->where($condition);
				if($orderby){ $query->orderBy($orderby); }
				$result = $query->get()->getResult();		

			}
			else{

				$query = $this->db->table($table);
				if(!empty($select)){
					$query->select($select); // specify the columns to select
				}
				if($orderby){ $query->orderBy($orderby); }
				$result = $query->get()->getResult();

			}
			return $result;	
		}

		/** Fetch data **/

        function delete_condition($table,$condition)
		{	
			$builder = $this->db->table($table);
			$builder->where($condition);
			$builder->delete();
			return "1";		
		}


		
    }


		

	
