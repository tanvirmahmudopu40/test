"use strict";
var myEditor;
var myEditor2;
$(document).ready(function () {
  ClassicEditor.create(document.querySelector("#editor"))
    .then((editor) => {
      editor.ui.view.editable.element.style.height = "200px";
      myEditor = editor;
    })

    .catch((error) => {
      console.error(error);
    });

  ClassicEditor.create(document.querySelector("#editor1"))
    .then((editor) => {
      editor.ui.view.editable.element.style.height = "200px";
      myEditor2 = editor;
    })
    .catch((error) => {
      console.error(error);
    });
});

$(document).ready(function () {
  "use strict";
  $(".pos_client").hide();
  $(document.body).on("change", "#pos_select", function () {
    "use strict";
    var v = $("select.pos_select option:selected").val();
    if (v === "add_new") {
      $(".pos_client").show();
    } else {
      $(".pos_client").hide();
    }
  });
  $(".pos_client1").hide();
  $(document.body).on("change", "#pos_select1", function () {
    "use strict";
    var v = $("select.pos_select1 option:selected").val();
    if (v === "add_new") {
      $(".pos_client1").show();
    } else {
      $(".pos_client1").hide();
    }
  });
});

$(document).ready(function () {
  "use strict";
  $("#pos_select").select2({
    placeholder: select_patient,
    allowClear: true,
    ajax: {
      url: "patient/getPatientinfoWithAddNewOption",
      type: "post",
      dataType: "json",
      delay: 250,
      data: function (params) {
        "use strict";
        return {
          searchTerm: params.term, // search term
        };
      },
      processResults: function (response) {
        "use strict";
        return {
          results: response,
        };
      },
      cache: true,
    },
  });
  $("#pos_select1").select2({
    placeholder: select_patient,
    allowClear: true,
    ajax: {
      url: "patient/getPatientinfoWithAddNewOption",
      type: "post",
      dataType: "json",
      delay: 250,
      data: function (params) {
        "use strict";
        return {
          searchTerm: params.term, // search term
        };
      },
      processResults: function (response) {
        "use strict";
        return {
          results: response,
        };
      },
      cache: true,
    },
  });

});
$(document).ready(function () {
  "use strict";
  $(".table").on("click", ".editbutton", function () {
    "use strict";
    var iid = $(this).attr("data-id");
    $("#editTransferForm").trigger("reset");
    $("#myModal2").modal("show");
    $.ajax({
      url: "transfer/editTransferByJason?id=" + iid,
      method: "GET",
      data: "",
      dataType: "json",
      success: function (response) {
        "use strict";

        var de = response.transfer.date * 1000;
        var d = new Date(de);
        var date =
          d.getDate() + "-" + (d.getMonth() + 1) + "-" + d.getFullYear();

        $("#editTransferForm").find('[name="id"]').val(response.transfer.id).end();
        $("#editTransferForm").find('[name="patient"]').val(response.transfer.patient).end();
        // var option = new Option(response.patient.name + "-" + response.patient.id, response.patient.id,true,true);
        // $("#editTransferForm").find('[name="patient"]').append(option).trigger("change");
        $("#editTransferForm").find('[name="hospital"]').val(response.transfer.hospital).end();
        $("#editTransferForm").find('[name="date"]').val(date).end();
        myEditor2.setData(response.transfer.reason);
      },
    });
  });
});

$(document).ready(function () {
  "use strict";
  var table = $('#editable-sample').DataTable({
      responsive: true,

      "processing": true,
      "serverSide": true,
      "searchable": true,
      "ajax": {
          url: "transfer/getPatientTransferList",
          type: 'POST',
      },
      scroller: {
          loadingIndicator: true
      },
      dom: "<'row'<'col-sm-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",

      buttons: [
          {extend: 'copyHtml5', exportOptions: {columns: [1, 2, 3, 4, 5, 6], }},
          {extend: 'excelHtml5', exportOptions: {columns: [1, 2, 3, 4, 5, 6], }},
          {extend: 'csvHtml5', exportOptions: {columns: [1, 2, 3, 4, 5, 6], }},
          {extend: 'pdfHtml5', exportOptions: {columns: [1, 2, 3, 4, 5, 6], }},
          {extend: 'print', exportOptions: {columns: [1, 2, 3, 4, 5, 6], }},
      ],
      aLengthMenu: [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, "All"]
      ],
      iDisplayLength: 100,
      "order": [[0, "desc"]],
      "language": {
          "lengthMenu": "_MENU_",
          search: "_INPUT_",
          searchPlaceholder: "Search...",
          "url": "common/assets/DataTables/languages/" + language + ".json"
      },
  });
  table.buttons().container().appendTo('.custom_buttons');
});

// $(document).ready(function () {
//   "use strict";
//   var table = $("#editable-sample").DataTable({
//     responsive: true,
//     dom:
//       "<'row'<'col-sm-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
//       "<'row'<'col-sm-12'tr>>" +
//       "<'row'<'col-sm-5'i><'col-sm-7'p>>",

//     buttons: [
//       { extend: "copyHtml5", exportOptions: { columns: [1, 2, 3] } },
//       { extend: "excelHtml5", exportOptions: { columns: [1, 2, 3] } },
//       { extend: "csvHtml5", exportOptions: { columns: [1, 2, 3] } },
//       { extend: "pdfHtml5", exportOptions: { columns: [1, 2, 3] } },
//       { extend: "print", exportOptions: { columns: [1, 2, 3] } },
//     ],
//     aLengthMenu: [
//       [10, 25, 50, 100, -1],
//       [10, 25, 50, 100, "All"],
//     ],
//     iDisplayLength: -1,
//     order: [[3, "desc"]],
//     language: {
//       lengthMenu: "_MENU_",
//       search: "_INPUT_",
//       url: "common/assets/DataTables/languages/" + language + ".json",
//     },
//   });

//   table.buttons().container().appendTo(".custom_buttons");
// });
$(document).ready(function () {
  "use strict";
  $(".flashmessage").delay(3000).fadeOut(100);
});
