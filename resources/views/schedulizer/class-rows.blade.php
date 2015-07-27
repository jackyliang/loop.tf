<td><a
        href="{{ URL('schedulizer/results?q=' . $class->subject_code . ' ' . $class->course_no) }}"
    >
        {{ $class->subject_code . ' ' . $class->course_no}}
    </a>
</td>
<td> {{ $class->section}} </td>
<td> {{ $class->crn}} </td>
<td> {{ $class->course_title}} </td>
<td> {{ $class->day}} </td>
<td> {{ $class->time}} </td>
<td><a
        href="{{ URL('schedulizer/results?q=' . $class->instructor) }}"
    >
        {{ $class->instructor}}
    </a>
</td>
<td> {{ $class->enroll}} </td>
<td> {{ $class->max_enroll}} </td>
<td> {{ $class->credits}} </td>
<tr>
    <td colspan="10" class="hiddenRow">
        <div id="demo{{ $i }}" class="collapse">
        <div class="">
            <div class="col-md-3">
                <h4>Description</h4>
                <p>{{ $class->description }}</p>
            </div>
            <div class="col-md-2">
                <h4>Campus</h4>
                <p>{{ $class->campus }}</p>
            </div>
            <div class="col-md-2">
                <h4>Building</h4>
                <p>{{ $class->building . ' ' . $class->room }}</p>
            </div>
            <div class="col-md-2">
                <h4>Type</h4>
                <p>{{ $class->instr_method }}</p>
            </div>
            <div class="col-md-2">
                <h4>Pre-reqs</h4>
                <p>{{ $class->pre_reqs or "None" }}</p>
            </div>
        </div>
    </td>
</tr>
