<div class="panel panel-default">
    <div id="div-plans" class="panel-body">
        @include ('include.note')
    </div>
    <div class="panel-footer">
        <a href="{{ route('notes.show', $note) }}" class="btn btn-default">View</a>
        <a href="{{ route('notes.edit', $note) }}" class="btn btn-primary">Edit</a>
        <button class="btn btn-warning">Disable</button>
        <button class="btn btn-danger">Delete</button>
    </div>
</div>
