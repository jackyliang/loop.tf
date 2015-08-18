<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Schedule</h3>
    </div>
    <div id="schedule" class="panel-body panel-options">
        <div class="btn-group">
            {{-- TODO: Dynamically increment and decrement buttons --}}
            <a href='{{ URL('schedulizer/schedule#2') }}' class="btn btn-default"><</a>
            <a href='{{ URL('schedulizer/schedule#3') }}' class="btn btn-default">></a>
        </div>
    </div>
</div>