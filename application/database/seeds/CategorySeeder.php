<?php

class CategorySeeder extends Seeder {

	private $table = 'category';
	
	public function run()
	{
		$this->db->truncate($this->table);

		$data = [
			'id' => 1,
			'name' => '本',
		];
		$this->db->insert($this->table, $data);
		
		$data = [
			'id' => 2,
			'name' => 'CD',
		];
		$this->db->insert($this->table, $data);
		
		$data = [
			'id' => 3,
			'name' => 'DVD',
		];
		$this->db->insert($this->table, $data);
	}

}
