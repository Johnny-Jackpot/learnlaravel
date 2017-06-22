(function() {

    $('#feedbacks-table').click(function (event) {
        //determine if "publish" or "reject" button was pressed
        var dataset = $(event.target).data();
        if (!dataset.commentId || !dataset.action) {
            return;
        }

        var modal = $('#modal-moderate');
        var modalHeading = $('#modal-moderate-label');
        var modalBody = $('#moderate-modal-body');

        //get dataset from pressed button and attach to modal
        for (var key in dataset) {
            modal.data(key, dataset[key]);
        }

        if (dataset.action === 'publish') {
            modalHeading.text('Confirm publishing');
            modalBody.hide(); //hide reasons for rejecting
        }

        if (dataset.action === 'reject') {
            modalHeading.text('Select reason for rejecting');
            modalBody.show(); //show reasons for rejecting
        }

        modal.modal('show');
    });

    //confirm publishing or rejecting
    $('#confirm-moderating').click(function() {
        var dataset = $('#modal-moderate').data();
        var data = {
            action: dataset.action,
            commentId: dataset.commentId
        };

        if (data.action === 'reject') {
            //get selected option and attach to data
            data.reason = $('#reject-reason').val();
        }

        //set csrf token
        data._token = $('#feedbacks-table').data('_token');

        var url = data.action === 'publish' ? '/moderate/publish' : '/moderate/reject';
        //get pressed button ('publish' or 'reject')
        var selector = 'button[data-comment-id=' + data.commentId + ']';

        $.post(url, data).done(function(data) {
            //remove row associated with pressed button
            $(selector).closest('tr').remove();
            console.dir(data);
        });

        $('#modal-moderate').modal('hide');

    });

    //check for recent feedbacks
    var jsonDate = new Date().toJSON();
    $.timer(25000, function() {
        var data = {
            _token: $('#feedbacks-table').data('_token'),
            date: jsonDate
        };

        $.post('/moderate/getrecentfeeds', data)
            .done(function(data) {
                $('#feedbacks-table tbody').prepend(data);
                jsonDate = new Date().toJSON();
            });
    });


})();