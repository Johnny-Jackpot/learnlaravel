@extends('mainTemplate')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @if($feeds)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="feedbacks-table">
                        <thead>
                        <tr>
                            <th>Author</th>
                            <th>Date</th>
                            <th>Website</th>
                            <th>Feedback</th>
                            <th>Rate</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($feeds as $record)
                            <tr>
                                <td>{{ $record->author->name }}</td>
                                <td>{{ $record->date }}</td>
                                <td>{{ $record->website->name }}</td>
                                <td>{{ $record->feed }}</td>
                                <td>{{ $record->rate->rate }}</td>
                                <td class="align-center">
                                    <div class="btn-group" role="group" aria-label="...">
                                        <button type="button"
                                                class="btn btn-success"
                                                data-comment-id="{{ $record->id }}"
                                                data-action="publish"
                                                data-_token="{{ csrf_token() }}"

                                        >
                                            Publish
                                        </button>
                                        <button type="button"
                                                class="btn btn-danger"
                                                data-comment-id="{{ $record->id }}"
                                                data-action="reject"
                                                data-_token="{{ csrf_token() }}"
                                        >
                                            Reject
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>There is no any new feedback yet. Please add your own.</p>
            @endif
        </div>
    </div>
@stop

@section('scripts')
    <script src="/js/timer-plugin-jquery.js"></script>
    <script src="/js/admin.js"></script>
@stop