<div class="container-fluid">
    <form role="form" action="{{ route('student.assignment.answer', $assignment->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <!-- form start -->
                    <div class="card-body">
                        <div class="form-group {{ $errors->first('description') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="control-label default">Description <sup class="text-danger">(*)</sup></label>
                            <div>
                                <textarea name="description" style="resize:vertical" id="description" class="form-control" placeholder="">{{ old('description', isset($result) ? $result->description : '') }}</textarea>
                                <script>
                                    ckeditor(description);
                                </script>
                                <span class="text-danger"><p class="mg-t-5">{{ $errors->first('description') }}</p></span>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('source') ? 'has-error' : '' }} ">
                            <label for="inputEmail3" class="control-label default">Source </label>
                            <div>
                                <input type="file" class="form-control" name="source" value="">
                                <span class="text-danger "><p class="mg-t-5">{{ $errors->first('source') }}</p></span>
                                @if (!empty($result->source))
                                <p><a href="{!! asset('uploads/assignments/' . $result->source) !!}" target="_blank">{{ $result->source }}</a></p>
                                @endif
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="btn-set">
                            <button type="submit" name="submit" class="btn btn-info">
                                <i class="fa fa-save"></i> Save
                            </button>
                            <button type="reset" name="reset" value="reset" class="btn btn-danger">
                                <i class="fa fa-undo"></i> Reset
                            </button>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </form>
</div>
