$(function(){
    $('#modalButton').click(function(){
        console.log($(this).attr('value'));
        $('#modal').modal('show')
        .find('#modalContent')
        .load($(this).attr('value'));
    });
});