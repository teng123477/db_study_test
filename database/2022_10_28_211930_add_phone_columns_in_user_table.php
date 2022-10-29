<?php
//include "../../sdk/php_setting.php";
require_once("../../sdk/php_setting.php");

//use PhpSetting;

class AddePhoneColumnsInUsersTable
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    private $strTableName = "user";

    public function up()
    {
        $sql = "ALTER TABLE `". PhpSetting::$dataBaseName."`.`".$this->strTableName."` ADD `phone` INT(10) NULL AFTER `name`";
        PhpSetting::$pdo->query($sql);
        echo "up 2022_10_28_211930_add_phone_columns_in_user_table<br>";
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $sql = "ALTER TABLE `".PhpSetting::$dataBaseName."`.`".$this->strTableName."` DROP `phone`";
        PhpSetting::$pdo->query($sql);
        echo "down 2022_10_28_211930_add_phone_columns_in_user_table<br>";
    }
}
