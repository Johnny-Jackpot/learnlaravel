

/******************************************************/

(function(){
    var time = 60;
    var count = 0;
    var timer;

    //show how much time left to submit another form
    function showTimer() {
        count = time;

        $('#timer-display').html(count);
        $('#timer').show();

        timer = $.timer(1000, function() {
            count--;
            if (count <= 0) {
                timer.stop();
                timer = null;
                $('#timer').hide();
            }

            $('#timer-display').html(count);

        });
    }

    function validateForm() {
        var author = $('#author').val();
        if (author.length < 6) {
            showMessage('#form-message', 'Name need to be at least 6 letters.');
            return false;
        }

        var website = $('#website').val();
        if (website.length < 3) {
            showMessage('#form-message', 'Please, fill in website.');
            return false;
        }

        return true;
    }

    function showMessage(target, message, success) {
        var className = success ? 'alert-success' : 'alert-danger';

        if ($('#alert-message')[0]) return;

        $(target).html(
            '<div id="alert-message" class="alert ' + className + '" role="alert">'
            + message
            + '</div>');
        setTimeout(function () {
            $('#alert-message').remove();
        }, 7000);
    };

    $('#submit-feedback')
        .submit(function(event) {
            event.preventDefault();
        })
        .click(function(event) {
            event.preventDefault();

            if (count > 0) {
                return;
            }

            if (!validateForm()) {
                return;
            }

            var data = $('#feedback-form').serialize();

            $.post('/', data)
                .done(function(data) {
                    var message = 'Thank you for feedback. You can submit another one after 1 minute.';
                    showMessage('#form-message', message, true);
                    ['#website', '#feedback', '#author', '#email'].forEach(function(item) {
                        $(item).val('');
                    });

                    if (!timer) {
                        showTimer();
                    }

                    console.dir(data);
                })
                .fail(function (xhr, status, error) {
                    var message = 'An error happend. Try again later.';
                    showMessage('#form-message', message);
                });
        });


    function TableUpdater(selector) {
        this.tableSelector = selector;
    }

    TableUpdater.prototype.updateTable = function(tr) {
        $(this.tableSelector + ' tbody').prepend(tr);
    };

    TableUpdater.prototype.generateTableRow = function(data) {
        var tr = '<tr>:data</tr>';
        var td = '';
        ['author', 'date', 'website', 'feedback', 'rate'].forEach(function(item, i, arr){
            td += '<td>' + data[item] + '</td>';
        });

        return tr.replace(':data', td);
    };

    function updateDateForRequestingData() {
        return new Date().toJSON();
    }

    var jsonDate = updateDateForRequestingData();
    var token = $('input[name=_token]').val();

        //every 25 second script will check if there is any new feedback
    $.timer(25000, function(){
        $.post('/updateTable', {_token: token, date: jsonDate})
            .done(function(data) {
                if (data.length === 0) {
                    return;
                }

                jsonDate = updateDateForRequestingData();
                var tableUpdater = new TableUpdater('#feedbacks-table');
                tableUpdater.updateTable(tableUpdater.generateTableRow(data[0]));
            });
    });



})();