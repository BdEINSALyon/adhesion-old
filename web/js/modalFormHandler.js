/**
 * Created by pvienne on 26/08/15.
 */
$(function(){
});

/**
 * Send a form by an ajax request.
 * The form should be in a bootstrap modal. If the server return a 200 result, then the modal is closed, otherwise on
 * failure, the result from the request is put as the new content of this modal.
 * @param event The event on the summit form.
 */
$.sendModalForm = function(event) {
    event.preventDefault();
    var callback = (arguments.callee);
    var $form = $(event.target);
    var $submitButton = $form.find(':submit');
    var $modal = $form.closest('.modal');
    var originHtml = $submitButton.html();
    $submitButton.html(animation.canvas).removeClass("btn-primary").attr("type","button");
    animation.play();
    $.ajax({
        type: $form.attr('method'),
        url: $form.attr('action'),
        data: $form.serialize()
    }).always(function(){
        animation.stop();
        $submitButton.html(originHtml).addClass("btn-primary").attr("type","submit");;
    }).done(function () {
        $form.off('submit',callback);
        $modal.modal('hide');
        refreshStudentDetails();
        setTimeout(function () {
            $modal.find('.modal-content').html('Loading ...');
        },500);
    }).fail(function (data) {
        $modal.find('.modal-dialog > .modal-content').html(data.responseText);
    });
}; 