var baseUrl = window.location.origin + '/todo_app_sayem';
/**
 * login call with login credentials
 * @param url to call for json data
 */
function loginRegCall(url) {
    var username = $('#username').val();
    var pass = $('#password').val();
    $.ajax({
        url: url,
        type: 'POST',
        data: {username: username, pass: pass},
        success: function (data) {
            location.reload();
        },
        error: function () {
        }
    });
}
/**
 *  this method create teh task
 * @param url create task url
 */
function createTask(url) {
    var taskName = $('#taskName').val();
    $.ajax({
        url: url,
        type: 'POST',
        data: {taskname: taskName},
        success: function (data) {
            location.reload();
        },
        error: function () {
        }
    });
}
/**
 * this method load all the task
 * with the comment related to the task
 */
function loadTask() {
    var loadTaskUrl = baseUrl + '/api/call.php?loadtask=true';
    $.ajax({
        url: loadTaskUrl,
        type: 'POST',
        success: function (data) {
            var tasks = $.parseJSON(data);
            appendData(tasks);
        },
        error: function (tasks) {
        }
    });
}
/**
 * this method take the loadAll task json data and parse it and
 * append it in the view
 * @param JSONObject tasks repsonse json data from api
 */
function appendData(tasks){
    if(tasks != 'failure'){
    for (var i = 0; i < tasks.length; i++) {
        $('#tasks').append('<div class="panel panel-info" >' +
            '<div class="panel-heading"> ' +
            '<h1 class="panel-title"><i class="glyphicon glyphicon-tasks"></i> '+tasks[i].task_name+'<span class="badge pull-right "><input type="checkbox" class="mark" id="'+tasks[i].id +'chk" value="'+tasks[i].id+'"></span><button  class=" pull-right taskdelete" val="'+tasks[i].id+'" id="' + tasks[i].id +'taskicon" style="display: none;">' +
            '<i class="glyphicon glyphicon-remove"></i></button></h1>' +
            '</div><div class="panel-body"  id=' + tasks[i].id + '>');
            if(tasks[i].status==1){
                $('#'+tasks[i].id+'chk').prop('checked', true);
            }
        if (tasks[i].comments.length > 0) {
            for (var j = 0; j < tasks[i].comments.length; j++) {
                $('#' + tasks[i].id).append('<div class="well well-sm ">' +
                    ' <i class="glyphicon glyphicon-pushpin"></i><button  commentId ="'+tasks[i].comments[j].id+'" class=" pull-right removecomment"><i class="glyphicon glyphicon-remove"></i></button> '+tasks[i].comments[j].comment+'</div>');
            }
            $('#' + tasks[i].id).append('<div class="form-group">' +
                '<div class="col-sm-9">' +
                '<textarea class="form-control comment'+ tasks[i].id+'" rows="3" id="comment"></textarea>' +
                '</div>');
            $('#' + tasks[i].id).append('<div class="col-sm-3">' +
                '<button taskId="'+ tasks[i].id+'" class="btn btn-default createComment">' +
                '<i class="glyphicon glyphicon-comment"></i> COMMENT</button>' +
                '</div>' +
                '</div>');
        } else {
            $('#' + tasks[i].id).append('<div class="form-group">' +
                '<div class="col-sm-9">' +
                '<textarea class="form-control comment'+ tasks[i].id+'" rows="3" id="comment"></textarea>' +
                '</div>');
            $('#' + tasks[i].id).append('<div class="col-sm-3">' +
                '<button taskId="'+ tasks[i].id+'" class="btn btn-default createComment">' +
                '<i class="glyphicon glyphicon-comment"></i> COMMENT</button>' +
                '</div>' +
                '</div>');
            $('#' + tasks[i].id+'taskicon').show();
        }
        $('#'+ tasks[i].id).append('</div>');//panel info end
    }
    }
}
/**
 * this method take the task id as parameter and remove it from the db
 * and make page refresh after success
 * @param taskId task id
 */
 function deleteTask(taskId){
     var deleteTaskUrl = baseUrl + '/api/call.php?deleteTask=true';
     $.ajax({
         url: deleteTaskUrl,
         data: {taskId: taskId},
         type: 'POST',
         success: function (data) {
             location.reload();
         },
         error: function (tasks) {
         }
     });
 }
/**
 * take the comment id as parameter and create the comment
 * @param commentId
 */
function deleteComment(commentId){
    var deleteCommentUrl = baseUrl + '/api/call.php?commentDelete=true';
    $.ajax({
        url: deleteCommentUrl,
        data: {commentId: commentId},
        type: 'POST',
        success: function (data) {
            location.reload();
        },
        error: function (tasks) {
        }
    });
}
/**
 * take task id and comment and create a comment
 * @param taskId taskid
 * @param comment commnet data
 */
function createComment(taskId, comment) {

    var createCommentUrl = baseUrl + '/api/call.php?createComment=true';
    $.ajax({
        url: createCommentUrl,
        type: 'POST',
        data: {taskId: taskId, comment: comment},
        success: function (data) {
            location.reload();
        },
        error: function () {
        }
    });
}
/**
 * take the task id and checkbox status and update the mark status in task
 * @param taskId task id
 * @param status marked or not checkbox
 */
function updateMark(taskId,status){
    var updateMarkUrl = baseUrl + '/api/call.php?updateMark=true';
    $.ajax({
        url: updateMarkUrl,
        type: 'POST',
        data: {taskId: taskId,status:status},
        success: function (data) {
            location.reload();
        },
        error: function () {
        }
    });
}
$(document).ready(function () {
    //load the task on docuemnt  load
    loadTask();
    //when login button is clicked
    $('#login').click(function () {
        var loginUrl = baseUrl + '/api/call.php?login=true';
        loginRegCall(loginUrl);
    });
    //registration
    $('#registration').click(function () {
        var regUrl = baseUrl + '/api/call.php?registration=true';
        loginRegCall(regUrl);
    });
    //logout
    $('#logout').click(function () {
        var logoutUrl = baseUrl + '/api/call.php?logout=true';
        loginRegCall(logoutUrl);
    });
    //create a task
    $('#task').click(function () {
        var taskUrl = baseUrl + '/api/call.php?createtask=true';
        createTask(taskUrl);
    });
    // create a commnet
    $('body').on('click', '.createComment', function () {
        var taskId = $(this).attr('taskId');
        var comment = $('.comment'+taskId).val();
        createComment(taskId, comment);
    });
  //delete a task
    $('body').on('click','.taskdelete',function(){
        var taskId = $(this).attr('val');
        deleteTask(taskId);
    });
    //remove a comment
    $('body').on('click','.removecomment',function(){
        var commentId = $(this).attr('commentId');
        console.log(commentId);
        deleteComment(commentId);
    });

    $('.newuser').click(function () {
        $(this).hide();
        $('#login').hide();
        $('#registration').show();
        $('.signin').show();
    });
    $('.signin').on('click', function () {
        $(this).hide();
        $('#registration').hide();
        $('.newuser').show();
        $('#login').show();
    });
    //update mark
    $('body').on('click','.mark',function(){
        if($(this).prop('checked')){
            updateMark($(this).val(),1);
        }else{
            updateMark($(this).val(),0);
        }
    });
});
