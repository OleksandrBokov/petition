$('.carousel').carousel({interval: 6000});

$(document).on('mousemove',function(e){
    var cor = e.pageX,
        w = $(this).width(),
        mov = (w/3-cor)/(w/3);
    $('.parallax-layer').each(function(i){
        var l = 10 + i*60;
        $("#layer1").css('left', (l-(190*i*mov))+'px' );
        $("#layer5").css('left', (l-(70*i*mov))+'px' );
        $("#layer6").css('left', (l-(30*i*mov))+'px' );
    });
    $('.parallax-layerleft').each(function(i){
        var l = 900 + i*200;
        $("#layer3").css('left', (l+(300*i*mov))+'px' );
        $("#layer7").css('left', (l+(700*i*mov))+'px' );
    });
    $('.parallax-layercenter').each(function(i){
        var l = 1000 + i*300;
        $("#layer4").css('left', (l-(400*i*mov))+'px' );
        $("#layer2").css('left', (l-(90*i*mov))+'px' );
    });
});

$(document).ready(function() {
    $(document).on('click', '.dropdown-menu', function (e) {
        $(this).hasClass('login-form') && e.stopPropagation();
    });
});

$(document).ready(function() {
    var sportSelector = '#select-sport';
    var metroSelector = '#select-metro';

    setCountSportChecked(sportSelector);
    setCountMetroChecked(metroSelector);

    $(".toggle-filter").click(function () {
        $('#filter').slideToggle(0);
        return false;
    });

    // $("#filter").on('click',function(){
    //     $(".toggle-filter").hide();
    //    // console.log('click')
    // });

    $(sportSelector).on('click',function () {
        setCountSportChecked(sportSelector);
    });
    $(metroSelector).on('click',function () {
        setCountMetroChecked(metroSelector);
    });

    var minPrice =  $("input#minVall");
    var maxPrice =  $("input#maxVall");
    var min = parseInt(minPrice.attr('placeholder'));
    var max = parseInt(maxPrice.attr('placeholder'));
    var currentMin = min;
    var currentMax = max;
    if(minPrice.val())
        currentMin = minPrice.val();
    if(maxPrice.val())
        currentMax = maxPrice.val();

    $("#sliderVall").slider({
        min: min,
        max: max,
        values: [currentMin,currentMax],
        range: true,
        slide: function(event, ui){
            minPrice.val($(this).slider("values",0));
            maxPrice.val($(this).slider("values",1));
        }
    });
    minPrice.keyup(function(){
        var value = $(this).attr('placeholder');
        if($(this).val()) value = parseInt($(this).val());
        $("#sliderVall").slider("values",0,value);

    });
    maxPrice.keyup(function(){
        var value = $(this).attr('placeholder');
        if($(this).val()) value = parseInt($(this).val());
        $("#sliderVall").slider("values",1,value);
    });
    $(document).keypress(function(e) {
        if(e.which == 13) {
            e.preventDefault()
        }
    });
    // фильтрация ввода
    $('.filter-item  input').keypress(function(event){
        var key, keyChar;
        if(!event) var event = window.event;
        if (event.keyCode) key = event.keyCode;
        else if(event.which) key = event.which;
        keyChar=String.fromCharCode(key);
        if(!/\d/.test(keyChar))	return false;
    });

    //$(document).find('[data-toggle]').tooltip();

    $('body').tooltip({
        selector: '[data-toggle="tooltip"]'
    });

    $(".show-tel").click(function () {
        $('.popover-info').slideToggle(0);
        return false;
    });

    $(".description-location").on("click", ".link-item", function (event) {
        event.preventDefault();
        var id = $(this).attr('href')
            , top = $(id).offset().top;
        $('body,html').animate({
            scrollTop: top
        }, 1000);
    });

    $(".others-sports").click(function(e){$('.popover-sports').css('display', 'block'); });
    $('.page-profil').mouseup(function (e) {
        var container = $(".popover-sports");
        if (container.has(e.target).length === 0){
            container.hide();
        }
    });
    $('#radioButtonList').radio();

//	close filter-dropdown-menu
    $(".btn-group .open-list").click(function() {
        var li = $(this).parent(),
            subMenu = li.find(".filter-dropdown-menu");
        li.toggleClass("opened");
        subMenu.stop().slideToggle(0)
        var close = function(e) {
            if (!$(e.target).closest(li).length) {
                subMenu.removeClass("opened").slideUp(0, function() {
                    li.removeClass("opened");
                });
                $('.filter-list').unbind("click", close)
            }
        }
        $('.filter-list').bind("click", close)
    });

    $(document).find(".radio_buttons.human input:checked[type='radio']").addClass('bounce');
    $(".radio_buttons.human input[type='radio']").click(function() {
        $(this).prop('checked', false);
        $(this).toggleClass('bounce');
        if( $(this).hasClass('bounce') ) {
            $(this).prop('checked', true);
            $(document).find(".radio_buttons.human input:not(:checked)[type='radio']").removeClass('bounce');
        }
    });

    $('a.personal-area').click(function (e) {
        $('.login-form.dropdown-menu').toggle();
        e.stopPropagation();
    });
    $('.login a.dropdown-toggle').click(function (e) {
        $('.login-form.dropdown-menu').toggle();
        e.stopPropagation();
    });

});


function setCountSportChecked(selector) {
    var count = $(selector).find('input[type=checkbox]:checked').length;
    var label = $('.check-w');
    //label.html(Yii.t('main','n==0#выберите вид спорта|n==1#выбран {cnt} вид спорта|n<=4#выбрано {cnt} вида спорта|n>4#выбрано {cnt} видов спорта',{n:count,cnt:count}));
}

function setCountMetroChecked(selector) {
    var count = $(selector).find('input[type=checkbox]:checked').length;
    var label = $('.check-m');
    //label.html(Yii.t('main','n==0#выберите станцию|n==1#выбрана {cnt} станция|n<=4#выбрано {cnt} станции|n>4#выбрано {cnt} станций',{n:count,cnt:count}));
}
