<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Times You Don't Want Classes</h3>
    </div>
    <div class="panel-body panel-options">
        <div id="days" class="checkbox">
            <label>
                <input type="checkbox"> Mon
            </label>
            <label>
                <input type="checkbox"> Tues
            </label>
            <label>
                <input type="checkbox"> Wed
            </label>
            <label>
                <input type="checkbox"> Thurs
            </label>
            <label>
                <input type="checkbox"> Fri
            </label>
        </div>
        <div class="btn-group">

            <a id="from-text" class="btn btn-default">10:00 AM</a>
            <a data-target="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
            <ul id="from" class="dropdown-menu time-span">
                @foreach ($timeIncrements as $increment)
                    <li><a href="#">{{ $increment }}</a></li>
                @endforeach
            </ul>
        </div>
        to
        <div class="btn-group">
            <a id="to-text" class="btn btn-default">12:00 PM</a>
            <a data-target="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
            <ul id="to" class="dropdown-menu time-span">
                @foreach ($timeIncrements as $increment)
                    <li><a href="#">{{ $increment }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Others</h3>
    </div>
    <div class="panel-body panel-options">
        <div id="full" class="checkbox">
            <label>
                <input type="checkbox"> Include Full Classes
            </label>
        </div>
        <div id="cc" class="checkbox">
            <label>
                <input type="checkbox"> Include Center City Classes Only
            </label>
        </div>
    </div>
</div>
