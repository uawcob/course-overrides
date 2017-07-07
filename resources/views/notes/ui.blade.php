<?php if (!isset($notes)) $notes []= $note; ?>

@foreach ($notes as $note)
    <div class="panel panel-{{ $note->deleted_at ? 'danger' : 'default'}}">
        @unless (empty($note->deleted_at))
        <div class="panel-heading">
            <span class="panel-title">Disabled {{ $note->deleted_at }} UTC</span>
        </div>
        @endunless

        <div id="div-plans" class="panel-body">
            @include ('include.note')
        </div>

        <div class="panel-footer">
            <a href="{{ route('notes.show', $note) }}" class="btn btn-default">View</a>
            <a href="{{ route('notes.edit', $note) }}" class="btn btn-primary">Edit</a>
            <button onclick="{{ $note->deleted_at ? "enable({$note->id})" : "disable({$note->id})" }}" class="btn btn-warning" data-toggle="modal" data-target="#modalDelete">
                {{ $note->deleted_at ? 'Enable' : 'Disable' }}
            </button>
            <button onclick="destroy({{ $note->id }})" class="btn btn-danger" data-toggle="modal" data-target="#modalDelete">Delete</button>
        </div>
    </div>
@endforeach

<div id="modalDelete" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 id="modalDeleteHead" class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <p id="modalDeleteBody"></p>
      </div>
      <div class="modal-footer">
        <form id="modalDeleteForm" method="post">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <button id="modalDeleteButt" type="submit" class="btn btn-danger"></button>
        </form>
      </div>
    </div>
  </div>
</div>

@push ('scripts')
<script>
function disable(id)
{
    $('#modalDeleteHead').text('Disable Note');
    $('#modalDeleteBody').html('Are you sure you want to disable this note?<br>You can always enable it again later.');
    $('#modalDeleteButt').addClass('btn-danger').removeClass('btn-primary').text('Disable');
    $('#modalDeleteForm').attr('action', '/notes/disable/'+id);
}
function enable(id)
{
    $('#modalDeleteHead').text('Enable Note');
    $('#modalDeleteBody').html('Are you sure you want to enable this note?');
    $('#modalDeleteButt').addClass('btn-primary').removeClass('btn-danger').text('Enable');
    $('#modalDeleteForm').attr('action', '/notes/disable/'+id);
}
function destroy(id)
{
    $('#modalDeleteHead').text('Delete Note');
    $('#modalDeleteBody').html('Are you sure you want to delete this note <strong>permanently</strong>?');
    $('#modalDeleteButt').text('Delete');
    $('#modalDeleteForm').attr('action', '/notes/'+id);
}
</script>
@endpush
