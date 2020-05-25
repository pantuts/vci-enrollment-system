$(document).ready(function(){

    $.ajaxSetup({ cache: false });

    // for debugging
    function log(s) {
        console.log(s);
    }
    // json encoded error parsing from php
    function parseError(data){
        var obj = jQuery.parseJSON(JSON.stringify(data));
        return obj.error;
        // .error comes from php json encoded msg { 'error': 'something error' }
    }

    // delete click for all registers
    function deleteReg(parentElement, childElement, studnumElement, studnumElParent, redLoc) {
        $(parentElement).find(childElement).click(function(){
            var confrm = confirm('Are you sure you want to delete this entry?');
            if (confrm == true) {
                var studnum = $(this).parents(studnumElParent).find(studnumElement).text();
                // alert(studnum);
                // ajax call
                $.ajax({
                    url: './delete.php',
                    type: 'POST',
                    data: 'studnum=' + studnum,
                    success: function(data) {
                        alert('Entry with Student #: ' + studnum + ' deleted.');
                        window.location = redLoc;
                        return false;
                    },
                    error: function(data) {
                        log(parseError(data));
                        alert('Problem occured on server, incorrect sql parameter or process error.');
                        return false;
                    }
                });
                return false;
            }
            return false;
        });
    }
    // delete at pre-en-edit.php
    deleteReg('.pre-en-edit', '.save span.delR', '.right .studnum', '.pre-en-edit', './panel-pre-enrollees.php');
    // delete at panel-pre-enrollees.php
    deleteReg('.pre-ens', 'li span.del', 'li.studnum', '.pre-ens', './panel-pre-enrollees.php');
    // delete at panel-enrollees.php
    deleteReg('.enrol', 'li span.del', 'li.studnum', '.enrol ul', './panel-enrollees.php');
    // delete at enrollee.php
    deleteReg('.enrollee', 'span.delR', '.right span.studnum', '.enrollee', './panel-enrollees.php');
    // $('.enrollee span.delR').click(function(){
    //     alert($(this).parents('.enrollee').find('.right .studnum').text())
    // });

    // search keypress on pre-en: pre-enrollees
    $(function(){
        $('.pre-en-search input#search').keypress(function(e) {
            if (e.keyCode === 13) {
                var s = $(this).val();
                if (s) {
                    window.location = './panel-pre-enrollees.php?search=' + s.replace(/ /g, '+');
                }
            }
        });
    });

    // click event for pre-enrollees view
    $('.pre-ens .view').click(function(s){
        var studnum = $(this).closest('ul').find('.studnum').text();
        var year = $(this).closest('ul').find('.year').text();
        var sem = $(this).closest('ul').find('.sem').text();
        var course = $(this).closest('ul').find('.cour').text();
        switch (course) {
            case 'BS Information Technology':
                course = 'bsit';
                break;
            case 'BS Computer Science':
                course = 'bscs';
                break;
            case 'BS Business Administration':
                course = 'bsba';
                break;
            case 'BS Criminology':
                course = 'bscrim';
                break;
            default:
                alert('What course is this?');
                return false;
        }
        window.location = './pre-en-edit.php?studnum=' + studnum + '&year=' + year + '&sem=' + sem + '&course=' + course;
        return false;
    });

    // click event for pre-en-edit.php delete subject
    $('.pre-en-edit').find('.cosubs').on('click', 'li.action', function(s){
        $('.pre-en-edit .addsubj').append($(this).parents('ul.subjects').clone());
        // dynamic set text of delete to add
        $('.pre-en-edit .addsubj li.action').text('Add').css({ color: '#05a1a7'});
        $(this).parents('ul').remove();
        return false;
    });

    // click event for pre-en-edit.php to add subjects
    $('.pre-en-edit').find('.addsubj').on('click', 'li.action', function(s){
        var i = $(this).attr('class');
        $('.pre-en-edit .cosubs').append($(this).parents('ul.subjects').clone());
        // dynamic set text of add to delete
        $('.pre-en-edit .cosubs .subjects li.action').text('Delete').css({ color: 'red'});
        $(this).parents('ul').remove();
        return false;
    });

    // click event for pre-en-edit.php save
    $('.pre-en-edit').find('.save span.saveR').click(function(){
        // get all subject codes
        var subCodes = '';
        $('.pre-en-edit .cosubs .subjects .fcode').each(function(){
            subCodes = subCodes + encodeURIComponent($(this).text()) + '$'
        });
        if (subCodes) {
            var confrm = confirm('Continue saving?');
            if (confrm == true) {
                var studnum = $('.pre-en-edit .profile .right .studnum').text();
                // ajax call
                $.ajax({
                    url: './pre-en-save.php',
                    type: 'POST',
                    data: 'subjects=' + subCodes + '&studnum=' + studnum,
                    success: function(data) {
                        alert('Successfully updated the registers.');
                        window.location = './panel-pre-enrollees.php';
                        return false;
                    },
                    error: function(data) {
                        log(parseError(data));
                        alert('Problem occured on server, incorrect sql parameter or process error.');
                        return false;
                    }
                });
                return false;
            }
        } else {
            alert('There are no subjects to save, add subjects or remove student pre-registration instead.');
        }
        return false;
    });

    // panel-enrollees click view event
    $(function(){
        $('.enrol .view').click(function(){
            var studnum = $(this).closest('ul').find('.studnum').text();
            var year = $(this).closest('ul').find('.year').text();
            var sem = $(this).closest('ul').find('.sem').text();
            var course = $(this).closest('ul').find('.cour').text();
            switch (course) {
                case 'BS Information Technology':
                    course = 'bsit';
                    break;
                case 'BS Computer Science':
                    course = 'bscs';
                    break;
                case 'BS Business Administration':
                    course = 'bsit';
                    break;
                case 'BS Criminology':
                    course = 'bscrim';
                    break;
                default:
                    alert('What course is this?');
                    return false;
            }
            window.location = './enrollee.php?studnum=' + studnum + '&year=' + year + '&sem=' + sem + '&course=' + course;
            return false;
        });
    });

    // search keypress on pre-en: pre-enrollees
    $(function(){
        $('.en-search input#search').keypress(function(e) {
            if (e.keyCode === 13) {
                var s = $(this).val();
                if (s) {
                    window.location = './panel-enrollees.php?search=' + s.replace(/ /g, '+');
                }
            }
        });
    });


    // schedule/subjects
    // selected course
    $('.sched select').on('change', function(){
        var course = $(this).val();
        if (course != '') {
            $.ajax({
                url: './subjects-load.php',
                type: 'POST',
                data: 'course=' + course,
                success: function(s) {
                    $('.sched .subjects').empty();
                    $('.sched .subjects').append(s);
                },
                error: function(s) {
                    console.log(jQuery.parseJSON(JSON.stringify(s)));
                    alert('Server or SQL Error');
                }
            });
            return false;
        } else {
            $('.sched .subjects').empty();
            curCode = '';
        }
        return false;
    });

    // filter by year
    $(function(){
        $('.sched').on('change', 'input[type="radio"]', function(){
            curCode = '';
            var radioNum = $(this).val();
            // alert(radioNum);
            if (radioNum == 'all') {
                $('.sched .subjects ul').hide();
                $('.sched .subjects ul').show();
            } else {
                $('.sched .subjects').children('ul').show();
                $('.sched .subjects').children('ul:not(.' + radioNum + ')').hide();
                $('.sched .subjects ul.rowtitle').show();
            }
            return false;
        });
        return false;
    });

    // edit clicked
    var curCode = '';
    $('.sched').on('click', '.subjects ul li.edit', function() {
        if (newCode != '') {
            alert('Pending edit, save first.');
            $('.sched .subjects').find('input:enabled:visible').parents('ul').find('input:first').focus();
            return false;
        } else {
            $('.sched .subjects input[type="text"]').attr('disabled', true);
            $(this).parents('ul').find('input').attr('disabled', false);
            $(this).parents('ul').find(':input:enabled:visible:first').focus();
            curCode = '';
            curCode = $(this).parents('ul').find(':input:enabled:visible:first').val();
            // remove and add ready class to parent ul to use by keypress
            $('.sched .subjects ul').removeClass('ready');
            $(this).parents('ul').addClass('ready');
            return false;
        }
    });

    // save edit after enter
    $(function(){
        // check if enter is pressed
        $(document).keypress(function(e){
            if (e.keyCode === 13) {
                // check if ul has a ready class then call ajax
                // if (ulReady.hasClass('ready')) {
                // curCode = $('.subjects ul.ready :input:enabled:visible:first').val();
                // alert(curCode);
                if (curCode != '' && newCode == '') {
                    // alert(curCode);
                    var ulReady = $('.sched .subjects ul.ready');
                    var ccode = encodeURIComponent(ulReady.find('li.code input').val());
                    var desc = encodeURIComponent(ulReady.find('li.desc input').val());
                    var units = encodeURIComponent(ulReady.find('li.units input').val());
                    var time = encodeURIComponent(ulReady.find('li.time input').val());
                    var sem = encodeURIComponent(ulReady.find('li.sem input').val());
                    var yr = encodeURIComponent(ulReady.find('li.year input').val());
                    var room = encodeURIComponent(ulReady.find('li.room input').val());
                    var course = encodeURIComponent($('.sched select').val());
                    var dataS = 'code=' + ccode + '&desc=' + desc + '&units=' + units + '&time=' + time
                        + '&sem=' + sem + '&year=' + yr + '&room=' + room + '&course=' + course + '&curcode=' + encodeURIComponent(curCode);
                    // alert(data);
                    // alert(ccode);
                    if (curCode != '' && ccode != '' && desc != '' && units != '' && time != '' && sem != '' && yr != '' && room != '') {
                        $.ajax({
                            url: './subject-save.php',
                            type: 'POST',
                            data: dataS,
                            success: function(s) {
                                console.log(jQuery.parseJSON(JSON.stringify(s)))
                                ulReady.find('li.code input').attr('value', decodeURIComponent(ccode));
                                ulReady.find('li.desc input').attr('value', decodeURIComponent(desc));
                                ulReady.find('li.units input').attr('value', decodeURIComponent(units));
                                ulReady.find('li.time input').attr('value', decodeURIComponent(time));
                                ulReady.find('li.sem input').attr('value', decodeURIComponent(sem));
                                ulReady.find('li.year input').attr('value', decodeURIComponent(yr));
                                ulReady.find('li.room input').attr('value', decodeURIComponent(room));
                                ulReady.find('input').attr('disabled', true);
                                ulReady.removeClass('ready');
                                curCode = '';
                                newCode = '';
                            },
                            error: function(s) {
                                console.log(jQuery.parseJSON(JSON.stringify(s)));
                                alert('Server or SQL Error');
                            }
                        });
                    } else {
                        alert('Empty field/s?');
                        return false;
                    }
                    
                    // ulReady.find('input').attr('disabled', true);
                    // curCode = '';
                    return false;

                } else if (newCode != '' ){
                    // alert('test');
                    var ulNew = $('.sched .subjects ul.newcode');
                    var ccode = encodeURIComponent(ulNew.find('li.code input').val());
                    var desc = encodeURIComponent(ulNew.find('li.desc input').val());
                    var units = encodeURIComponent(ulNew.find('li.units input').val());
                    var time = encodeURIComponent(ulNew.find('li.time input').val());
                    var sem = encodeURIComponent(ulNew.find('li.sem input').val());
                    var yr = encodeURIComponent(ulNew.find('li.year input').val());
                    var room = encodeURIComponent(ulNew.find('li.room input').val());
                    var course = encodeURIComponent($('.sched select').val());
                    var dataS = 'code=' + ccode + '&desc=' + desc + '&units=' + units + '&time=' + time
                        + '&sem=' + sem + '&year=' + yr + '&room=' + room + '&course=' + course + '&curcode=' + ccode + '&new=new';
                    // alert(ccode);
                    if (ccode != '' && desc != '' && units != '' && time != '' && sem != '' && yr != '' && room != '') {
                        $.ajax({
                            url: './subject-save.php',
                            type: 'POST',
                            data: dataS,
                            success: function(s) {
                                console.log(jQuery.parseJSON(JSON.stringify(s)))
                                ulNew.find('li.code input').attr('value', decodeURIComponent(ccode));
                                ulNew.find('li.desc input').attr('value', decodeURIComponent(desc));
                                ulNew.find('li.units input').attr('value', decodeURIComponent(units));
                                ulNew.find('li.time input').attr('value', decodeURIComponent(time));
                                ulNew.find('li.sem input').attr('value', decodeURIComponent(sem));
                                ulNew.find('li.year input').attr('value', decodeURIComponent(yr));
                                ulNew.find('li.room input').attr('value', decodeURIComponent(room));
                                ulNew.find('input').attr('disabled', true);
                                ulNew.addClass(yr).removeClass('newcode');
                                newCode = '';
                                curCode = '';
                            },
                            error: function(s) {
                                console.log(jQuery.parseJSON(JSON.stringify(s)));
                                alert('Existing subject / SQL error.');
                            }
                        });
                    } else {
                        alert('Empty field/s?');
                        return false;
                    }

                } else {
                    //
                }

            } else {
                return true;
            }

            return false;
        });
        return false;
    });

    // add subject event
    var newCode = '';
    $('.sched .subjects').on('click', '.addsubj', function(){
        var ulReady = $('.sched .subjects').find('ul.ready');
        if (newCode != '' || curCode != '') {
            alert('Easy fella, you still have a pending edit');
            return false;
        } else {
            newCode = '';
            newCode = '1';
            var par = $(this).parents('.subjects').find('ul:not(.rowtitle):first');
            par.before('<ul class="newcode">'
                 +   '<li class="code"><input type="text" name="code" value="" disabled="disabled" ></li>'
                 +   '<li class="desc"><input type="text" name="desc" value="" disabled="disabled" ></li>'
                 +   '<li class="units"><input type="text" name="units" value="" disabled="disabled" ></li>'
                 +   '<li class="time"><input type="text" name="time" value="" disabled="disabled" ></li>'
                 +   '<li class="room"><input type="text" name="time" value="" disabled="disabled" ></li>'
                 +   '<li class="sem"><input type="text" name="time" value="" disabled="disabled" ></li>'
                 +   '<li class="year"><input type="text" name="time" value="" disabled="disabled" ></li>'
                 +   '<li class="edit">Edit</li>'
                 +   '<li class="delete">Delete</li>'
                 +   '</ul>'
            );
            $(this).parents('.subjects').find('.newcode input').attr('disabled', false).parents('ul').find('input:first').focus();
        }
    });

    // delete subject event
    $('.sched .subjects').on('click', '.delete', function(){
        var parUL = $(this).parents('ul');
        var code = encodeURIComponent(parUL.find('li.code input').val());
        var course = encodeURIComponent($('.sched select').val());
        var dataS = 'code=' + code + '&course=' + course;
        var ulReady = $('.sched .subjects').find('ul.ready');
        // alert(dataS);
        if (curCode != '' || newCode != '') {
            alert('You still have pending edit.');
            return false;
        } else {
            var confrm = confirm('Delete subject?');
            if (confrm == true) {
                if (code) {
                    $.ajax({
                        url: './subject-delete.php',
                        type: 'POST',
                        data: dataS,
                        success: function(s){
                            console.log(jQuery.parseJSON(JSON.stringify(s)));
                            newCode = '';
                        },
                        error: function(s){
                            console.log(jQuery.parseJSON(JSON.stringify(s)));
                            alert('Server or SQL Error');
                        },
                    });
                }
                $(this).parents('ul').remove();
            }
            return false;
        }
        return false;
    });

    
    // calendar events
    var emonth = '';
    var eyear = '';
    $('.events .month .smonth').on('change', 'input[type="radio"]', function(){
        emonth = $(this).val();
        eyear = $(this).parents('div').find('select[name="year"]').val();
        eid = '';
        enew = '';
        // alert(eyear);
        var dataS = 'month=' + encodeURIComponent(emonth) + '&year=' + encodeURIComponent(eyear);
        $.ajax({
            url: './calevents-load.php',
            type: 'POST',
            data: dataS,
            success: function(s){
                $('.events .eventinp').empty();
                $('.events .eventinp').html(s);
            },
            error: function(s){
                var res = jQuery.parseJSON(JSON.stringify(s));
                console.log(res);
                alert(res.message);
            }
        });
        return false;
    });

    // calendar edit event
    var eid = '';
    $(function(){
        $('.eventinp').on('click', 'li.edit', function(){
            if (eid != '' || enew != '') {
                alert('Pending edit...');
                $('.eventinp').find('input:enabled:visible').parents('ul').find('input:first').focus();
                return false;
            } else {
                $('.eventinp input[type="text"]').attr('disabled', true);
                $(this).parents('ul').addClass('ulReady');
                $(this).parents('ul').find('input').attr('disabled', false);
                $(this).parents('ul').find(':input:enabled:visible:first').focus();
                eid = '';
                eid = $(this).parents('ul').find('li.eid').text();
            }
        });
        return false;
    });

    // calendar: enter pressed
    $(function(){
        $(document).on('keypress', function(e){
            if (e.keyCode === 13) {
                if (day == '' || ev == '') {
                    alert('Empty field/s?');
                    return false;
                } else if (eid != '' && enew == '') {
                    var year = encodeURIComponent(eyear);
                    var month = encodeURIComponent(emonth);
                    var day = encodeURIComponent($('.eventinp').find('.ulReady li input[name="day"]').val());
                    var ev = encodeURIComponent($('.eventinp').find('.ulReady li input[name="desc"]').val());
                    var ulReady = $('.eventinp ul.ready');
                    var id = encodeURIComponent($('.eventinp').find('.ulReady li.eid').text());
                    var dataS = 'month=' + month + '&year=' + year + '&day=' + day + '&description=' + ev + '&id=' + id + '&edit=old';
                    // alert(dataS);
                    // alert(id);
                    if ($.isNumeric(day) == false || day > 31) {
                        alert('Really? Idiot!');
                        return false;
                    } else {
                        $.ajax({
                            url: './calevent-save.php',
                            type: 'POST',
                            data: dataS,
                            success: function(s){
                                ulReady.find('li input[name="day"]').attr('value', decodeURIComponent(day));
                                ulReady.find('li input[name="desc"]').attr('value', decodeURIComponent(ev));
                                $('.eventinp').find('ul.ulReady li input:enabled').attr('disabled', true);
                                $('.eventinp').find('ul.ulReady').removeClass('ulReady');
                                eid = '';
                                enew = '';
                            },
                            error: function(s){
                                var res = jQuery.parseJSON(JSON.stringify(s));
                                console.log(res);
                                alert('Possible errors: Event exists or SQL error');
                                $('.eventinp').find('ul.ulReady').remove();
                                eid = '';
                                enew = '';
                            }
                        });
                    }
                    return false;
                } else if (enew != ''){
                    var year = encodeURIComponent(eyear);
                    var month = encodeURIComponent(emonth);
                    var day = encodeURIComponent($('.eventinp').find('.ulReady li input[name="day"]').val());
                    var ev = encodeURIComponent($('.eventinp').find('.ulReady li input[name="desc"]').val());
                    var ulReady = $('.eventinp ul.ready');
                    var dataS = 'month=' + month + '&year=' + year + '&day=' + day + '&description=' + ev + '&edit=new';
                    // alert(dataS)
                    if ($.isNumeric(day) == false || day > 31) {
                        alert('Really? Idiot!');
                        return false;
                    } else {
                        $.ajax({
                            url: './calevent-save.php',
                            type: 'POST',
                            data: dataS,
                            success: function(s){
                                var sLog = jQuery.parseJSON(s);
                                ulReady.find('li input[name="day"]').attr('value', decodeURIComponent(day));
                                ulReady.find('li input[name="desc"]').attr('value', decodeURIComponent(ev));
                                var ins = $('.eventinp').find('.ulReady');
                                ins.append('<li class="eid" style="display:none;">' + sLog.newid + '</li>');
                                $('.eventinp').find('ul.ulReady li input:enabled').attr('disabled', true);
                                $('.eventinp').find('ul.ulReady').removeClass('ulReady');
                                eid = '';
                                enew = '';
                                alert('Successfully added.');
                                console.log('newid: ' + sLog.newid);
                            },
                            error: function(s){
                                var res = jQuery.parseJSON(JSON.stringify(s));
                                console.log(res);
                                alert('Possible errors: Event exists or SQL error');
                                $('.eventinp').find('ul.ulReady').remove();
                                eid = '';
                                enew = '';
                            }
                        });
                    }
                } else {

                }
            } else {
                return true;
            }
            return false;
        });
    });

    // add event clicked
    var enew = '';
    $(function(){
        $('.eventinp').on('click', 'span.addev', function(){
            if (enew != '' || eid != '') {
                alert('Pending edit...');
                return false;
            } else {
                // alert();
                enew = '1';
                var par = $(this).parents('.eventinp').find('ul');
                $(this).parents('.eventinp').find('p').after('<ul class="ulReady">'
                    +   '<li class="d"><input type="text" name="day" maxlength="2" placeholder="Day"></li>'
                    +   '<li class="e"><input type="text" name="desc" maxlength="180" placeholder="Event description"></li>'
                    +   '<li class="edit"><span>Edit</span></li>'
                    +   '<li class="del"><span>Delete</span></li>'
                    +   '</ul>'
                );
                $(this).parents('.eventinp').find('ul li input:enabled:first').focus();
                return false;
            }
        });
        return false;
    });

    // delete calendar event
    $(function(){
        $('.eventinp').on('click', 'li.del', function(){
            if (eid != '' || enew != '') {
                alert('Pending edit...');
                return false;
            } else {
                var id = $(this).parents('ul').find('li.eid').text();
                // alert(id);
                var confrm = confirm('Are you sure you want to delete this?');
                if (confrm == true) {
                    $.ajax({
                        url: './calevent-delete.php',
                        type: 'POST',
                        data: 'id=' + encodeURIComponent(id),
                        success: function(s){
                            console.log(jQuery.parseJSON(JSON.stringify(s)));
                        },
                        error: function(s){
                            console.log(jQuery.parseJSON(JSON.stringify(s)));
                            alert('Delete error: server or sql error.');
                        }
                    });
                    $(this).parents('ul').remove();
                }
            }
            return false;
        });
    });
    
});