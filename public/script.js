const DEF_COURSE_DETAIL_HTML_PATH = "../CourseDetail/"
const DEF_COURSE_EDITOR_HTML_PATH = "../CourseEditor/"
const DEF_PHP_PATH_URL = "DataBaseController.php"


Initialize()
ConnectionButton()

function Initialize() {
    getUsers()
}


function ConnectionButton() {
    $(".cControlButton .cNewButton").click(function (event) {
        event.preventDefault()
        createNewUser()
    });
}

function createNewUser(data = null){
    const kItemTemplate = $( ".cMemberData .cResultList .cMemberTemplate" ).clone( true )
    $( kItemTemplate ).attr( 'class', 'cMemberAttr' )
    $( kItemTemplate ).appendTo( ".cMemberData .cResultList" )

    if(data){
        $( kItemTemplate ).find(".cId").text(data.id)
        $( kItemTemplate ).find(".cName").val(data.name)
        $( kItemTemplate ).find(".cPhone").val(data.phone)
    }

    $(kItemTemplate).find(".cSaveButton").click(function (event) {
        event.preventDefault();
        // closest 尋找離當下元件最近的父元素
        // 找到此資料元素的 root 節點->再往下取出所有資料
        let id = $(this).closest(".cMemberAttr").find(".cId").text()
        let name = $(this).closest(".cMemberAttr").find(".cName").val()
        let phone = $(this).closest(".cMemberAttr").find(".cPhone").val()
        saveUser(id, name, phone)
    });

    $(kItemTemplate).find(".cRemoveButton").click(function (event) {
        event.preventDefault();
        let name = $(this).closest(".cMemberAttr").find(".cName").val()
        if (!confirm(`Do you want to remove ${name} ?`)) {
            return
        }
        let id = $(this).closest(".cMemberAttr").find(".cId").text()
        if(id == '-'){
            $(this).closest(".cMemberAttr").remove();
            return
        }
        removeUser(id)
    });
}

function showUsers(users){
    $( ".cMemberData .cResultList .cMemberAttr" ).remove();

    if(users.length == 0){
        createNewUser()
        return
    }

    users.forEach(element => {
        createNewUser(element)
    });
}

function getUsers() {
    $.ajax({
        url: DEF_PHP_PATH_URL,
        method: "post",
        data: {
            functionType: "getUsers"
        },
        dataType: "json",
        success: function (res) {
            showUsers(res)
            return;
        },
        error: function (res) {
            alert("Error : 資料庫異常　->getUsers()")
        }
    })
}

function saveUser(id, name, phone){
    $.ajax({
        url: DEF_PHP_PATH_URL,
        method: "post",
        data: {
            functionType: "saveUser",
            id: id,
            name: name,
            phone: phone
        },
        dataType: "json",
        success: function (res) {
            alert("Save Success")
            getUsers()
            return;
        },
        error: function (res) {
            alert("Error : 資料庫異常　->saveUser()")
        }
    })
}

function removeUser(id){
    $.ajax({
        url: DEF_PHP_PATH_URL,
        method: "post",
        data: {
            functionType: "removeUser",
            id: id,
        },
        dataType: "json",
        success: function (res) {
            alert("Remove Success")
            getUsers()
            return;
        },
        error: function (res) {
            alert("Error : 資料庫異常　->removeUser()")
        }
    })
}