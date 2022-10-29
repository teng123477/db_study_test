<?php
include "../../../sdk/php_setting.php";

use PhpSetting;

// 載入上層資料夾內所有 php
$files = glob('../*.php');
foreach ($files as $file) {
    include $file;
}

$do = $_GET['do'];

if (!PhpSetting::tableExists("migrations")) {
    $sql = "CREATE TABLE `" . PhpSetting::$dataBaseName . "`.`migrations` ( 
        `id` BIGINT NOT NULL AUTO_INCREMENT, 
        `batch` INT NOT NULL , 
        PRIMARY KEY (`id`),
        UNIQUE (`batch`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
    //echo PhpSetting::$pdo;
    PhpSetting::$pdo->query($sql);
}

$sql = "SELECT * FROM " . PhpSetting::$dataBaseName . ".migrations ORDER BY `batch` DESC LIMIT 1";
$data = PhpSetting::$pdo->query($sql);
$dataList = $data->fetchAll(PDO::FETCH_ASSOC);

$batch = 0;


if ($do == 'up') {
    if (count($dataList) != 0) {
        $batch = (int)($dataList[0]["batch"]) + 1;
    } else {
        $batch = 0;
    }

    switch ($batch) {
        case 0: {
                (new CreateUsersTable())->up();
                increaseBatch(0);
            }
        case 1: {
                (new AddePhoneColumnsInUsersTable())->up();
                increaseBatch(1);
            }
        case 2: {
                // NEXT
            }
    }
    echo "migrate success";
}
if ($do == 'down') {
    if (count($dataList) != 0) {
        $batch = (int)($dataList[0]["batch"]);
    } else {
        $batch = -1;
    }

    switch ($batch) {
        case 0: {
                (new CreateUsersTable())->down();
                decreaseBatch(0);
                break;
            }
        case 1: {
                (new AddePhoneColumnsInUsersTable())->down();
                decreaseBatch(1);
                break;
            }
        case 2: {
                // NEXT
            }
    }
    echo "rollback success";
}

function increaseBatch($batch)
{  
    $dataTablePath = " " . PhpSetting::$dataBaseName . ".migrations";
    $sql = "insert into" . $dataTablePath . "( batch ) values ( ? )";
    $select = PhpSetting::$pdo->prepare($sql);
    $select->execute(array($batch));
}

function decreaseBatch($batch)
{   
    $dataTablePath = " " . PhpSetting::$dataBaseName . ".migrations";
    $sql = "DELETE FROM " . $dataTablePath . " WHERE FIND_IN_SET(batch, ?)";
    $select = PhpSetting::$pdo->prepare($sql);
    $select->execute(array($batch));
}
