(function() {

    function moderate(dataset, target) {
        var url = getUrl(dataset.action);
        var message = getMessage(dataset.action);

        var confirm = window.confirm(message);
        if (!confirm) {
            return;
        }

        makeModeratingRequest(url, dataset, target);
    }

    function getUrl(action) {
        return (action === 'publish') ? '/moderate/publish' :
            (action === 'reject') ? '/moderate/reject' : '';
    }

    function getMessage(action) {
        return (action === 'publish') ? 'Confirm publishing' : 'Confirm rejecting';
    }

    function makeModeratingRequest(url, dataset, target) {
        $.post(url, dataset)
            .done(function(data) {
                $(target).closest('tr').remove();
            })
            .fail(function(xhr, status, error) {
                alert('An error occured. Comment wasn\'t moderated.');
            });
    }

    $('#feedbacks-table').click(function (event) {
        var dataset = $(event.target).data();
        if (!dataset.commentId || !dataset.action) {
            return;
        }

        moderate(dataset, event.target);
    });

    $.timer(25000, function() {
        $.post('/moderate/getrecentfeeds')
            .done(function(data) {
                $('#feedbacks-table tbody').prepend('<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>');
            })
            .fail(function() {
                console.dir('fail')
            });
    });


})();