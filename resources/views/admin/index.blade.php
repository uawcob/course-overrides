@extends('layout')

@section('content')
    <h1>Administration</h1>

    <ul>
        <li><a href="{{ route('schedules.index') }}" class="btn btn-default">Schedules</a></li>
        <li><a href="{{ route('notes.index') }}" class="btn btn-default">Notes</a></li>
        <li><a href="{{ route('courses.create') }}" class="btn btn-default">Create Course</a></li>
        <li><button data-toggle="modal" data-target="#modalRefresh" class="btn btn-default">Refresh Courses</button></li>
    </ul>

    <div id="modalRefresh" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Refresh Which Semester?</h4>
          </div>
          <div class="modal-body">
              <div class="semesterSelector" style="padding:10px">
                  <form class="form-inline" action="{{ route('courses.refresh') }}">
                      <div class="form-group">
                          <label for="semester">Semester:</label>
                          <select class="form-control" id="semester" name="semester" required>
                              {!! App\UpcomingTerm::getTermOptions(date('Y-m-d')) !!}
                          </select>
                      </div>

                      <div class="form-group">
                          <label for="year">Year:</label>
                          <input id="year" name="year" class="form-control" required
                              type="number"
                              value="{{ App\UpcomingTerm::get(date('Y-m-d'))['year'] }}"
                          >
                      </div>

                      <button type="submit" class="btn btn-default">Refresh</button>
                  </form>
              </div>
          </div>
        </div>
      </div>
    </div>
@endsection
