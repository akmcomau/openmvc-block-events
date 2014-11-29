<?php

namespace modules\block_events;

use ErrorException;
use core\classes\Config;
use core\classes\Database;
use core\classes\Language;
use core\classes\Model;
use core\classes\Menu;

class Installer {
	protected $config;
	protected $database;

	public function __construct(Config $config, Database $database) {
		$this->config = $config;
		$this->database = $database;
	}

	public function install() {
		$model = new Model($this->config, $this->database);

		// create block_event database table
		$block_event = $model->getModel('\\modules\\block_events\\classes\\models\\BlockEvent');
		$block_event->sqlHelper()->createTable();
		$block_event->sqlHelper()->createIndexes();
		$block_event->sqlHelper()->createForeignKeys();

		// add the Event block_type
		$block_type = $model->getModel('\\core\\classes\\models\\BlockType');
		$block_type->name = 'Event';
		$block_type->insert();
	}

	public function uninstall() {
		$model = new Model($this->config, $this->database);

		// make all event blocks into normal blocks
		$sql = "
			UPDATE block
			SET block_type_id = (SELECT block_type_id FROM block_type WHERE block_type_name='HTML')
			WHERE block_type_id = (SELECT block_type_id FROM block_type WHERE block_type_name='Event')
		";
		$this->database->executeQuery($sql);

		// drop block_event database table
		$block_event = $model->getModel('\\modules\\block_events\\classes\\models\\BlockEvent');
		$block_event->sqlHelper()->dropTable();

		// remove the Event block_type
		$block_type = $model->getModel('\\core\\classes\\models\\BlockType')->get(['name' => 'Event']);
		$block_type->delete();
	}

	public function enable() {
		$language = new Language($this->config);
		$language->loadLanguageFile('administrator/block_events.php', DS.'modules'.DS.'block_events');

		$main = [
			'controller' => 'administrator/BlockEvents',
			'method' => 'index',
		];
		$main_menu = new Menu($this->config, $language);
		$main_menu->loadMenu('menu_admin_main.php');
		$main_menu->insert_menu(['content', 'content_blocks', 'content_blocks_list'], 'content_blocks_events', $main);
		$main_menu->update();
	}

	public function disable() {
		$language = new Language($this->config);
		$language->loadLanguageFile('administrator/block_events.php', DS.'modules'.DS.'block_events');

		// Remove some menu items to the admin menu
		$main_menu = new Menu($this->config, $language);
		$main_menu->loadMenu('menu_admin_main.php');
		$menu = $main_menu->getMenuData();

		unset($menu['content']['children']['content_blocks']['children']['content_blocks_events']);

		$main_menu->setMenuData($menu);
		$main_menu->update();
	}
}