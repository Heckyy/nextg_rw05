$(document).ready(function () {
  function view_data() {
    let bank = document.getElementById("bank").value;
    let date = document.getElementById("date").value;
    let data = {
      bank: bank,
      date: date,
    };
    $.ajax({
      type: "POST",
      url:
        localStorage.getItem("data_link") +
        "/src/home/proses/get_report_bank.php",
      data: data,
      success: function (response) {
        console.log(response);
        let result = response;
        let nominal = document.getElementById("nominal");
        if (result != null) {
          nominal.innerHTML = formatRupiah(result);
        } else {
          nominal.innerHTML = "Rp " + "0,00";
        }
      },
    });
  }

  $("#search").submit(function () {
    view_data();
    return false;
  });

  view_data();
});

function link_view(e) {
  var id = e.getAttribute("data-id");
  document.location.href =
    localStorage.getItem("data_link") + "/account/laporan-warga/view/" + id;
}

function reportBank() {
  let bank = document.getElementById("bank").value;
  let date = document.getElementById("date").value;
  let data = {
    bank: bank,
    date: date,
  };
  $.ajax({
    type: "POST",
    url:
      localStorage.getItem("data_link") +
      "/src/home/proses/get_report_bank.php",
    data: data,
    success: function (response) {
      console.log(response);
      let result = response;
      let nominal = document.getElementById("nominal");
      if (result != null) {
        nominal.innerHTML = formatRupiah(result);
      } else {
        nominal.innerHTML = "Rp " + "0,00";
      }
    },
  });
}

function formatRupiah(nominal) {
  var rupiah = parseFloat(nominal).toFixed(2);
  return "Rp " + rupiah.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
