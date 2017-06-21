/**
 * jQuery Timer Plugin (jquery.timer.js)
 * @version 1.0.1
 * @author James Brooks <jbrooksuk@me.com>
 * @website http://james.brooks.so
 * @license MIT - http://jbrooksuk.mit-license.org
 * https://github.com/jbrooksuk/jQuery-Timer-Plugin/blob/master/index.html
 */

(function($) {
    jQuery.timer = function(interval, callback, options) {
        // Create options for the default reset value
        var options = jQuery.extend({ reset: 500 }, options);
        var interval = interval || options.reset;

        if(!callback) { return false; }

        var Timer = function(interval, callback, disabled) {
            // Only used by internal code to call the callback
            this.internalCallback = function() { callback(self); };

            // Clears any timers
            this.stop = function() {
                if(this.state === 1 && this.id) {
                    clearInterval(self.id);
                    this.state = 0;
                    return true;
                }
                return false;
            };
            // Resets timers to a new time
            this.reset = function(time) {
                if(self.id) { clearInterval(self.id); }
                var time = time || options.reset;
                this.id = setInterval($.proxy(this.internalCallback, this), time);
                this.state = 1;
                return true;
            };
            // Pause a timer.
            this.pause = function() {
                if(self.id && this.state === 1) {
                    clearInterval(this.id);
                    this.state = 2;
                    return true;
                }
                return false;
            };
            // Resumes a paused timer.
            this.resume = function() {
                if(this.state === 2) {
                    this.state = 1;
                    this.id = setInterval($.proxy(this.internalCallback, this), this.interval);
                    return true;
                }
                return false;
            };

            // Set the interval time again
            this.interval = interval;

            // Set the timer, if enabled
            if (!disabled) {
                this.id = setInterval($.proxy(this.internalCallback, this), this.interval);
                this.state = 1;
            }

            var self = this;
        };

        // Create a new timer object
        return new Timer(interval, callback, options.disabled);
    };
})(jQuery);

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

    //Because MySQL current_timestamp save datetime in +3 timezone
    var now = new Date();
    now.setHours(now.getHours() + 3);
    var jsonDate = now.toJSON();
    var token = $('input[name=_token]').val();

    //every 25 second script will check if there is any new feedback
    $.timer(25000, function(){
        $.post('/updateTable', {_token: token, date: jsonDate})
            .done(function(data) {
                if (data.length === 0) {
                    return;
                }

                jsonDate = (new Date()).toJSON();
                var tableUpdater = new TableUpdater('#feedbacks-table');
                tableUpdater.updateTable(tableUpdater.generateTableRow(data[0]));
            });
    });



})();