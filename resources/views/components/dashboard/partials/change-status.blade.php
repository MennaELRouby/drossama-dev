$('#btn_active').click(function() {
    var selectedCheckboxes = $(".check-inputs:checked");

    var selectedIds = [];

    selectedCheckboxes.each(function() {
        selectedIds.push($(this).val());
    });

    if (selectedIds.length === 0) {
        Swal.fire({
            title: "@lang('messages.no_select')?"
            , text: "@lang('messages.please select at least one')"
            , icon: "warning"
            , confirmButtonColor: "#5156be"
        });
    } else {

        Swal.fire({
            title: "@lang('messages.are you sure?')"
            , text: "@lang('messages.change checked status')"
            , icon: "warning"
            , showCancelButton: true
            , confirmButtonColor: "#3085d6"
            , cancelButtonColor: "#d33"
            , confirmButtonText: "@lang('messages.yes, change it')!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: url + "/change-status" + '/' + selectedIds
                    , type: 'POST'
                    , data: {
                        selectedIds: selectedIds
                        , modelName: segment
                    }
                    , success: function(response) {
                        if (response.success) {

                            // Reload the page to reflect the changes
                            location.reload();
                        } else {
                            Swal.fire({
                                icon: "error"
                                , title: "Error!"
                                , text: response.message
                                , showConfirmButton: false
                                , timer: 5500
                            });
                        }
                    }
                    , error: function(error) {
                        Swal.fire({
                            title: "Error!"
                            , text: error.responseJSON.message
                            , icon: "error"
                        });
                    }
                });
            }
        });
    }

});