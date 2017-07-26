$(document).ready(function(){

    if( !$('#voteNoMore').val() )
    {

        $('.li_answer').click(function (event) {
            $('.li_answer').removeClass('isActive');
            $(event.currentTarget).addClass('isActive');

            $('.radio-circle').removeClass('isActive');
            $(event.currentTarget).find('circle').addClass('isActive');
            $(event.currentTarget).find('input').prop('checked', true);

            console.log(event);
        });
    }

});

function addVote(id){

    var ajaxRequest = $.ajax({
        // routes.php knows this url and returns the right controller
        url: '/questions/addAnswer' + id,
        // the data comes straight from the bubbleViz - View
        // you will need the question id to receive the right data for your current question
        data: {question_id: $('#question_id').val()},
        type: 'post',
        dataType: 'json',
        success: function (data) {
            console.log(data);
        },
        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });
}