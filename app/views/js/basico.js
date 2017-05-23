$(document).ready(function () {
    // msg de erro/sucesso

    $(document).tooltip({
        selector: '[data-toggle="tooltip"]'
    });

    $('div.datepicker').datetimepicker({
        locale: 'pt-br',
        viewMode: 'days',
        format: 'DD/MM/YYYY'
    });

    $(document).on('shown.bs.tab', function (e) {
        var tab = $(e.relatedTarget).attr('data-target');

        $(tab+' form').reset();

        $(tab+' form').removeClass('ng-submitted');
        $(tab+' .form-label').each(function() {
            $('.form-label').removeClass('has-error');
        });

        if (tab === '#search') {
            $('#search-result').fadeOut().removeClass('show').addClass('hide');
            $('#noResult').remove();
        } else if (tab === '#create') {
            $('.alert').remove();
        }
    });

    // quando for celular, fechar o menu quando clicar em um link do menu
    var tam = $(window).width();

    if (tam <800 ){
        $(".second-nav li").each(function () {
            $(this).addClass("close-menu");
        });
    } else {
        $(".second-nav li").each(function () {
            $(this).removeClass("close-menu");
        });
    }

    $('.close-menu').on("click", function(){
        $('#sidebar').removeClass('active');
    });

});

/* limpa formulários - form e input sozinho */
jQuery.fn.reset = function (){
    var element = $(this).is("form");
    if (element == true) {
        $(this).each (function(){
           this.reset();
        });
    } else {
        if($(this).is("input")) {
            $(this).val("");
        } else if($(this).is(":radio")) {

            if ( $(this).hasClass('first-option') )
                $(this).prop({ checked: true })
            else
                $(this).prop({ checked: false })

        } else if($(this).is("select")) {
            $(this).prop('selectedIndex',0);
        } else if($(this).is("textarea")) {
            $(this).val("");
        }
    }
};
