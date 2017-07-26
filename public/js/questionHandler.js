$(document).ready(function() {
    setInterval("updateQuestionData()",10000);
});

var question_id = $('#question_id').val();;

function updateQuestionData() {
    var category_id = $('#category_id').val();

    // Start the ajax request to receive data from database.
    var ajaxRequest = $.ajax({
        // routes.php knows this url and returns the right controller
        url: "/questionnaire/"+category_id+"/ajaxHandler",
        // the data comes straight from the bubbleViz - View
        // you will need the question id to receive the right data for your current question
        type: 'get',
        dataType: 'json',
        success: function (data) {
          console.log('Q_ID: '+ question_id + " data: "+ data);
          if (data != 0 && question_id != data)
            location.reload();

          else if(data == 0 && question_id != 0)
            location.reload();
        },
        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });
}
