<div class="modal-header">
    <h4 class="modal-title" id="myLargeModalLabel">{{ isset($result->user) ? $result->user->first_name . ' ' . $result->user->last_name : '' }}</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <div>
        <h5>Assignment title : {{ isset($result->assignment) ? $result->assignment->title : '' }}</h5>
    </div>
    <div>
        <h5>Answer</h5>
        {!! $result->description !!}
    </div>
</div>
<div class="footer" style="border-top: 1px solid #dee2e6; padding: 15px">
    <div class="row">
        <div class="col-md-6">
            <input type="number" class="form-control mark-assignment" name="mark" placeholder="Mark" value="{{ isset($result) && !empty($result->mark) ? $result->mark : '' }}">
        </div>
        <div class="col-md-6">
            <button type="button" class="btn btn-success btn-save-mark" style="padding: 8px 10px !important;" url="{{ route('update.mark.answer', $result->id) }}"> Save</button>
        </div>
    </div>
</div>