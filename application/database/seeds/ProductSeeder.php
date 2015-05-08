<?php

class ProductSeeder extends Seeder {

	public function run()
	{
		$this->db->truncate('product');

		$data = [
			'category_id' => 1,
			'name'   => 'CodeIgniter徹底入門',
			'detail' => '日本初のCodeIgniter解説書。CodeIgniterのインストールや運用法、開発の基礎知識を紹介するとともに、主なライブラリの使い方や活用法、応用テクニックなどを具体的なサンプルプログラムを交えて徹底的に解説している。PHPフレームワーク導入を検討しているWeb開発者、また、他のPHPフレームワークが難しいと感じているユーザーにお勧めの1冊。',
			'price'  => 3800,
		];
		$this->db->insert('product', $data);

		$data = [
			'category_id' => 2,
			'name'   => 'CodeIgniter徹底入門 CD',
			'detail' => 'CodeIgniter徹底入門 CD',
			'price'  => 3800,
		];
		$this->db->insert('product', $data);

		$data = [
			'category_id' => 3,
			'name'   => 'CodeIgniter徹底入門 DVD',
			'detail' => 'CodeIgniter徹底入門 DVD',
			'price'  => 3800,
		];
		$this->db->insert('product', $data);

		$faker = Faker\Factory::create('ja_JP');
		for ($i = 0; $i < 100; $i++) {
			$data = [
				'category_id' => rand(1, 3),
				'name'   => $faker->country,
				'detail' => $faker->text,
				'price'  => $faker->numberBetween(1000, 5000),
			];

			$this->db->insert('product', $data);
		}
	}

}
