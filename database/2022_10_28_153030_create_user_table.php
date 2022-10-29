<?php
//include "../../sdk/php_setting.php";
require_once("../../sdk/php_setting.php");
//use PhpSetting;

class CreateUsersTable
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    private $strTableName = "user";

    public function up()
    {
        $sql = "CREATE TABLE `" . PhpSetting::$dataBaseName . "`.`" . $this->strTableName . "` (
			`id` BIGINT NOT NULL AUTO_INCREMENT,
			`name` VARCHAR(250) NOT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8";
        PhpSetting::$pdo->query($sql);
        echo "up 2022_10_28_153030_create_user_table<br>";
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $sql = "DROP TABLE `".PhpSetting::$dataBaseName."`.`".$this->strTableName."`";
        PhpSetting::$pdo->query($sql);
        echo "down 2022_10_28_153030_create_user_table<br>";
    }
}
