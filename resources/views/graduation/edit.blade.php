<div>
    <p>
        When do you plan to graduate?
    </p>

    <form class="form-horizontal" method="POST"
        action="{{ route('graduation.update') }}"
        id="formUpdateGraduation"
    >
        {{ csrf_field() }}
        <div class="form-group">
            <label class="control-label col-sm-2" for="term">Semester:</label>
            <div class="col-sm-10">
                <select class="form-control" id="term" name="term" required>
                    {!! App\UpcomingTerm::getTermOptions(date('Y-m-d')) !!}
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="year">Year:</label>
            <div class="col-sm-10">
                <input id="year" name="year" class="form-control" required
                    type="number" min="{{ date('Y') }}"
                    value="{{ App\UpcomingTerm::get(date('Y-m-d'))['year'] }}"
                >
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
