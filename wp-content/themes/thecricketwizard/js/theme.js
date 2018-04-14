jQuery(function($) {
    var $ = jQuery;
    $("[name*='r_password']").attr("type", "password");
    $("[name*='r_confirm_password']").attr("type", "password");
    $(".submit-form").click(function() {
        // check passwords match
        if($("[name='r_password']").val() != $("[name='r_confirm_password']").val()) {
            alert("Passwords do not match");
        } else {
            // submit form
            $('.wpcf7-form').submit();
        }
    });
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });

    $(".search").keyup(function () {
        var searchTerm = $(".search").val();
        var listItem = $('.results tbody').children('tr');
        var searchSplit = searchTerm.replace(/ /g, "'):containsi('")

        $.extend($.expr[':'], {'containsi': function(elem, i, match, array){
            return (elem.textContent || elem.innerText || '').toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
        }
        });

        $(".results tbody tr").not(":containsi('" + searchSplit + "')").each(function(e){
            $(this).attr('visible','false');
        });

        $(".results tbody tr:containsi('" + searchSplit + "')").each(function(e){
            $(this).attr('visible','true');
        });

        var jobCount = $('.results tbody tr[visible="true"]').length;
        $('.counter').text(jobCount + ' item');

        if(jobCount == '0') {$('.no-result').show();}
        else {$('.no-result').hide();}
    });
});

function openModal(modalid) {
    var $ = jQuery;
    $(modalid).addClass('dropIn');
}
function closeModal() {
    var $ = jQuery;
    $(".modal").removeClass('dropIn');
}