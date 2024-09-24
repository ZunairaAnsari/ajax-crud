$(document).ready(function(){

    $(document).on('submit', '#AddEmployeeForm', function(e){
        e.preventDefault();
        // console.log("employee registration");

        let formData = $(this).serialize();

        console.log(formData);

        $.ajax({
            type: "POST",
            url: "/create",
            data: formData,
            success: function (response) {
                if (response.status == 400) {
                    $('#save_errorList').html("");
                    $('#save_errorList').removeClass("d-none");
                    $.each(response.errors, function (key, err_value) { 
                        $('#save_errorList').append('<li>' + err_value + '</li>');
                    });
                }
            }
        });

    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

});
