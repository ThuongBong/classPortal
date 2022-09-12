@extends('layouts.app')
@section('title', 'Assignments')
@section('page-header', 'Assignments')
@section('content')
    <div class="col-xs-12 col-md-12">
        @include('pages.teacher.session-data')

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title">
                    Assignments
                </h4>
            </div>
            <div class="panel-body">
                <div class="col-xs-12 col-md-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col" style="width: 5%">STT</th>
                            <th scope="col">Title</th>
                            <th scope="col">Source</th>
                            <th scope="col">Due date</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if (!$assignments->isEmpty())
                                @php $i = $assignments->firstItem(); @endphp
                                @foreach($assignments as $assignment)
                                    <tr>
                                        <th scope="row" style="vertical-align: middle">{{ $i }}</th>
                                        <td style="vertical-align: middle">{{ $assignment->title }}</td>
                                        <td style="vertical-align: middle"><a href="{!! asset('uploads/assignments/' . $assignment->source) !!}" target="_blank">{{ $assignment->source }}</a></td>
                                        <td style="vertical-align: middle">{{ !empty($assignment->due_date) ? formatTime($assignment->due_date) : '' }}</td>
                                        <th style="vertical-align: middle">{{ isset($assignment->subject) ? $assignment->subject->name : ''  }}</th>
                                        <td style="vertical-align: middle">
                                            @if (!empty($assignment->due_date) && checkTime($assignment->due_date) < 0)
                                                <p>End</p>
                                            @else
                                                <a href="{{ route('student.assignment.detail', $assignment->id) }}" class="btn btn-success btn-sm"><i class="fa fa-fw fa-eye"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @php $i++ @endphp
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    @if($assignments->hasPages())
                        <div class="pagination float-right margin-20">
                            {{ $assignments->appends($query = '')->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection