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
