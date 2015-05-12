<?php
/**
 * Migration: Create_bbs
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/05/12 06:00:24
 */
class Migration_Create_bbs extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'auto_increment' => TRUE
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '64',
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => '64',
				'null' => TRUE,
			),
			'subject' => array(
				'type' => 'VARCHAR',
				'constraint' => '128',
				'null' => TRUE,
			),
			'body' => array(
				'type' => 'TEXT',
				'null' => TRUE,
			),
			'password' => array(
				'type' => 'VARCHAR',
				'constraint' => '32',
				'null' => TRUE,
			),
			'ip_address' => array(
				'type' => 'VARCHAR',
				'constraint' => '39',
				'null' => TRUE,
			),
		));
		$this->dbforge->add_field(
			'`datetime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
		);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('bbs');
	}

	public function down()
	{
		$this->dbforge->drop_table('bbs');
	}

}
