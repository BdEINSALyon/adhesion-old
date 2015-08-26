/**
 * Created by pvienne on 26/08/15.
 */

var loader = {
    width: 20,
    height: 20,
    stepsPerFrame: 3,
    trailLength: 1,
    pointDistance: .01,
    fps: 30,
    step: 'fader',
    strokeColor: '#337ab7',
    setup: function() {
        this._.lineWidth = 2;
    },
    path: [
        ['arc', 10, 10, 4, 360, 0]
    ]
};

var animation = new Sonic(loader);

function sendModalForm(event) {
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
}

function refreshStudentDetails(){
    voir(currentStudentId());
}

function currentStudentId(){
    return $("#etuid").data("etu-id");
}