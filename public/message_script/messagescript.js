// ---------------- Dashbord page -------------------------
$(document).on('click', '#disconnect_account', function () {
    var instance_key = $('#instance_key').text();
    $.ajax({
        url: "{{ route('customer.logut_instance') }}",
        type: 'POST',
        data: {
            "instance_key": instance_key,
            "_token": $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function (res) {
            console.log('logout: ', res);
            if (res.error == false) {
                $('#instance_key').text();
                $('#connected').hide();
                $('#disconnected').show();
                get_wa_token();
            }
        }
    });
});
// --------------------- campain and quick send dashbord comman js-------------------------
function mediaTypeChange(val) {
    if (val == 'audio') {
        $('#mediaCaption').hide();
        $('#media_image_caption').removeAttr('required');
    } else {
        $('#mediaCaption').show();
        $('#media_image_caption').attr('required', '');
    }

    if (val == 'audio') {
        $('#image_file').attr("accept", "audio/*");
    } else if (val == 'video') {
        $('#image_file').attr("accept", "video/*");
    } else if (val == 'image') {
        $('#image_file').attr("accept", "image/*");
    }
}

function addMoreList(that) {
    $('#list_row_div').append($('#list_row_append').html());
}

/* get html text format like wa message */
function addWsNodes(s) { 
    var waFormat = s;
    waFormat = waFormat.replaceAll("<strong>", " <strong>").replaceAll("</strong>", "</strong> ").replaceAll("<b>",
        " <b>").replaceAll("</b>", "</b> ");
    waFormat = waFormat.replaceAll("<em>", " <em>").replaceAll("</em>", "</em> ").replaceAll("<i>", " <i>")
        .replaceAll("</i>", "</i> ");
    waFormat = waFormat.replaceAll("<s>", " <s>").replaceAll("</s>", "</s> ").replaceAll("<strike>", " <strike>")
        .replaceAll("</strike>", "</strike> ");
    waFormat = waFormat.replaceAll('<p> ', '<p>').replaceAll("</p>", "</p> ").replaceAll('<div> ', '<div>')
        .replaceAll(/<\/p[^>]*>/mgi, '\n');
    waFormat = waFormat.replace(/\n/g, "\\n").replace(/\r/g, "\\r").replace(/\t/g, "\\t").replace(/<br>/g, "\\n");

    return waFormat;
}
/* END -- get html text format like wa message */

/* get html to wa message format */
function prepareFormattedContent(htmlContent) {
    var waFormat = htmlContent
    var trimSpace = $('<div></div>').html(waFormat);
    $(trimSpace).find('strong, b, i, em, s, del, p').each(function (i, v) {
        var $elem = $(this).html();
        $(this).html($elem.trim());
        waFormat = waFormat.replace($elem, v.innerHTML);
    });
    waFormat = waFormat.replace(/&nbsp;/gi, " ").replace(/&amp;/gi, "&").replace(/&quot;/gi, '"').replace(/&lt;/gi,
        '<').replace(/&gt;/gi, '>');
    waFormat = waFormat.replace(/<b [^>]*>/mgi, ' *').replace(/<\/b>/mgi, '* ');
    waFormat = waFormat.replace(/<strong[^>]*>/mgi, ' *').replace(/<\/strong>/mgi, '* ');
    waFormat = waFormat.replace(/<i[^>]*>/mgi, ' _').replace(/<\/i>/mgi, '_ ');
    waFormat = waFormat.replace(/<em[^>]*>/mgi, ' _').replace(/<\/em>/mgi, '_ ');
    waFormat = waFormat.replaceAll('<s>', ' ~').replace(/<s [^>]*>/mgi, ' ~').replace(/<\/s>/mgi, '~ ');
    waFormat = waFormat.replace(/<strike[^>]*>/mgi, ' ~').replace(/<\/strike>/mgi, '~ ');
    waFormat = waFormat.replace(/<del[^>]*>/mgi, ' ~').replace(/<\/del>/mgi, '~ ');
    waFormat = waFormat.replaceAll('<p> ', '<p>').replace('<div> ', '<div>');
    waFormat = waFormat.replace(/<\/p[^>]*>/mgi, '\n').replace(/<\/div[^>]*>/mgi, '\n');
    waFormat = waFormat.replace(/(<([^>]+)>)/mgi, "");
    waFormat = waFormat.replaceAll("_ *", "_*")
        .replaceAll("* _", "*_")
        .replaceAll("~ _", "~_")
        .replaceAll("_ ~", "_~")
        .replaceAll("* ~", "*~")
        .replaceAll("~ *", "~*");
    waFormat.trim();

    return waFormat;
}
/* END - get html to wa message format */
$("body").on("change", "#any_file", function (e) {
    var files = this.files;
    for (var i = 0; i < files.length; i++) {
        var file = files.item(i);
        if (file.type == 'application/pdf') {
            $('.pdf-file').show();
            $('.xlsfile').hide();
            $('.docfile').hide();
            $('.audiovideofile').hide();
            $('.demo-file').hide();
        } else if (file.type == 'application/msword') {
            $('.pdf-file').hide();
            $('.xlsfile').hide();
            $('.docfile').show();
            $('.audiovideofile').hide();
            $('.demo-file').hide();

        } else if (file.type == 'application/vnd.ms-excel' || file.type == 'application/x-msdownload') {
            $('.pdf-file').hide();
            $('.xlsfile').show();
            $('.docfile').hide();
            $('.audiovideofile').hide();
            $('.demo-file').hide();
        } else {
            $('.pdf-file').hide();
            $('.xlsfile').hide();
            $('.docfile').hide();
            $('.audiovideofile').hide();
            $('.demo-file').show();
        }
    }
});

$('#send_message_form2 .send-message').attr('disabled', true);
$('#send_message_form2 #image_number').keyup(function () {
    if ($("#send_message_form2 #image_file").val() != '' && $("#send_message_form2 #image_number").val().length != 0) {
        $('#send_message_form2 .send-message').attr('disabled', false);
    } else {
        $('#send_message_form2 .send-message').attr('disabled', true);
    }
})
$('#send_message_form2 #image_file').change(function () {
    if ($("#send_message_form2 #image_file").val() != '' && $("#send_message_form2 #image_number").val().length != 0) {
        $('#send_message_form2 .send-message').attr('disabled', false);
    } else {
        $('#send_message_form2 .send-message').attr('disabled', true);
    }
})
$('#send_message_form3 .send-message').attr('disabled', true);
$('#send_message_form3 #text_number').keyup(function () {
    if ($("#send_message_form3 #any_file").val() != '' && $("#send_message_form3 #text_number").val().length != 0) {
        $('#send_message_form3 .send-message').attr('disabled', false);
    } else {
        $('#send_message_form3 .send-message').attr('disabled', true);
    }
})
$('#send_message_form3 #any_file').change(function () {
    if ($("#send_message_form3 #any_file").val() != '' && $("#send_message_form3 #text_number").val().length != 0) {
        $('#send_message_form3 .send-message').attr('disabled', false);
    } else {
        $('#send_message_form3 .send-message').attr('disabled', true);
    }
})
$('#send_message_form4 .send-message').attr('disabled', true);
$('#send_message_form4 #contact_number,#send_message_form4 #fullname,#send_message_form4 #displayname,#send_message_form4 #organization,#send_message_form4 #phonenumber').keyup(function () {
    if ($("#send_message_form4 #contact_number").val().length != 0 && $("#send_message_form4 #fullname").val().length != 0 && $("#send_message_form4 #displayname").val().length != 0 && $("#send_message_form4 #organization").val().length != 0 && $("#send_message_form4 #phonenumber").val().length != 0) {
        $('#send_message_form4 .send-message').attr('disabled', false);
    } else {
        $('#send_message_form4 .send-message').attr('disabled', true);
    }
})