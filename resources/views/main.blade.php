@extends('mainTemplate')

@section('content')
    <div class="row">
        <div class="col-md-2 col-md-offset-10">
            <div id="timer" class="timer">
                <span>Time to to new form submission:</span>
                <span id="timer-display"></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @if($feedbacks)
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-condensed" id="feedbacks-table">
                    <colgroup>
                        <col class="col-md-1">
                        <col class="col-md-2">
                        <col class="col-md-2">
                        <col class="col-md-6">
                        <col class="col-md-1">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Author</th>
                            <th>Date</th>
                            <th>Website</th>
                            <th>Feedback</th>
                            <th>Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($feedbacks as $record)
                            <tr>
                                <td>{{ $record->author }}</td>
                                <td>{{ $record->date }}</td>
                                <td>{{ $record->website }}</td>
                                <td>{{ $record->feedback }}</td>
                                <td>{{ $record->rate }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <p>There is no any feedback yet. Please add your own.</p>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-md-offset-4" id="form-message"></div>
    </div>

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <form method="post" action="/" id="feedback-form">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="website">Website</label>
                    <input type="text"
                           class="form-control"
                           id="website"
                           name="website"
                           placeholder="Website"
                           required
                    >
                </div>
                <div class="form-group">
                    <label for="feedback">Feedback</label>
                    <input type="text"
                           class="form-control"
                           id="feedback"
                           name="feedback"
                           placeholder="Feedback"
                           required
                    >
                </div>
                <div class="form-group">
                    <label for="rate">Rate</label>
                    <select id="rate" class="form-control" name="rate">
                        @foreach($rates as $rate)
                            <option value="{{ $rate->id }}">{{ $rate->rate }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="author">Name</label>
                    <input type="text"
                           class="form-control"
                           id="author"
                           name="author"
                           placeholder="Name"
                           required
                    >
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email"
                           class="form-control"
                           id="email"
                           name="email"
                           placeholder="Email"
                           required
                    >
                </div>
                <div class="form-group">
                    <input id="submit-feedback" class="btn btn-primary" type="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>

@stop

@section('scripts')

    <script src="/js/timer-plugin-jquery.js"></script>
    <script src="/js/main.js"></script>
@stop

@section('footer-content')
    <div class="social-buttons">
        <iframe src="https://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fguestbook.com&width=96&layout=button&action=like&size=small&show_faces=true&share=true&height=65&appId" width="96" height="25" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
        <script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: en_US</script>
        <script type="IN/Share" data-url="http://guestbook.com/" data-counter="right"></script>
    </div>
@stop