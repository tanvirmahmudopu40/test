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
  $(".table").on("click", ".editbutton", function () {
    "use strict";
    var iid = $(this).attr("data-id");
    $("#editLeavemanagerForm").trigger("reset");
    $("#myModal2").modal("show");
    $.ajax({
      url: "leavemanager/editLeavemanagerByJason?id=" + iid,
      method: "GET",
      data: "",
      dataType: "json",
      success: function (response) {
        "use strict";

        var de = response.leavemanager.start_date * 1000;
        var d = new Date(de);
        var start_date =
          d.getDate() + "-" + (d.getMonth() + 1) + "-" + d.getFullYear();
        var de = response.leavemanager.end_date * 1000;
        var d = new Date(de);
        var end_date =
          d.getDate() + "-" + (d.getMonth() + 1) + "-" + d.getFullYear();

        $("#editLeavemanagerForm").find('[name="id"]').val(response.leavemanager.id).end(); 
        $("#editLeavemanagerForm").find('[name="patient"]').val(response.leavemanager.patient).end();
        // var option = new Option(response.patient.name + "-" + response.patient.id, response.patient.id,true,true);
        // $("#editTransferForm").find('[name="patient"]').append(option).trigger("change");
        // myEditor2.setData(response.leavemanager.diagnosis);
        $("#editLeavemanagerForm").find('[name="diagnosis"]').val(response.leavemanager.diagnosis).end();
        $("#editLeavemanagerForm").find('[name="doctor"]').val(response.leavemanager.doctor).end();
        $("#editLeavemanagerForm").find('[name="company"]').val(response.leavemanager.company).end();
        $("#editLeavemanagerForm").find('[name="start_date"]').val(start_date).end();
        $("#editLeavemanagerForm").find('[name="end_date"]').val(end_date).end();
        
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
          url: "leavemanager/getLeavemanagerList",
          type: 'POST',
      },
      scroller: {
          loadingIndicator: true
      },
      dom: "<'row'<'col-sm-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",

      buttons: [
          {extend: 'copyHtml5', exportOptions: {columns: [1, 2, 3, 4, 5], }},
          {extend: 'excelHtml5', exportOptions: {columns: [1, 2, 3, 4, 5], }},
          {extend: 'csvHtml5', exportOptions: {columns: [1, 2, 3, 4, 5], }},
          {extend: 'pdfHtml5', exportOptions: {columns: [1, 2, 3, 4, 5], }},
          {extend: 'print', exportOptions: {columns: [1, 2, 3, 4, 5], }},
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
