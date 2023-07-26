$(document).ready(function () {
  closebook();
});

function closebook() {
  $.ajax({
    type: "POST",
    url:
      localStorage.getItem("data_link") +
      "/src/home/proses/get_data_proses.php",
    success: function (response) {
      console.log(response);
    },
  });
}
