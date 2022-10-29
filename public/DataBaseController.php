<?php
require_once("../sdk/php_setting.php");
//use PhpSetting;

$functionType = $_POST['functionType']; //取得 functionType 值

if( $functionType == "getUsers" )
{
	getUsers();
}
else if( $functionType == "saveUser" )
{
	$id = $_POST['id'];
	$name = $_POST['name'];
	$phone = $_POST['phone'];

	if($id == '-'){
		createUser($name, $phone);
	}
	else{
		saveUser($id, $name, $phone);
	}
}
else if( $functionType == "removeUser" )
{
	$id = $_POST['id'];
	removeUser($id);
}
else
{
	echo "queat is Null";
}

function getUsers(){
	$sql = "SELECT * FROM ".PhpSetting::$dataBaseName.".user";
	$data = PhpSetting::$pdo->query($sql);
	$dataList = $data->fetchAll(PDO::FETCH_ASSOC);

	echo json_encode ( $dataList );
}

function createUser($name, $phone){
	$dataTablePath = " " . PhpSetting::$dataBaseName . ".user";
    $sql = "insert into" . $dataTablePath . "( name, phone ) values ( ?,? )";
    $select = PhpSetting::$pdo->prepare($sql);
    $select->execute(array($name, $phone));

	echo json_encode ( 'ok' );
}

function saveUser($id, $name, $phone){
	$sql = "UPDATE ".PhpSetting::$dataBaseName.".user"." SET name = ?, phone = ? WHERE id= ?";
	$select = PhpSetting::$pdo->prepare( $sql );
	$select->execute( array( $name, $phone, $id ));

	echo json_encode ( 'ok' );
}

function removeUser($id){
	$dataTablePath = " " . PhpSetting::$dataBaseName . ".user";
    $sql = "DELETE FROM " . $dataTablePath . " WHERE FIND_IN_SET(id, ?)";
    $select = PhpSetting::$pdo->prepare($sql);
    $select->execute(array($id));

	echo json_encode ( 'ok' );
}

?>