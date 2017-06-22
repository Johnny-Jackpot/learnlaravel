@extends('mainTemplate')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if($feeds)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-condensed"
                           id="feedbacks-table"
                           data-_token="{{ csrf_token() }}">
                        <colgroup>
                            <col class="col-md-1">
                            <col class="col-md-1">
                            <col class="col-md-1">
                            <col class="col-md-6">
                            <col class="col-md-1">
                            <col class="col-md-2">
                        </colgroup>
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
                                                data-action="publish">
                                            Publish
                                        </button>
                                        <button type="button"
                                                class="btn btn-danger"
                                                data-comment-id="{{ $record->id }}"
                                                data-action="reject">
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

    <!-- Modal -->
    <div class="modal fade" id="modal-moderate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal-moderate-label"></h4>
                </div>
                <div class="modal-body" id="moderate-modal-body">
                    <select class="form-control" id="reject-reason">
                        <option value="lack of information">Lack of information</option>
                        <option value="abusive language">Abusive language</option>
                        <option value="advertising">Advertising</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Decline</button>
                    <button type="button" class="btn btn-primary" id="confirm-moderating">Confirm</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="/js/timer-plugin-jquery.js"></script>
    <script src="/js/admin.js"></script>
@stop
