$(function () {
    $('.select-class').change(function () {
        var url = $(this).attr('url');
        var class_id = $(this).val();

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            async: true,
            data: {
                class_id: class_id
            }
        }).done(function (result) {
            $('.select-subject').html(result.html)
        }).fail(function (XMLHttpRequest, textStatus, thrownError) {
            console.log(thrownError)
        });
    })
    $('.detail_answer').click(function (event) {
        event.preventDefault();
        var url = $(this).attr('url');

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            async: true,
        }).done(function (result) {
            $('.modal-content').html(result.html)
        }).fail(function (XMLHttpRequest, textStatus, thrownError) {
            console.log(thrownError)
        });
    })

    $(document).on('click', '.btn-save-mark', function () {
        var url = $(this).attr('url');
        var mark = $('.mark-assignment').val();

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            async: true,
            data: {
                mark: mark
            }
        }).done(function (result) {
            if (result.code == 200) {
                $('.result_mark_'+ result.result_id).text(result.mark);
                toastr.success('Update success', {timeOut: 3000});
            }
        }).fail(function (XMLHttpRequest, textStatus, thrownError) {
            console.log(thrownError)
        });
    })
})