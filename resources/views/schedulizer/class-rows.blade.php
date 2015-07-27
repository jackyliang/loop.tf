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
            <ul style="margin-top: 7px;">
              <li class="text-muted">{{ $class->description }}</li>
            </ul>
        </div>
    </td>
</tr>
