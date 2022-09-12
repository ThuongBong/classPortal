@extends('layouts.app')
@section('title', $assignment->title)
@section('page-header', $assignment->title)
@section('content')
    <div class="col-xs-12 col-md-12">
        @include('pages.teacher.session-data')

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title">
                    Answer list
                </h4>
            </div>

            <div class="panel-body">
                <div class="col-xs-12 col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 5%">STT</th>
                                <th scope="col">User</th>
                                <th scope="col">Source</th>
                                <th scope="col">Mark</th>
                                <th scope="col" style="width: 8%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($results as $key => $result)
                            <tr>
                                <td style="vertical-align: middle">{{ $key + 1 }}</td>
                                <td style="vertical-align: middle">{{ isset($result->user) ? $result->user->first_name . ' '. $result->user->last_name : '' }}</td>
                                <td style="vertical-align: middle">
                                    @if ($result->source)
                                    <a href="{!! asset('uploads/answers/' . $result->source) !!}" target="_blank">{{ $result->source }}</a>
                                    @endif
                                </td>
                                <td style="vertical-align: middle" class="result_mark_{{ $result->id }}">{{ $result->mark }}</td>
                                <td style="vertical-align: middle; width: 5%;">
                                    <a class="btn btn-success btn-sm detail_answer" url="{{ route('get.detail.answer', $result->id) }}" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fa fa-fw fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="margin-top: 50px">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

            </div>
        </div>
    </div>
@endsection