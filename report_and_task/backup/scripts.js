function openPop() {
    const popDialog =
        document.getElementById(
            "popupDialog"
        );
    popDialog.style.visibility =
        popDialog.style.visibility ===
        "visible"
            ? "hidden"
            : "visible";
}

$(document).ready(function () {

    $('.editbtn').on('click', function () {

        $('#editmodal').modal('show');
        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function () {
            return $(this).text();
        }).get();

        console.log(data);
        $('#bar').val(data[0]);
        $('#id').val(data[1]);
        $('#username').val(data[2]);
        $('#password').val(data[3]);
        $('#first_name').val(data[4]);
        $('#last_name').val(data[5]);
        $('#email').val(data[6]);
        $('#phone').val(data[7]);
        $('#bd').val(data[8]);
        $('#role').val(data[9]);
    });
});

