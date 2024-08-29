$(document).ready(function () {
  showingmessgae();
});

function showingmessgae() {
  $(".datamessage").on("click", function () {
    var user_id = $(".grp_message_row").data("grp_id");

    $.ajax({
      type: "POST",
      url: "chat/chatsystemsql.php?action=showingmessage",
      data: {
        user_id: user_id,
      },

      success: function (data) {
  
        console.log(data);


      },
    });
  });
}
