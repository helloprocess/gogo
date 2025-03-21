var base_url = "{{ globals.base_url_general }}",
    base_cache = "{{ globals.cache_dir }}",
    version_id = "v_{{ globals.v }}",
    base_static = "{{ globals.base_static_noversion }}",
    is_mobile = "{{ globals.mobile }}" === "1",
    current_user = parseInt("{{ current_user.user_id }}", 10),
    current_user_admin = "{% if current_user.admin %}true{% else %}false{% endif %}",
    touchable = false,
    loadedJavascript = [],
    do_partial = "{% if globals.allow_partial %}true{% else %}false{% endif %}",
    lastScrollTop = 0;




function stringToBoolean(str) {
    return str.toLowerCase() === "true";
}

current_user_admin = stringToBoolean(current_user_admin);

if ((typeof window.history === 'object') && (do_partial || navigator.userAgent.match(/meneame/i))) {
    do_partial = true;
}

var now = (new Date);
var now_ts = now.getTime();

function to_date(index) {
    var str;
    var $e = $(this);
    var ts = $e.data('ts');

    if (typeof ts !== 'number' || !ts) {
        return;
    }

    ts *= 1000;

    var d = new Date(ts);

    var dd = function(d) {
        return (d < 10) ? ("0" + d) : d;
    };

    var diff = Math.floor((now_ts - ts) / 1000);

    if (diff < 3600 && diff > 0) {
        if (diff < 60) {
            str = "{% trans _('hace') %} " + diff + " {% trans _('seg') %}";
        } else {
            str = "{% trans _('hace') %} " + Math.floor(diff / 60) + " {% trans _('min') %}";
        }
    } else {
        str = "";

        if (diff > 43200) { /* 12 hs */
            str += dd(d.getDate()) + "/" + dd(d.getMonth() + 1);

            if (now.getFullYear() != d.getFullYear()) {
                str += "/" + d.getFullYear();
            }
        }

        str += " " + dd(d.getHours()) + ":" + dd(d.getMinutes());
    }

    $e.attr('title', ($e.attr('title') || '') + str);

    if (!$e.hasClass("novisible")) {
        $e.html(str);
    }
}

function redirect(url) {
    document.location = url;
}

function menealo(user, id) {
    var content = "id=" + id + "&user=" + user + "&key=" + base_key + "&l=" + link_id + "&u=" + encodeURIComponent(document.referrer);
    var url = base_url + "backend/menealo?" + content;

    disable_vote_link(id, -1, "...", '');

    $.getJSON(url, function(data) {
        parseLinkAnswer(id, data);
    });

    reportAjaxStats('vote', 'link');
}

var votePending = [];

function setVotePending(key, $voted, $notvoted) {
    if ((typeof votePending[key] !== 'undefined') && votePending[key]) {
        clearTimeout(votePending[key]);
    }

    if ($voted.hasClass('voted')) {
        $voted.removeClass('voted pending').addClass('unhover');
        return false;
    }

    $voted.removeClass('unhover').addClass('voted pending');
    $notvoted.removeClass('unhover voted pending');

    return true;
}

function vote(type, user, id, value) {
    if ((type !== 'comment') && (type !== 'post')) {
        return;
    }

    var key = type + '-' + id;
    var $voted, $notvoted;

    if (value > 0) {
        $voted = 'up';
        $notvoted = 'down';
    } else {
        $voted = 'down';
        $notvoted = 'up';
    }

    $voted = $('[data-id="' + key + '"] .vote.' + $voted);
    $notvoted = $('[data-id="' + key + '"] .vote.' + $notvoted);

    if (!setVotePending(key, $voted, $notvoted)) {
        return;
    }

    votePending[key] = setTimeout(function() {
        var url = base_url + 'backend/menealo_' + type;
        var content = 'id=' + id + '&user=' + user + '&value=' + value + '&key=' + base_key + '&l=' + link_id;

        $.getJSON(url + '?' + content, function(data) {
            updateVote($voted, $notvoted, id, data);
        });

        reportAjaxStats('vote', type);

        votePending[key] = null;
    }, 2000);
}

function updateVote($voted, $notvoted, id, data) {
    if (data.error) {
        return mDialog.notify("{% trans _('Error:') %} " + data.error, 5);
    }

    var $container = $voted.closest('.comment');

    $container.find('#vc-' + id).html('' + data.votes);
    $container.find('#vk-' + id).html('<i class="icon-karma">K</i> ' + data.karma);

    $voted.addClass('voted').removeClass('pending').removeAttr('href').removeAttr('onclick');
    $notvoted.removeAttr('href').removeAttr('onclick').css('visibility', 'hidden');
}

function disable_vote_link(id, value, mess, background) {
    if (value < 0) {
        span = '<span class="negative">';
    } else {
        span = '<span>';
    }

    $('#a-va-' + id).html(span + mess + '</span>');

    if (background.length) {
        $('#a-va-' + id).css('background', background);
    }
}

function parseLinkAnswer(id, link) {
    $('#problem-' + id).hide();

    if (link.error || id != link.id) {
        disable_vote_link(id, -1, "{% trans _('grr...') %}", '');
        mDialog.notify("{% trans _('Error:') %} " + link.error, 5);
        return false;
    }

    var votes = parseInt(link.votes) + parseInt(link.anonymous),
        $votes = $('#a-votes-' + link.id);

    if ($votes.html() != votes) {
        $votes.hide().html(votes + "").fadeIn('slow');
    }

    $('#a-neg-' + link.id).html(link.negatives + "");
    $('#a-usu-' + link.id).html(link.votes + "");
    $('#a-ano-' + link.id).html(link.anonymous + "");
    $('#a-karma-' + link.id).html(link.karma + "");

    disable_vote_link(link.id, link.value, link.vote_description, '');

    return false;
}

function securePasswordCheck(field) {
    var color = '#F56874';

    if (field.value.length > 5 && field.value.match("^(?=.{6,})(?=(.*[a-z].*))(?=(.*[A-Z0-9].*)).*$", "g")) {
        if (field.value.match("^(?=.{8,})(?=(.*[a-z].*))(?=(.*[A-Z].*))(?=(.*[0-9].*)).*$", "g")) {
            color = "#8FFF00";
        } else {
            color = "#F2ED54";
        }
    }

    field.style.backgroundColor = color;

    return false;
}

function checkEqualFields(field, against) {
    field.style.backgroundColor = (field.value == against.value) ? '#8FFF00' : '#F56874';

    return false;
}

function checkInput($input) {
    var $button = $('#check-' + $input.attr('id'));

    $button.on('click', function() {
        checkField($input, $button);
    });
}

function checkField($input, $button) {
    var name = $input.attr('id'),
        value = $input.val(),
        url = base_url + 'backend/checkfield?name=' + name + '&value=' + encodeURIComponent(value);

    $.get(url, function(html) {
        var success = (html === 'OK'),
            resultId = 'check-result-' + name;
            $result = $('#' + resultId);

        if (!$result.length) {
            $result = $('<div id="' + resultId + '" class="alert"></div>');
            $input.parent().append($result);
        }

        $result.html(html);

        if (success) {
            $result.removeClass('alert-danger').addClass('alert-success');
        } else {
            $result.removeClass('alert-success').addClass('alert-danger');
        }

        $input.closest('form').find('button[type="submit"]').prop('disabled', !success);
    });
}

function check_checkfield(fieldname, mess) {
    var field = document.getElementById(fieldname);

    if (field && !field.checked) {
        mDialog.notify(mess, 5);
        /* box is not checked */
        return false;
    }
}

function report_problem(frm, user, id) {
    if (!frm.ratings.value) {
        return;
    }

    mDialog.confirm(
        "{% trans _('¿desea votar') %} <em>" + frm.ratings.options[frm.ratings.selectedIndex].text + "</em>?",
        function() {
            report_problem_yes(frm, user, id)
        },
        function() {
            report_problem_no(frm, user, id)
        }
    );

    return false;
}

function report_problem_no(frm, user, id) {
    frm.ratings.selectedIndex = 0;
}

function report_problem_yes(frm, user, id) {
    var content = "id=" + id + "&user=" + user + '&value=' + frm.ratings.value + "&key=" + base_key + "&l=" + link_id + "&u=" + encodeURIComponent(document.referrer);
    var url = base_url + "backend/problem?" + content;

    $.getJSON(url, function(data) {
        parseLinkAnswer(id, data);
    });

    reportAjaxStats('vote', 'link');

    return false;
}

function pref_input_check(id) {
    var $e = $('#' + id);

    $e.on('change', function() {
        $.post(base_url + 'backend/pref', {
            'id': "{{ current_user.user_id }}",
            'value': (this.checked ? 1 : 0),
            'key': this.value,
            'set': 1,
            'control_key': base_key
        }, function(data) {
            if (id === 'subs_default_header') {
                window.location.reload();
                return;
            }

            $e.prop('checked', data ? true : false);
        }, 'json');
    });
}

function add_remove_sub(id, change) {
    var url = base_url + 'backend/sub_follow';

    change = (change ? 1 : 0);

    $.post(url, {
        id: id,
        key: base_key,
        change: change
    }, function(data) {
        if (data.error) {
            mDialog.notify("{% trans _('Error:') %}" + data.error, 5);
            return;
        }

        var $button = $('.follow_b_' + id),
            $icon = $('.fa', $button),
            $text = $('span', $button);

        $button.removeClass('following-yes following-no');
        $icon.removeClass('fa-check-circle-o fa-times-circle-o');

        if (data.value) {
            $button.addClass('following-yes');
            $icon.addClass('fa-times-circle-o');
            $text.html("{% trans _('Siguiendo') %}");
        } else {
            $button.addClass('following-no');
            $icon.addClass('fa-check-circle-o');
            $text.html("{% trans _('Seguir') %}");
        }
    }, 'json');

    reportAjaxStats('html', "sub_follow");
}

function add_remove_fav(element, type, id) {
    var url = base_url + 'backend/get_favorite';

    $.post(url, {
        id: id,
        user: user_id,
        key: base_key,
        type: type
    }, function(data) {
        if (data.error) {
            mDialog.notify("{% trans _('Error:') %} " + data.error, 5);
            return;
        }

        if (data.value) {
            $('#' + element).addClass("on");
        } else {
            $('#' + element).removeClass("on");
        }
    }, "json");

    reportAjaxStats('html', "get_favorite");
}

function change_fav_readed(element, type, id) {
    var $element = $('#' + element);

    $.post(base_url + 'backend/get_favorite_readed', {
        id: id,
        user: user_id,
        key: base_key,
        type: type
    }, function(data) {
        if (data.error) {
            mDialog.notify("{% trans _('Error:') %} " + data.error, 5);
            return;
        }

        if (data.value) {
            $element.addClass("on");
            $element.closest(".news-summary").addClass("off");
        } else {
            $element.removeClass("on");
            $element.closest(".news-summary").removeClass("off");
        }
    }, "json");
}

/* Get voters by Beldar <beldar.cat at gmail dot com>
 ** Generalized for other uses (gallir at gmail dot com)
 */
function get_votes(program, type, container, page, id) {
    var url = base_url + 'backend/' + program + '?id=' + id + '&p=' + page + '&type=' + type + '&key=' + base_key;

    $e = $('#' + container);

    $e.load(url, function() {
        $e.trigger("DOMChanged", $e);

        initPollVote($e.find('.poll-vote form').first());
    });

    reportAjaxStats('html', program);
}

function user_relation(current_user_id, id, object)
{
    var $this = $(object),
        $parent = $this.parent(),
        url = base_url + 'backend/get_friend.php?id=' + id + '&value=' + $this.val() + '&key=' + base_key;

    $.ajax(url, {
        success: function(response) {
            $parent.find('img').remove();
            $parent.append(response);
        }
    });
}

function readStorage(key) {
    if (typeof Storage !== 'undefined') {
        return localStorage.getItem(key);
    } else {
        return readCookie(key);
    }
}

function writeStorage(key, value) {
    if (typeof Storage !== 'undefined') {
        localStorage.setItem(key, value);
    } else {
        createCookie("n_" + user_id + "_ts", value, 0);
    }
}

function createCookie(name, value, days, path) {
    var expires = '';

    if (days) {
        var date = new Date();

        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));

        expires = "; expires=" + date.toGMTString();
    }

    if (!path) {
        path = "/";
    }

    document.cookie = name + "=" + value + expires + "; path=" + path;
}

function readCookie(name, path) {
    var ca = document.cookie ? document.cookie.split('; ') : [];

    for (var i = 0; i < ca.length; i++) {
        var parts = ca[i].split('=');

        if (name == parts.shift()) {
            return parts.join('=');
        }
    }
}

function eraseCookie(name) {
    createCookie(name, '', -1);
}

/* This function report the ajax request to stats events if enabled in your account
 ** http://code.google.com/intl/es/apis/analytics/docs/eventTrackerOverview.html
 */
function reportAjaxStats(category, action, url) {
    if (typeof ga === 'undefined') {
        return;
    }

    if (category && action) {
        ga('send', 'event', category, action);
    }

    if (typeof url === 'string') {
        ga('send', 'pageview', url);
    }

    if (typeof registerExtraEvent === 'function') {
        registerExtraEvent(category, action, url);
    }
}

function bindTogglePlusMinus(img_id, link_id, container_id) {
    $(document).ready(function() {
        $('#' + link_id).bind('click', function() {
            var $img = $('#' + img_id);

            $img.attr('src', ($img.attr('src') === plus) ? minus : plus);

            $('#' + container_id).slideToggle('fast');

            return false;
        });
    });
}

function fancybox_expand_images(event) {
    if (!event.shiftKey) {
        return;
    }

    var $zoomed = $('.zoomed');

    event.preventDefault();
    event.stopImmediatePropagation();

    if ($zoomed.size()) {
        $zoomed.remove();
        return;
    }

    $('body').find('.fancybox[href*=".jpg"], .fancybox[href*=".gif"], .fancybox[href*=".png"]').each(function() {
        var $this = $(this);
        var title = $this.attr('title');
        var href = $this.attr('href');
        var img = '<div style="margin:10px auto;text-align:center;" class="zoomed"><img style="margin:0 auto;max-width:80%;padding:10px;background:#fff" src="' + href + '"/></div>';

        $this.after(img);

        $this.next().on('click', function(event) {
            if (event.shiftKey) {
                $zoomed.remove();
            }
        });
    });
}

function fancybox_gallery(type, user, link) {
    var is_public = parseInt("{{ globals.media_public }}") > 0;

    if (!is_public && !user_id > 0) {
        mDialog.notify("{% trans _('Debe estar autentificado para visualizar imágenes ') %}", 5);
        return;
    }

    var url = base_url + 'backend/gallery?type=' + type;

    if (typeof user !== 'undefined') {
        url = url + '&user=' + user;
    }

    if (typeof link !== 'undefined') {
        url = url + '&link=' + link;
    }

    if (!$('#gallery').size()) {
        $('body').append('<div id="gallery" style="display:none"></div>');
    }

    $('#gallery').load(url);
}

/**
  Strongly modified, onky works with DOM2 compatible browsers.
    Ricardo Galli
  From http://ljouanneau.com/softs/javascript/tooltip.php
 */

(function($) {
    var x = 0;
    var y = 0;
    var offsetx = 7;
    var offsety = 0;
    var reverse = false;
    var top = false;
    var box = null;
    var timer = null;
    var active = false;
    var last = null;
    var ajaxs = {
        'u': 'get_user_info',
        'p': "get_post_tooltip",
        'c': "get_comment_tooltip",
        'l': "get_link",
        'b': "get_ban_info",
        'w': "get_comment_warn_tooltip"
    };

    $.extend({
        tooltip: function() {
            if (!is_mobile) {
                start();
            }
        }
    });

    function stop() {
        hide();

        $(document).off('mouseenter mouseleave', '.tooltip');
        $(document).off('touchstart', stop);

        touchable = true;
    }

    function start(o) {
        if (box == null) {
            box = $("<div>").attr({ id: 'tooltip-text' });
            $('body').append(box);
        }

        $(document).on('touchstart', stop); /* Touch detected, disable tooltips */
        $(document).on('mouseenter mouseleave', '.tooltip', function(event) {
            event.preventDefault();

            if (event.type === 'mouseleave') {
                hide();
                return;
            }

            if (event.type !== 'mouseenter') {
                return;
            }

            try {
                var args = $(this).attr('class').split(' ');
                var i = args.indexOf('tooltip');
                args = args[i + 1].split(':');
                var key = args[0];
                var value = args[1];
                var ajax = ajaxs[key];
                init(event);

                timer = setTimeout(function() {
                    ajax_request(event, ajax, value)
                }, 200);
            } catch (e) {
                hide();
            }
        });
    }

    function init(event) {
        if (timer || active) {
            hide();
        }

        active = true;

        $(document).on('onAjax', hide);
        $(document).on('mousemove.tooltip', function(e) {
            mouseMove(e);
        });

        if (box.outerWidth() === 0) {
            return;
        }

        reverse = ($(window).width() - event.pageX < box.outerWidth() * 1.05);
        top = ($(window).height() - (event.pageY - $(window).scrollTop()) < 200);
    }

    function show(html) {
        if (!active) {
            return;
        }

        if (typeof html === 'string') {
            box.html(html);
        }

        if (box.html().length > 0) {
            position();

            box.show();
            box.trigger('DOMChanged', box);
        } else {
            hide();
        }
    }

    function hide() {
        if (timer) {
            clearTimeout(timer);
            timer = null;
        }

        $(document).off('mousemove.tooltip');

        active = false;

        box.hide();
    }

    function position() {
        if (reverse) {
            xL = x - (box.outerWidth() + offsetx);
        } else {
            xL = x + offsetx;
        }

        if (top) {
            yL = y - (box.outerHeight() + offsety);
        } else {
            yL = y + offsety;
        }

        box.css({ left: xL + "px", top: yL + "px" });
    }

    function mouseMove(e) {
        x = e.pageX;
        y = e.pageY;

        position();
    }

    function ajax_request(event, script, id) {
        var url = base_url + 'backend/' + script + '?id=' + id;

        timer = null;

        if (url === last) {
            show();
            return;
        }

        $.ajax({
            url: url,
            dataType: "html",
            success: function(html) {
                last = url;

                show(html);
                reportAjaxStats('tooltip', script);
            }
        });
    }
})(jQuery);

/**
 *  Based on jqDialog from:
 *  Kailash Nadh, http://plugins.jquery.com/project/jqDialog
 **/

function strip_tags(html) {
    return html.replace(/<\/?[^>]+>/gi, '');
}

var mDialog = new function() {
    this.closeTimer = null;
    this.divBox = null;

    this.std_alert = function(message, callback) {
        alert(strip_tags(message));
        if (callback) callback();
    };

    this.std_confirm = function(message, callback_yes, callback_no) {
        if (confirm(strip_tags(message))) {
            if (callback_yes) {
                callback_yes();
            }
        } else if (callback_no) {
            callback_no();
        }
    };

    this.std_prompt = function(message, content, callback_ok, callback_cancel) {
        var res = prompt(message, content);

        if (res) {
            if (callback_ok) {
                callback_ok(res);
            }
        } else if (callback_cancel) {
            callback_cancel(res);
        }
    };

    this.confirm = function(message, callback_yes, callback_no) {
        if (is_mobile) {
            this.std_confirm(message, callback_yes, callback_no);
            return;
        }

        this.createDialog(message);
        this.btYes.show();
        this.btNo.show();
        this.btOk.hide();
        this.btCancel.hide();
        this.btClose.hide();
        this.btYes.focus();

        /* just redo this everytime in case a new callback is presented */
        this.btYes.unbind().click(function() {
            mDialog.close();

            if (callback_yes) {
                callback_yes();
            }
        });

        this.btNo.unbind().click(function() {
            mDialog.close();

            if (callback_no) {
                callback_no();
            }
        });
    };

    this.prompt = function(message, content, callback_ok, callback_cancel) {
        if (is_mobile) {
            this.std_prompt(message, content, callback_ok, callback_cancel);
            return;
        }

        this.createDialog($("<p>").append(message).append($("<p>").append($(this.input).val(content))));

        this.btYes.hide();
        this.btNo.hide();
        this.btOk.show();
        this.btCancel.show();
        this.input.focus();

        /* just redo this everytime in case a new callback is presented */
        this.btOk.unbind().click(function() {
            mDialog.close();

            if (callback_ok) {
                callback_ok(mDialog.input.val());
            }
        });

        this.btCancel.unbind().click(function() {
            mDialog.close();

            if (callback_cancel) {
                callback_cancel();
            }
        });
    };

    this.alert = function(content, callback_ok) {
        if (is_mobile) {
            this.std_alert(content, callback_ok);
            return;
        }

        this.createDialog(content);
        this.btCancel.hide();
        this.btYes.hide();
        this.btNo.hide();
        this.btOk.show();
        this.btOk.focus();

        this.btOk.unbind().click(function() {
            mDialog.close();

            if (callback_ok) {
                callback_ok();
            }
        });
    };

    this.content = function(content, close_seconds) {
        if (is_mobile) {
            this.std_alert(content, false);
            return;
        }

        this.createDialog(content);
        this.divOptions.hide();
    };

    this.notify = function(content, close_seconds) {
        if (is_mobile) {
            this.std_alert(content, false);
            return;
        }

        this.content(content);
        this.btClose.show().focus();

        if (close_seconds) {
            this.closeTimer = setTimeout(function() { mDialog.close(); }, close_seconds * 1000);
        }
    };

    this.createDialog = function(content) {
        if (this.divBox == null) {
            this.init();
        }

        clearTimeout(this.closeTimer);

        this.divOptions.show();
        this.divContent.html(content);
        this.divBox.fadeIn('fast');
        this.maintainPosition();
    };

    this.close = function() {
        this.divBox.fadeOut('fast');
        $(window).unbind('scroll.mDialog');
    };

    this.makeCenter = function() {
        $(mDialog.divBox).css({
            top: ((($(window).height() / 2) - (mDialog.h / 2))) + ($(document).scrollTop()) + 'px',
            left: ((($(window).width() / 2) - (mDialog.w / 2))) + ($(document).scrollLeft()) + 'px'
        });
    };

    this.maintainPosition = function() {
        mDialog.w = mDialog.divBox.width();
        mDialog.h = mDialog.divBox.height();
        mDialog.makeCenter();

        $(window).bind('scroll.mDialog', function() {
            mDialog.makeCenter();
        });
    };

    this.init = function() {
        if (is_mobile) {
            return;
        }

        this.divBox = $("<div>").attr({ id: 'mDialog_box' });
        this.divHeader = $("<div>").attr({ id: 'mDialog_header' });
        this.divContent = $("<div>").attr({ id: 'mDialog_content' });
        this.divOptions = $("<div>").attr({ id: 'mDialog_options' });
        this.btYes = $("<button>").attr({ id: 'mDialog_yes' }).text("{% trans _('Sí') %}");
        this.btNo = $("<button>").attr({ id: 'mDialog_no' }).text("{% trans _('No') %}");
        this.btOk = $("<button>").attr({ id: 'mDialog_ok' }).text("{% trans _('Vale') %}");
        this.btCancel = $("<button>").attr({ id: 'mDialog_ok' }).text("{% trans _('Cancelar') %}");
        this.input = $("<input>").attr({ id: 'mDialog_input' });

        this.btClose = $("<span>").attr({ id: 'mDialog_close' }).text('X').on('click', function() {
            mDialog.close();
        });

        this.divHeader.append(this.btClose);

        this.divBox.append(this.divHeader).append(this.divContent).append(
            this.divOptions.append(this.btNo).append(this.btCancel).append(this.btOk).append(this.btYes)
        );

        this.divBox.hide();

        $('body').append(this.divBox);
    };
};

function comment_edit(id, DOMid) {
    $target = $('#' + DOMid).closest('.comment').parent();

    $.getJSON(base_url_sub + 'comment_ajax', {
        id: id
    }, function(data) {
        if (!data) {
            return;
        }

        if (data.error) {
            mDialog.notify("error: " + data.error, 5);
            return;
        }

        $target.html(data.html);
        $target.find('textarea').setFocusToEnd();
        $target.trigger('DOMChanged', $target);

        $('#c_edit_form').ajaxForm(options = {
            async: false,
            dataType: 'json',
            success: function(data) {
                if (!data.error) {
                    $target.html(data.html);
                } else {
                    mDialog.notify("error: " + data.error, 5)
                }

                $target.trigger('DOMChanged', $target);
            },
            error: function() {
                mDialog.notify("error", 3);
            },
        });
    });
}

function comment_reply(id, prefix) {
    prefix = prefix || '';

    var $parent = $('#cid-' + prefix + id).closest('.comment');

    if ($parent.find('#comment_ajax_form').length) {
        return;
    }

    var $current = $('#comment_ajax_form'),
        $target = $('<div class="threader"></div>'),
        contents = '';

    if ($current.length) {
        contents = $current.find('textarea').val();
        $current.remove();
    }

    $parent.after($target);

    $.getJSON(base_url_sub + 'comment_ajax', {
        reply_to: id
    }, function(data) {
        if (!data) {
            return;
        }

        if (data.error) {
            mDialog.notify("error: " + data.error, 3);
            return;
        }

        var $e = $('<div id="comment_ajax_form" style="margin: 10px 0 20px 0"></div>');

        $e.append(data.html);

        var $textarea = $target.append($e).find('textarea');

        if (contents) {
            $textarea.val(contents + ' ' + $textarea.val());
        }

        $textarea.setFocusToEnd();

        $('#c_edit_form').ajaxForm({
            async: false,
            dataType: 'json',
            success: function(data) {
                if (data.error) {
                    mDialog.notify("error: " + data.error, 5);
                    return;
                }

                $e.remove();

                $target.append(data.html).find('.comment-expand').remove();
                $target.trigger('DOMChanged', $target);
            },
            error: function() {
                mDialog.notify("error", 3);
            },
        });

        $target.trigger('DOMChanged', $target);
    });
}

function post_load_form(id, container) {
    var url = base_url + 'backend/post_edit?id=' + id + "&key=" + base_key;

    $.get(url, function(html) {
        if (!html.length) {
            return;
        }

        reportAjaxStats('html', 'post_edit');

        if (html.match(/^ERROR:/i)) {
            mDialog.notify(html, 2);
            return;
        }

        $container = $('#' + container);

        $container.html(html).trigger('DOMChanged', $container);

        initFormPostEdit($container.find('.post-edit form').first());

        $container.find('textarea[name="post"]').trigger('focus').autosize();
    });
}

function post_new() {
    post_load_form(0, 'addpost');
}

function post_edit(id) {
    post_load_form(id, 'pcontainer-' + id);
}

function post_reply(id, user) {
    var ref = '@' + user + ',' + id + ' ';
    var others = '';
    var regex = /get_post_url(?:\.php){0,1}\?id=([a-z0-9%_\.\-]+(\,\d+){0,1})/ig; /* TODO: delete later (?:\.php)*/
    var text = $('#pid-' + id).html();
    var textarea = $('.post-edit [name="post"]').last();
    var startSelection, endSelection;

    var myself = new RegExp('^' + user_login + '([\s,]|$)', 'i');

    while (a = regex.exec(text)) { /* Add references to others */
        u = decodeURIComponent(a[1]);

        if (!u.match(myself)) { /* exclude references to the reader */
            others = others + '@' + u + ' ';
        }
    }

    if (others.length > 0) {
        startSelection = ref.length;
        endSelection = startSelection + others.length;
        ref = ref + others;
    } else {
        startSelection = endSelection = 0;
    }

    if (!textarea.val()) {
        post_new();
    }

    post_add_form_text(textarea, ref, 1, startSelection, endSelection);
}

function post_add_form_text(textarea, text, tries, start, end) {
    tries = tries ? tries : 1;

    if (tries < 20 && !textarea.length) {
        setTimeout(function() {
            post_add_form_text($form, text, tries + 1, start, end)
        }, 100);

        return false;
    }

    if (!textarea.length) {
        return false;
    }

    var re = new RegExp(text);
    var oldtext = textarea.val();

    if (oldtext.match(re)) {
        return false;
    }

    var offset = oldtext.length;

    if (oldtext.length > 0 && oldtext.charAt(oldtext.length - 1) !== ' ') {
        oldtext = oldtext + ' ';
        offset = offset + 1;
    }

    textarea.val(oldtext + text);

    var obj = textarea[0];
    obj.focus();

    if ('selectionStart' in obj && start > 0 && end > 0) {
        obj.selectionStart = start + offset;
        obj.selectionEnd = end + offset;
    }
}

/* See http://www.shiningstar.net/articles/articles/javascript/dynamictextareacounter.asp?ID=AW */
var textCounter = function(field, cntfield, maxlimit) {
    if (textCounter.timer) {
        return;
    }

    textCounter.timer = setTimeout(function() {
        textCounter.timer = false;

        var length = field.value.length;

        if (length > maxlimit) {
            field.value = field.value.substring(0, maxlimit);
            length = maxlimit;
        }

        if (textCounter.length != length) {
            cntfield.value = maxlimit - length;
            textCounter.length = length;
        }
    }, 300);
};

textCounter.timer = false;
textCounter.length = 0;

/*
  Code from http://www.gamedev.net/community/forums/topic.asp?topic_id=400585
  strongly improved by Juan Pedro López for http://meneame.net
  2006/10/01, jotape @ http://jplopez.net
*/

function applyTag(caller, tag) {
    /* find first parent form and the textarea */
    var obj = $(caller).parents("form").find("textarea")[0];

    if (obj) {
        wrapText(obj, tag, tag);
    }
}

function wrapText(obj, tag) {
    obj.focus();

    if (typeof obj.selectionStart === 'number') {
        /* Mozilla, Opera and any other true browser */
        var start = obj.selectionStart;
        var end = obj.selectionEnd;

        if (start < end) {
            obj.value = obj.value.substring(0, start) + replaceText(obj.value.substring(start, end), tag) + obj.value.substring(end, obj.value.length);
        }

        return;
    }

    if (!document.selection) {
        obj.value += text;
        return;
    }

    /* Damn Explorer */
    /* Checking we are processing textarea value */
    var range = document.selection.createRange();

    if ((range.parentElement() !== obj) || !range.text) {
        return false;
    }

    if (typeof range.text === 'string') {
        document.selection.createRange().text = replaceText(range.text, tag);
    }
}

function replaceText(text, tag) {
    return '<' + tag + '>' + text + '</' + tag + '>';
}

/* Privates */
function priv_show(content) {
    $.colorbox({
        html: content,
        width: 500,
        transition: 'none',
        scrolling: false
    });
}

function priv_new(user_id) {
    var w, h;
    var url = base_url + 'backend/priv_edit?user_id=' + user_id + "&key=" + base_key;

    if (is_mobile) {
        w = h = '100%';
    } else {
        w = '600px';
        h = '350px';
    }

    $.colorbox({
        href: url,
        overlayClose: false,
        opacity: 0.5,
        transition: 'none',
        title: false,
        scrolling: true,
        open: true,
        width: w,
        height: h,
        onComplete: function() {
            if (user_id > 0) {
                $('#post').focus();
            } else {
                $("#to_user").focus();
            }
        },
        'onOpen': function() {
            historyManager.push('#priv_new', $.colorbox.close);
        },
        'onClosed': function() {
            historyManager.pop('#priv_new');
        }
    });
}

function report_comment(comment_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'backend/report_comment.php',
        dataType: 'json',
        data: {
            process: 'check_can_report',
            id: comment_id,
            key: base_key
        },
        success: function(data) {
            if (!data.error) {
                show_report_dialog(comment_id);
            } else {
                mDialog.notify("error: " + data.error, 5);
            }
        }
    });
}

function show_report_dialog(comment_id) {
    var w, h;
    var url = base_url + 'backend/report_comment.php?id=' + comment_id + "&key=" + base_key;

    if (is_mobile) {
        w = h = '100%';
    } else {
        w = '500px';
        h = '310px';
    }

    $.colorbox({
        href: url,
        overlayClose: false,
        opacity: 0.1,
        transition: 'none',
        title: "{% trans _('reporte de comentario') %}",
        scrolling: false,
        open: true,
        className: 'report',
        width: w,
        height: h,
        onComplete: function() {
            $('#r_new_form').ajaxForm({
                async: false,
                dataType: 'json',
                success: function(data) {
                    if (!data.error) {
                        mDialog.notify("{% trans _('Gracias por tu colaboración. Evaluaremos el comentario.') %}", 5);
                        $.colorbox.close();
                    } else {
                        mDialog.notify("error: " + data.error, 5);
                    }
                },
                error: function() {
                    mDialog.notify("error: " + data.error, 3);
                }
            });
        }
    });
}

/* Answers */
function get_total_answers_by_ids(type, ids) {
    $.ajax({
        type: 'POST',
        url: base_url + 'backend/get_total_answers',
        dataType: 'json',
        data: {
            ids: ids,
            type: type
        },
        success: function(data) {
            $.each(data, function(ids, answers) {
                show_total_answers(type, ids, answers)
            });
        }
    });

    reportAjaxStats('json', 'total_answers_ids');
}

function get_total_answers(type, order, id, offset, size) {
    $.getJSON(base_url + 'backend/get_total_answers', {
        id: id,
        type: type,
        offset: offset,
        size: size,
        order: order
    }, function(data) {
        $.each(data, function(ids, answers) {
            show_total_answers(type, ids, answers)
        });
    });

    reportAjaxStats('json', 'total_answers');
}

function show_total_answers(type, id, answers) {
    if (type === 'comment') {
        dom_id = '#cid-' + id;
    } else {
        dom_id = '#pid-' + id;
    }

    $(dom_id).closest('.comment').find('.comment-footer').append(
        '<a href="javascript:void(0);" onclick="javascript:show_answers(\'' + type + '\',' + id + ')" title="' + answers + ' {% trans _("respuestas") %}" class="comment-answers">'
        + '<i class="fa fa-comments"></i>&nbsp;' + answers
        + '</a>'
    );
}

function show_answers(type, id) {
    var program, dom_id, answers;

    if (type == 'comment') {
        program = 'get_comment_answers';
        dom_id = '#cid-' + id;
    } else {
        program = 'get_post_answers';
        dom_id = '#pid-' + id;
    }

    answers = $('#answers-' + id);

    if (answers.length) {
        answers.toggle();
        return;
    }

    $.get(base_url + 'backend/' + program, { "type": type, "id": id }, function(html) {
        /* Added a double check to avoid duplicated answers on latency problems */
        if ($('#answers-' + id).length) {
            return;
        }

        element = $(dom_id).closest('.comment').parent();
        element.append('<div class="comment-answers" id="answers-' + id + '">' + html + '</div>');
        element.trigger('DOMChanged', element);
    });

    reportAjaxStats('html', program);
}

function share_fb(e) {
    var url = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent($(e).parent().parent().data('url'));

    window.open(url, 'facebook-share-dialog', 'width=626,height=436');

    return false;
}

function share_tw(e) {
    var $parent = $(e).parent().parent(),
        url = 'https://twitter.com/intent/tweet?url=' + encodeURIComponent($parent.data('url')) + '&text=' + encodeURIComponent($parent.data('title'));

    window.open(url, 'twitter-share-dialog', 'width=550,height=420');

    return false;
}

/* scrollstop plugin for jquery +1.9 */
(function() {
    var latency = 75;
    var handler;

    $.event.special.scrollstop = {
        setup: function() {
            var timer;

            handler = function(evt) {
                var _self = this,
                    _args = arguments;

                if (timer) {
                    clearTimeout(timer);
                }

                timer = setTimeout(function() {
                    timer = null;
                    evt.type = 'scrollstop';

                    $(_self).trigger(evt, [_args]);
                }, latency);
            };

            $(this).on('scroll', handler);
        },
        teardown: function() {
            $(this).off('scroll', handler);
        }
    };
})(jQuery);

(function() {
    var panel = false;

    $("#nav-menu").on('click', function() {
        prepare();

        if (panel.is(":visible")) {
            $('html').off('click', click_handler);
            panel.hide();
        } else {
            $('html').on('click', click_handler);
            panel.show();
        }
    });

    function prepare() {
        if (panel && panel.children().length) {
            return;
        }

        if (!panel) {
            panel = $('<div id="nav-panel"></div>');

            panel.appendTo("body");

            $(window).on('unload onAjax', function() {
                panel.empty();
                panel.hide();
            });
        }

        if (is_mobile) {
            panel.append($('#searchform').show());

            var menu = $('#header-menu .header-menu01').clone();

            menu.find('ul.dropdown-menu.menu-subheader > li').each(function() {
                menu.find('ul.menu01-itemsl').append($(this));
            });

            menu.find('.dropdown.menu-more').remove();
            menu.find('li').show();

            panel.append(menu);
        } else {
            panel.append($('#searchform').clone());
            panel.append($('#header-menu .header-menu01').clone());
        }
    };

    function click_handler(e) {
        if (!panel.is(":visible")) {
            return;
        }

        if (!$(e.target).closest('#nav-panel, #nav-menu').length) {
            panel.hide();
            e.preventDefault();
        }
    };
})();

/* Back to top plugin
 * From http://www.jqueryscript.net/demo/Customizable-Back-To-Top-Button-with-jQuery-backTop/
 */

(function($) {
    $.fn.backTop = function(options) {
        var backBtn = this;
        var visible = false;
        var editing = false;
        var settings = $.extend({
            'position': 600,
            'speed': 500,
        }, options);

        var position = settings['position'];
        var speed = settings['speed'];

        $('input[type=text], textarea').on("focus focusout", onFocus);

        $(window).on('DOMChanged', function(event, parent) {
            $(parent).find('input[type=text], textarea').on("focus focusout editing", onFocus);
        });

        $(window).on('editing', onFocus);
        $(window).on('scrollstop', showHide);

        backBtn.click(function() {
            $("html, body").animate({ scrollTop: 0 }, 'fast');
        });

        function onFocus(e) {
            if (e.type === "focus" || e.type === "editing") {
                editing = true;
                showHide(e);
            } else if (e.type === "focusout") {
                editing = false;

                setTimeout(function() {
                    showHide(e);
                }, 1000);
            }
        }

        function showHide(e) {
            var pos = $(window).scrollTop();

            if (!editing && !visible && pos >= position) {
                show();
            } else if (visible && (editing || pos < position)) {
                hide();
            }
        }

        function hide() {
            backBtn.fadeOut(speed);
            visible = false;
        }

        function show() {
            backBtn.fadeIn(speed);
            visible = true;
        }
    }
}(jQuery));

/* Drop an image file
 ** Modified from http://gokercebeci.com/dev/droparea
 */
(function($) {
    var s;
    var m = {
        init: function(e) {},
        start: function(e) {},
        complete: function(r) {},
        error: function(r) {
            mDialog.alert(r.error);
            return false;
        },
        traverse: function(files, area) {
            var form = area.parents('form');

            form.find('input[name="tmp_filename"], input[name="tmp_filetype"]').remove();

            if (typeof files !== 'undefined') {
                if (m.check_files(files, area)) {
                    for (var i = 0, l = files.length; i < l; i++) {
                        m.upload(files[i], area);
                    }
                }
            } else {
                mDialog.notify("{% trans _('formato no reconocido') %}", 5);
            }
        },

        check_files: function(files, area) {
            if ((typeof File === 'undefined') || (typeof files === 'undefined')) {
                return true;
            }

            for (var i = 0; i < files.length; i++) {
                /* File type control */
                if (files[i].type.length > 0 && !files[i].type.match('image.*')) {
                    mDialog.notify("{% trans _('sólo se admiten imágenes') %}", 5);
                    return false;
                }

                if (files[i].fileSize > s.maxsize) {
                    mDialog.notify("{% trans _('tamaño máximo excedido') %}" + ":<br/>" + files[i].fileSize + " > " + s.maxsize + " bytes", 5);
                    return false;
                }
            }

            return true;
        },

        upload: function(file, area) {
            var form = area.closest('form');
            var thumb = form.find('.droparea_info img').attr('src', s.loaderImage).show();
            var submit = form.find(':submit');

            submit.attr('disabled', 'disabled');

            var xhr = new XMLHttpRequest();

            /* File uploaded */
            xhr.addEventListener("load", function(e) {
                var r = jQuery.parseJSON(e.target.responseText);

                if (typeof r.error === 'undefined') {
                    thumb.attr('src', r.thumb).show();

                    form.find('input[name="tmp_filename"], input[name="tmp_filetype"]').remove();
                    form.append('<input type="hidden" name="tmp_filename" value="' + r.name + '"/>');
                    form.append('<input type="hidden" name="tmp_filetype" value="' + r.type + '"/>');

                    s.complete(r);
                } else {
                    thumb.hide();
                    s.error(r);
                }

                submit.removeAttr('disabled');
            }, false);

            xhr.open("post", s.post, true);

            /* Set appropriate headers */
            xhr.setRequestHeader("Content-Type", "multipart/form-data-alternate");

            if (typeof file.fileSize !== "undefined") {
                xhr.setRequestHeader("X-File-Size", file.fileSize);
            }

            xhr.send(file);
        }
    };

    $.fn.droparea = function(o) {
        /* Check support for HTML5 File API */
        if (!window.File) {
            return;
        }

        /* Settings */
        s = {
            'post': base_url + 'backend/tmp_upload',
            'init': m.init,
            'start': m.start,
            'complete': m.complete,
            'error': m.error,
            'maxsize': 500000,
            /* Bytes */
            'show_thumb': true,
            'hide_delay': 2000,
            'backgroundColor': '#AFFBBB',
            'backgroundImage': base_static + version_id + '/img/common/upload-2x.png',
            'loaderImage': base_static + version_id + '/img/common/uploading.gif'
        };

        this.each(function() {
            if (o) {
                $.extend(s, o);
            }

            var form = $(this);

            s.init(form);

            form.find('input[type="file"]').change(function() {
                m.traverse(this.files, form);

                $(this).val('');
            });

            if (s.show_thumb) {
                form.find('.droparea_info').append($('<img width="32" height="32"/>').hide());
            }

            form.find('.droparea').bind({
                dragleave: function(e) {
                    var area = $(this);

                    e.preventDefault();
                    area.css(area.data('bg'));
                },

                dragenter: function(e) {
                    e.preventDefault();

                    $(this).css({
                        'background-color': s.backgroundColor,
                        'background-image': 'url("' + s.backgroundImage + '")',
                        'background-position': 'center',
                        'background-repeat': 'no-repeat'
                    });
                },

                dragover: function(e) {
                    e.preventDefault();
                }
            })
            .each(function() {
                var area = $(this);

                area.data("bg", {
                    'background-color': area.css('background-color'),
                    'background-image': area.css('background-image'),
                    'background-position': area.css('background-position')
                });

                this.addEventListener("drop", function(e) {
                    e.preventDefault();
                    s.start(area);
                    m.traverse(e.dataTransfer.files, area);
                    area.css(area.data('bg'));
                }, false);
            });
        });
    };
})(jQuery);

/*
    FileInput bsed on jQuery.NiceFileInput.js
    By Jorge Moreno - @alterebro
*/
(function($) {
    $.fn.nicefileinput = function(options) {
        var settings = {
            label: '',
            title: '{% trans _("subir imagen") %}',
        };

        if (options) {
            $.extend(settings, options);
        };

        return this.each(function() {
            var self = this;

            if ($(self).attr('data-styled')) {
                return;
            }

            var r = Math.round(Math.random() * 10000);
            var d = new Date();
            var guid = d.getTime() + r.toString();

            $(self).wrap($("<div>").css({
                    'overflow': 'hidden',
                    'position': 'relative',
                    'display': 'inline-block',
                    'white-space': 'nowrap',
                    'text-align': 'center'
                })
                .addClass('uploadFile-button upload' + guid).html(settings.label).attr("title", settings.title)
            );

            $('.uploadFile' + guid).wrapAll('<div class="uploadFile-wrapper" id="upload-wrapper-' + guid + '" />');

            $('.uploadFile-wrapper').css({
                'overflow': 'auto',
                'display': 'inline-block'
            });

            $("#uploadFile-wrapper-" + guid).addClass($(self).attr("class"));

            $(self).css({
                'visibility': 'visible',
                'opacity': 0,
                'position': 'absolute',
                'border': 'none',
                'margin': 0,
                'padding': 0,
                'top': 0,
                'right': 0,
                'cursor': 'pointer',
                'height': '30px'
            })
            .addClass('uploadFile-current').attr("title", settings.title);

            $(self).attr('data-styled', true);
        });
    };
})(jQuery);

var historyManager = new function() {
    var history = [];

    if (typeof window.history.pushState !== "function") {
        return;
    }

    $(window).on("popstate", function(e) {
        if (!history.length) {
            return;
        }

        var state = history.pop();

        if (typeof state.callback === "function") {
            state.callback(state);
        }

        if ($(window).scrollTop() != state.scrollTop) {
            window.scrollTo(0, state.scrollTop);
        }
    });

    this.push = function(name, callback) {
        if (typeof window.history.pushState !== "function") {
            return;
        }

        var state = {
            id: history.length,
            name: name,
            href: location.href,
            scrollTop: $(window).scrollTop()
        };

        var new_href = name;

        window.history.pushState(state, null, new_href);

        state.callback = callback;

        history.push(state);

        reportAjaxStats('', '', new_href);
    };

    this.pop = function(name) {
        if (history.length) {
            window.history.back();
        }
    };
};

var fancyBox = new function() {
    this.parse = function($e) {
        var iframe = false,
            title = false,
            html = false,
            href = false,
            innerWidth = false,
            innerHeight = false,
            maxWidth, maxHeight, onLoad = false,
            onComplete = false,
            v, myClass, width = false,
            height = false,
            overlayClose = true,
            target = '';
        var myHref = $e.data('real_href') || $e.attr('href');
        var myTitle, photo = false;
        var ajaxName = "image";

        if ($e.attr('target')) {
            target = ' target="' + $e.attr('target') + '"';
        }

        if ((v = myHref.match(/(?:youtube\.com\/(?:embed\/|.*v=)|youtu\.be\/)([\w\-_]+).*?(#.+)*$/))) {
            if (is_mobile || touchable) {
                return false;
            }

            iframe = true;
            title = '<a target="_blank" href="' + myHref + '"' + target + '>{% trans _("vídeo en Youtube") %}</a>';
            href = 'https://www.youtube.com/embed/' + v[1];

            if (typeof v[2] !== "undefined") {
                href += v[2];
            }

            innerWidth = 640;
            innerHeight = 390;
            maxWidth = false;
            maxHeight = false;
            ajaxName = "youtube";
        } else if ((v = myHref.match(/twitter\.com\/.+?\/(?:status|statuses)\/(\d+)/))) {
            title = '<a target="_blank" href="' + myHref + '"' + target + '>{% trans _("en Twitter") %}</a>';
            html = " ";

            if (is_mobile) {
                width = '100%';
                height = '100%';
            } else {
                innerWidth = 550;
                innerHeight = 500;
            }

            maxWidth = false;
            maxHeight = false;
            ajaxName = "tweet";

            onComplete = function() {
                $.getJSON(base_url + "backend/json_cache", {
                    s: "tweet",
                    id: v[1]
                }, function(data) {
                    if (typeof data.html !== "undefined" && data.html.length) {
                        $('#cboxLoadedContent').html(data.html);
                    } else {
                        $('#cboxLoadedContent').html('<a target="_blank" href="' + myHref + '">Not found</a>');
                    }
                });
            };
        } else if ((v = myHref.match(/(?:vimeo\.com\/(\d+))/))) {
            title = '<a target="_blank" href="' + myHref + '"' + target + '>{% trans _("vídeo en Vimeo") %}</a>';

            if (is_mobile) {
                width = '100%';
                height = '100%';
            } else {
                innerWidth = 640;
                innerHeight = 400;
            }

            maxWidth = "100%";
            maxHeight = "100%";
            ajaxName = "vimeo";
            href = '//player.vimeo.com/video/' + v[1];
            iframe = true;
        } else if ((v = myHref.match(/(?:vine\.co\/v\/(\w+))/))) {
            title = '<a target="_blank" href="' + myHref + '"' + target + '>{% trans _("vídeo en Vine") %}</a>';

            if (is_mobile) {
                innerWidth = 320;
                innerHeight = 320;
            } else {
                innerWidth = 480;
                innerHeight = 480;
            }

            maxWidth = false;
            maxHeight = false;
            ajaxName = "vine";
            href = 'https://vine.co/v/' + v[1] + '/embed/simple';
            iframe = true;
        } else {
            if (myHref.match(/\.(x\-){0,1}(gif|jpeg|jpg|pjpeg|pjpg|png|tif|tiff)$/)) {
                photo = true;
            }

            myTitle = $e.attr('title');

            if (myTitle && myTitle.length > 0 && myTitle.length < 30) {
                title = myTitle;
            } else {
                title = '{% trans _("enlace original") %}';
            }

            title = '<a target="_blank" href="' + myHref + '"' + target + '>' + title + '</a>';
            href = myHref;

            if (is_mobile) {
                width = '100%';
                height = '100%';
            } else {
                maxWidth = '75%';
                maxHeight = '75%';
            }
        }

        myClass = $e.attr('class');

        if (typeof myClass === "string" && (linkId = myClass.match(/l:(\d+)/))) {
            /* It's a link, call go.php */
            setTimeout(function() {
                $.get(base_url_sub + 'go?quiet=1&id=' + linkId[1]);
            }, 10);
        }

        $.colorbox({
            'html': html,
            'photo': photo,
            'href': href,
            'transition': 'none',
            'width': width,
            'height': height,
            'maxWidth': maxWidth,
            'maxHeight': maxHeight,
            'opacity': 0.5,
            'title': title,
            'iframe': iframe,
            'innerWidth': innerWidth,
            'innerHeight': innerHeight,
            'overlayClose': overlayClose,
            'onLoad': onLoad,
            'onComplete': onComplete,
            'onOpen': function() {
                historyManager.push('#box_' + ajaxName, $.colorbox.close);
            },
            'onClosed': function() {
                historyManager.pop('#box_' + ajaxName);
            }
        });

        return true;
    };
};

/* notifier */
(function() {
    var timeout = false;
    var area;
    var panel_visible = false;
    var current_count = -1;
    var has_focus = true;
    var check_counter = 0;
    var base_update = 15000;
    var last_connect = null;

    if (!user_id > 0 || (area = $('#notifier')).length == 0) {
        return;
    }

    $(window).on('unload onAjax', function() {
        hide();
    });

    area.click(click);

    $(window).on("DOMChanged", function() {
        current_count = -1;
        restart();
    });

    $(window).focus(restart);

    $(window).blur(function() {
        has_focus = false;
    });

    setTimeout(update, 500); /* We are not in a hurry */

    function click_handler(e) {
        if (!panel_visible || $(e.target).closest('#notifier_panel').length) {
            return;
        }

        /* click happened outside */
        hide();
        e.preventDefault();
    };

    function click() {
        if (panel_visible) {
            hide();
            update();

            return false;
        }

        panel_visible = true;

        $e = $('<div id="notifier_panel"> </div>');

        $e.appendTo("#header-top");

        $('html').on('click', click_handler);

        data = decode_data(readStorage("n_" + user_id));

        var a = ['privates', 'posts', 'comments', 'friends', 'favorites'];

        for (var i = 0; i < a.length; i++) {
            field = a[i];
            var counter = (data && data[field]) ? data[field] : 0;
            $e.append("<div class='" + field + "'><a href='" + base_url_sub + "go?id=" + user_id + "&what=" + field + "'>" + counter + " " + field_text(field) + "</a></div>");
        }

        if (current_user_admin) {
            $e.append('<div class="admin"><a href=' + base_url + 'admin/logs.php>Administración</a></div>');
        }

        $e.show().css({
            'right': ($e.position().left) + 'px'
        });

        check_counter = 0;

        return false;
    };

    function hide() {
        $("#notifier_panel").remove();

        panel_visible = false;
    };

    function update() {
        var next_update;
        var now = new Date().getTime();
        var last_check = readStorage("n_" + user_id + "_ts");

        if (
            last_check == null || (check_counter == 0 && now - last_check > 3000) /* Avoid too many refreshes */ || (now - last_check > base_update + check_counter * 20)
        ) {
            writeStorage("n_" + user_id + "_ts", now);
            connect();
        } else {
            update_panel();
        }

        if (!has_focus) {
            next_update = 8000;
        } else {
            next_update = 4000;
        }

        if (is_mobile) {
            next_update *= 2;
        }

        /* one network update for mobiles */
        if ((is_mobile && check_counter < 1) || (!is_mobile && check_counter < 3 * 3600 * 1000 / base_update)) {
            timeout = setTimeout(update, next_update);
        } else {
            timeout = false;
        }
    };

    function update_panel() {
        var count;
        var posts;

        data = decode_data(readStorage("n_" + user_id));

        if (!data || (data.total == current_count)) {
            return;
        }

        document.title = document.title.replace(/^\(\d+\) /, '');
        area.find('span.badge').html(data.total);

        $('#p_c_counter').html(data.posts);

        if (data.total > 0) {
            area.addClass('nonzero');
            document.title = '(' + data.total + ') ' + document.title;
        } else {
            area.removeClass('nonzero');
        }

        current_count = data.total;
    };

    function connect() {
        var next_check;

        var connect_time = new Date().getTime();

        if (connect_time - last_connect < 2000) { /* to avoid flooding */
            return;
        }

        check_counter++;
        last_connect = connect_time;

        /*//Gogo
        //$.getJSON(base_url + "/backend/notifications.json?check=" + check_counter + "&has_focus=" + has_focus, function(data) {
        */
        $.getJSON("/backend/notifications.json?check=" + check_counter + "&has_focus=" + has_focus, function(data) {
            var now = new Date().getTime();

            writeStorage("n_" + user_id + "_ts", now);

            if (current_count == data.total) {
                return;
            }

            writeStorage("n_" + user_id, encode_data(data));
            update_panel();
        });
    };

    function restart() {
        check_counter = 0;
        has_focus = true;

        if (timeout) {
            clearTimeout(timeout);
            timeout = false;
        }

        update();
    }

    function decode_data(str) {
        if (!str) {
            return null;
        }

        var a = str.split(",");

        return {
            total: a[0],
            privates: a[1],
            posts: a[2],
            comments: a[3],
            friends: a[4],
            favorites: a[5]
        };
    }

    function encode_data(data) {
        return [data.total, data.privates, data.posts, data.comments, data.friends, data.favorites].join(',');
    }

    var translations = {
        privates: "{% trans _('privados nuevos') %}",
        posts: "{% trans _('respuestas a notas') %}",
        comments: "{% trans _('respuestas a comentarios') %}",
        friends: "{% trans _('nuevos amigos') %}",
        favorites: "{% trans _('noticias guardadas') %}"
    };

    function field_text(field) {
        return translations[field];
    }
})();

/**
 * jQuery Unveil modified and improved to accept options and base_url
 * Heavely optimized with timer and checking por min movement between scroll
 * http://luis-almeida.github.com/unveil
 * https://github.com/luis-almeida
 */

(function($) {
    $.fn.unveil = function(options, callback) {
        var settings = {
            threshold: 10,
            base_url: '',
            version: false,
            cache_dir: false
        };

        var $w = $(window),
            timer,
            retina = window.devicePixelRatio > 1.2,
            images = this,
            selector = $(this).selector,
            loaded;

        if (options) {
            $.extend(settings, options);
        }

        if (settings.base_url.charAt(settings.base_url.length - 1) != '/') {
            settings.base_url += "/";
        }

        var cache_regex;

        if (settings.cache_dir) {
            cache_regex = new RegExp("^" + settings.cache_dir + "/");
        }

        this.one("unveil", handler);

        /* We trigger a DOMChanged event when we add new elements */
        $w.on("DOMChanged", function(event, parent) {
            var $e = $(parent);
            var n = $e.find(selector).not(images).not(loaded);

            if (!n.length) {
                return;
            }

            n.one("unveil", handler);

            images = images.add(n);

            n.trigger("unveil");
        });

        function handler() {
            var $e = $(this);
            var source = $e.data("src");

            if (!source) {
                return;
            }

            if (source.charAt(0) === "/" && source.charAt(1) !== "/") {
                source = source.substr(1);
            }

            if (retina) {
                var high = $e.data('2x');

                if (high) {
                    if (high.indexOf("s:") === 0) {
                        var parts = high.split(":");

                        source = source.replace(parts[1], parts[2]);
                    } else {
                        source = high;
                    }
                }
            }

            var version_prefix;
            var base_url = settings.base_url;

            if (settings.version && settings.base_url.length > 1 && source.substr(0, 4) !== 'http' && source.substr(0, 2) !== '//') {
                if (!cache_regex || !cache_regex.test(source)) {
                    base_url += settings.version + "/";
                }

                source = base_url + source;
            }

            $e.attr("src", source);

            if (typeof callback === "function") {
                callback.call(this);
            }
        }

        function unveil() {
            var wt = $w.scrollTop();
            var wb = wt + $w.height();

            var inview = images.filter(":visible").filter(function() {
                var $e = $(this);

                var et = $e.offset().top,
                    eb = et + $e.height();

                return eb >= wt - settings.threshold && et <= wb + settings.threshold;
            });

            loaded = inview.trigger("unveil");
            images = images.not(loaded);
        }

        $w.on('scrollstop resize', unveil);

        unveil();

        return this;
    };
})(jQuery);

function analyze_hash(force) {
    if (!location.hash || !(m = location.hash.match(/#([\w\-]+)$/)) || !(target = $('#' + m[1])).length) {
        return;
    }

    function animate(target, force) {
        var $h = $('#header-top');

        if (force || $h.css('position') === 'fixed' && $(document).scrollTop() > target.offset().top - $h.height()) {
            $('body, html').animate({
                scrollTop: target.offset().top - $h.height() - 10
            }, 'fast');
        }

        target.animate({ opacity: 1.0 }, 'fast');
    }

    target.css('opacity', 0.2);

    /* Highlight a comment if it is referenced by the URL. Currently double border, width must be 3 at least */
    if (link_id > 0 && (m2 = m[1].match(/^c-(\d+)$/)) && m2[1] > 0) {
        /* it's a comment */
        if (target.length) {
            $("#" + m[1]).find(".comment-body").css("border-style", "solid").css("border-width", "1px");
            /* If there is an anchor in the url, displace 80 pixels down due to the fixed header */
        } else {
            /* It's a link to a comment, check it exists, otherwise redirect to the right page */
            canonical = $("link[rel^='canonical']");

            if (canonical.length) {
                self.location = canonical.attr("href") + "/c0" + m2[1] + '#c-' + m2[1];
                return;
            }
        }
    }

    if (force) {
        setTimeout(function() {
            animate(target, true);
        }, 10);
    } else {
        /* Delay scrolling until the document is shown */
        $(window).load(function() {
            animate(target, false);
        });
    }
}

(function($) {
    $.fn.setFocusToEnd = function() {
        this.focus();

        var $initialVal = this.val();

        this.val('').val($initialVal);

        jQuery.event.trigger("editing");

        return this;
    };
})(jQuery);

(function() { /* partial */
    $(document).on("click mousedown touchstart", "a", parse);

    if (do_partial) {

        var sequence = 0;
        var last = 0;

        String.prototype.decodeHTML = function() {
            return $("<div>", { html: "" + this }).html();
        };

        $(window).on("popstate", function(e) {
            state = e.originalEvent.state;

            if (state && (state.name === "partial") && (state.sequence != last)) {
                load(location.href, e.originalEvent.state);
            }
        });
    }

    function parse(e) {
        var m;
        var $a = $(this);
        var href = $a.attr("href");

        if (!href) {
            return false;
        }

        var aClass = $a.attr("class") || '';

        if (e.type !== "click") {
            if ($a.data('done')) {
                return true;
            }

            if ((m = aClass.match(/l:(\d+)/)) && !aClass.match(/tooltip/)) {
                $a.attr('href', base_url_sub + "go?id=" + m[1]);
                $a.data('done', 1);
                $a.data('real_href', href);
            }

            return true;
        }

        var real_href = $a.data('real_href') || $a.attr('href');

        if (
            (aClass.match(/fancybox/) || real_href.match(/\.(gif|jpeg|jpg|pjpeg|pjpg|png|tif|tiff)$|vimeo.com\/\d+|vine\.co\/v\/\w+|youtube.com\/(.*v=|embed)|youtu\.be\/.+|twitter\.com\/.+?\/(?:status|statuses)\/\d+/i)) && !aClass.match(/cbox/) && !$a.attr("target") && fancyBox.parse($a)
        ) {
            return false;
        }

        if (!do_partial) {
            return true;
        }

        /* Only if partial */
        var re = new RegExp("^/|^\\?|//" + location.hostname);

        if ((location.protocol === "http:" || location.protocol === "https:") && re.test(href) && !href.match(/\/backend\/|\/login|\/register|\/profile|\/sneak|rss2/)) {
            load(href.replace(/partial&|\?partial$|&partial/, ''), null);

            return false;
        }
    }

    function load(href, state) {
        var currentState;
        var a = href;

        a = a.replace(/#.*/, '');
        a += ((a.indexOf("?") < 0) ? "?" : "&") + "partial";

        $e = $("#variable");

        $("body").css('cursor', 'progress').trigger('onAjax');

        if (!state) {
            currentState = {
                name: "partial",
                scroll: $(window).scrollTop()
            };

            if (history.state) {
                currentState.sequence = history.state.sequence;
            } else {
                currentState.sequence = 0;
            }

            history.replaceState(currentState, null, location.href);

            sequence++;
            last = sequence;
            currentState.sequence = last;
            currentState.scroll = 0;
            history.pushState(currentState, null, href);
        } else {
            currentState = state;
            last = currentState.sequence;
        }

        $.ajax(a, {
            cache: true,
            dataType: "html",
            success: function(html) {
                $("body").css('cursor', 'default');

                var finalHref = loaded($e, href, html);

                if (!state && href !== finalHref) {
                    history.replaceState(currentState, null, finalHref);
                }

                if (!finalHref) {
                    return false;
                }

                if ('scroll' in currentState) {
                    window.scrollTo(0, currentState.scroll);
                }

                execOnDocumentLoad();
                $e.trigger("DOMChanged", $e);
                analyze_hash(true);
            },
            error: function() {
                location.href = href;
            }
        });
    }

    function loaded($e, href, html) {
        $e.html(html);

        var $info = $e.find("#ajaxinfo");

        if (!$info.length) {
            location.href = href;
            return false;
        }

        if ($info.data('uri')) {
            var uri = $info.data('uri').replace(/partial&|\?partial$|&partial/, '');

            if (href.match(/#.*/)) {
                uri += href.replace(/.*(#.*)/, "$1");
            }

            href = uri;
        }

        if ($info.data('title')) {
            document.title = $info.data('title');
        }

        return href;
    }
})();

function loadJS(url) {
    return $.ajax({
        url: url,
        dataType: "script",
        async: true,
        cache: true,
        success: function() {
            loadedJavascript.push(this.url);
        }
    });
}

function execOnDocumentLoad() {
    var deferred = $.Deferred();

    deferred.resolve();

    $.each(postJavascript, function(ix, url) {
        if ($.inArray(url, loadedJavascript) < 0) {
            deferred = deferred.then(function() {
                return loadJS(url);
            });
        }
    });

    deferred.then(function() {
        postJavascript = [];

        $.each(onDocumentLoad, function(ix, code) {
            try {
                if (typeof code === "function") {
                    code();
                } else {
                    eval(code);
                }
            } catch (err) {
                console.log(err);
            }
        });

        onDocumentLoad = [];
    });
}

/* *=*=* Menemoji Keyboard *=*=* */
var emojiKey = new function() {
    var $panel = null;
    var $html = null;
    var $textarea;

    this.keyboard = function(caller) {
        $(caller).toggleClass('active');

        var commentObj = $(caller).closest('form');

        $textarea = commentObj.find('textarea');

        if (commentObj.find('.emoji-kbd').length) {
            emojiKey.close();
        } else {
            emojiKey.close();

            if (!$html) {
                $.ajax({
                    method: "GET",
                    url: base_url + 'backend/menemoji_kbd',
                    data: { v: version_id },
                    cache: true,
                    success: function(data) {
                        $html = $(data);
                        $panel = $html.insertAfter($textarea);
                        emojiKey.open();
                    },
                });
            } else {
                $panel = $html.insertAfter($textarea);
                emojiKey.open();
            }
        }

        $textarea.setFocusToEnd();

        return false;
    };

    this.open = function() {
        /* Evento de botones emoji */
        $panel.find('.emoji-btn').on('click', function(e) {
            e.preventDefault();
            emojiKey.insert($(this).data('emoji'));
        });

        /* Evento de tabs de teclado emoji */
        $panel.find('.emoji-tab').on('click', function(e) {
            e.preventDefault();

            $panel.find('.emoji-tab').removeClass('active');
            $panel.find('.emoji-panel').removeClass('active');

            $(this).addClass('active');

            $panel.find('#' + $(this).data('target')).addClass('active');
        });
    };

    this.close = function() {
        if ($panel) {
            $panel.remove();
            $panel = null;
        }
    };

    this.insert = function(emojiCode) {
        var caretPos = $textarea[0].selectionStart;
        var textAreaTxt = $textarea.val();
        var txtToAdd = '{' + emojiCode + '} ';

        $textarea.val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos));
        $textarea.setFocusToEnd();
    };
};

$(document).ready(function() {
    var $subsMainMenu = $('.subs-main-menu');

    $('#searchform_button').on('click', function(e) {
        $('#searchform').toggle('fast', function() {
            $(this).find('.searchbox').focus();
        });
    });

    if (is_mobile) {
        var $window = $(window),
            $subHeader = $('.dropdown-menu.menu-subheader'),
            $subHeaderA = $subHeader.find('a'),
            $menuItemSLLi = $('.menu01-itemsl > li'),
            $menuItemSRLi = $('.menu01-itemsr > li');

        if ($subHeaderA.length) {
            var select = $('<select class="select-menu-more-options" onchange="location=this.value"/>');

            $subHeaderA.each(function() {
                var $this = $(this);
                var option = $('<option/>').attr('value', $this.attr('href')).html($this.html());

                if ($this.parent().hasClass('selected')) {
                    option.attr('selected', 'selected');
                }

                option.appendTo(select);
            });

            $('<div class="select-wrapper-more-options"/>').append(select).prependTo('#container');
        }

        $menuItemSLLi.hide();
        $menuItemSRLi.hide();

        $subHeader.empty();

        $menuItemSLLi.each(function(index) {
            if (index >= 3) {
                $subHeader.append($(this));
            }

            $(this).show();
        });

        $subHeader.append('<li class="separator"></li>');

        $menuItemSRLi.each(function(index) {
            $subHeader.append($(this).show());
        });

        $(".header-menu01").show();

        $subsMainMenu.find('.follow-subs').on('click', function() {
            var $this = $(this);

            if ($this.hasClass('open')) {
                $this.removeClass("open");

                $("table.subs-listing").hide();
            } else {
                $this.addClass("open");
                $("table.subs-listing").show();
            }
        });
    }

    $("#header-top .sub-selector").on('click', function(e) {
        e.preventDefault();

        var top = $('.header-top-wrapper').height();

        if ($subsMainMenu.is(':visible')) {
            $subsMainMenu.slideUp('fast');

            $(this).find('i.fa').removeClass('fa-chevron-up').addClass('fa-chevron-down');

            $('.header-sub').show();
        } else {
            $subsMainMenu.css({ 'top': top + 'px' }).slideDown('fast');

            $(this).find('i.fa').removeClass('fa-chevron-down').addClass('fa-chevron-up');

            $('.header-sub').hide();
        }
    });

    /* Calculate height for sub scroll in mobile */

    $(".subs-listing-wrapper").css({
        height: ($(window).height() - 220) + 'px'
    });

    var m, m2, target, canonical;

    /* Put dates */
    $('span.ts').each(to_date);

    $.ajaxSetup({
        cache: false
    });

    $(window).on("DOMChanged", function(event, parent) {
        $(parent).find('span.ts').each(to_date);
        execOnDocumentLoad();
    });

    mDialog.init();

    analyze_hash();

    execOnDocumentLoad();

    $('img.lazy').unveil({
        base_url: base_static,
        version: version_id,
        cache_dir: base_cache,
        threshold: 100
    });

    $('#backTop').backTop();

    $.tooltip();

    $('.showmytitle').on('click', function() {
        mDialog.content('<span style="font-size: 12px">' + $(this).attr('title') + '</span>');
    });

    if (!readCookie("sticky") && !readCookie("a")) {
        setTimeout(function() {
            $.ajax({
                url: base_static + "js/cookiechoices.js",
                cache: true,
                dataType: "script",
                success: function() {
                    cookieChoices.showCookieConsentBar(
                        'Nos obligan a molestarte con la obviedad de que este sitio usa cookies',
                        'cerrar',
                        'más información',
                        base_url + "legal#cookies"
                    );
                }
            });
        }, 2000);
    }

    $("button.social-share").popover({
        placement: 'top',
        trigger: 'click',
        html: true,
        content: function() {
            return $(this).next(".wrapper-share-icons").html();
        }
    });

    $('[data-toggle="tooltip"]').tooltip({
        template: '<div class="mnm-tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
    });

    $(document).on('click', function(e) {
        $('button.social-share').each(function() {
            var $this = $(this);

            if (!$this.is(e.target) && !$this.has(e.target).length && !$('.popover').has(e.target).length) {
                (($this.popover('hide').data('bs.popover') || {}).inState || {}).click = false;
            }
        });
    });

    var clipboard = new Clipboard('.share-link');

    clipboard.on('success', function(e) {
        $(e.trigger).tooltip({
            placement: 'right',
            trigger: 'manual',
            title: 'Copiado',
            template: '<div class="mnm-tooltip share" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
        }).tooltip('show');
    });

    var $menuMore = $('a.dropdown-toggle.menu-more-button'),
        $dropdown = $menuMore.closest('.dropdown');

    $menuMore.on('mouseenter', function() {
        $dropdown.addClass('open');
    });

    $(".dropdown-menu.menu-subheader").on('mouseleave', function() {
        $dropdown.removeClass('open');
    });

    $(".slider-wrapper .sub").on({
        'mouseenter': function() {
            $(this).find('.sub-info').animate({ 'bottom': '30px' }, 200).find('.sub-follow').show();
        },
        'mouseleave': function() {
            $(this).find('.sub-info').animate({ 'bottom': '20px' }, 200).find('.sub-follow').hide();
        }
    });

    var $subsSlider = $('.official-subs-slider');

    $subsSlider.slick({
        dots: true,
        infinite: false,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 3,
        prevArrow: $subsSlider.find('.slick-prev'),
        nextArrow: $subsSlider.find('.slick-next'),
        appendDots: $subsSlider.find('.dots'),
        responsive: [{
            breakpoint: 2000,
            settings: {
                slidesToShow: 5,
                slidesToScroll: 5,
                infinite: true,
                dots: true
            }
        }, {
            breakpoint: 1024,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 4,
                infinite: true,
                dots: true
            }
        }, {
            breakpoint: 700,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                dots: true
            }
        }, {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true
            }
        }]
    });

    var $widgetSubsSlider = $('.widget-official-subs-slider');

    $widgetSubsSlider.slick({
        rtl: true,
        dots: true,
        infinite: false,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 3,
        prevArrow: $subsSlider.find('.slick-prev'),
        nextArrow: $subsSlider.find('.slick-next'),
        appendDots: $subsSlider.find('.dots'),
        responsive: [{
            breakpoint: 2000,
            settings: {
                rtl: true,
                slidesToShow: 5,
                slidesToScroll: 5,
                infinite: false,
                dots: true
            }
        }, {
            breakpoint: 1280,
            settings: {
                rtl: true,
                slidesToShow: 4,
                slidesToScroll: 4,
                infinite: true,
                dots: false
            }
        },{
            breakpoint: 1024,
            settings: {
                rtl: true,
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: false
            }
        }, {
            breakpoint: 700,
            settings: {
                rtl: true,
                slidesToShow: 2,
                slidesToScroll: 2,
                dots: true
            }
        }, {
            breakpoint: 480,
            settings: {
                rtl: true,
                slidesToShow: 2,
                slidesToScroll: 2,
                dots: true
            }
        }]
    });


    $widgetSubsSlider.on('setPosition', function(slick){
        var $wrapper = $('.widget-official-subs-slider div.widget-title-wrapper');
        $wrapper.css({height: $wrapper.parent().width()});
    });

    var $subsSlider = $('.recommended-subs-slider');

    $subsSlider.slick({
        dots: true,
        infinite: false,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 3,
        prevArrow: $subsSlider.find('.slick-prev'),
        nextArrow: $subsSlider.find('.slick-next'),
        appendDots: $subsSlider.find('.dots'),
        responsive: [{
            breakpoint: 2000,
            settings: {
                slidesToShow: 5,
                slidesToScroll: 5,
                infinite: true,
                dots: true
            }
        }, {
            breakpoint: 1024,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 4,
                infinite: true,
                dots: true
            }
        }, {
            breakpoint: 700,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                dots: true
            }
        }, {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true
            }
        }]
    });

    var $widgetPopularLinksSlider = $('.widget-popular-links-slider');
    $widgetPopularLinksSlider.slick({
        rtl: true,
        dots: true,
        infinite: false,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 3,
        prevArrow: $widgetPopularLinksSlider.find('.slick-prev'),
        nextArrow: $widgetPopularLinksSlider.find('.slick-next'),
        appendDots: $widgetPopularLinksSlider.find('.dots'),
        responsive: [{
            breakpoint: 2000,
            settings: {
                rtl: true,
                slidesToShow: 5,
                slidesToScroll: 5,
                infinite: false,
                dots: true
            }
        }, {
            breakpoint: 1280,
            settings: {
                rtl: true,
                slidesToShow: 4,
                slidesToScroll: 4,
                infinite: true,
                dots: false
            }
        },{
            breakpoint: 1024,
            settings: {
                rtl: true,
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: false
            }
        }, {
            breakpoint: 700,
            settings: {
                rtl: true,
                slidesToShow: 2,
                slidesToScroll: 2,
                dots: true
            }
        }, {
            breakpoint: 480,
            settings: {
                rtl: true,
                slidesToShow: 2,
                slidesToScroll: 2,
                dots: true
            }
        }]
    });

    $widgetPopularLinksSlider.on('setPosition', function () {
        $(this).find('.slick-slide').height('auto');
        var slickTrack = $(this).find('.slick-track');
        var slickTrackHeight = $(slickTrack).height();
        $(this).find('.slick-slide').css('height', slickTrackHeight + 'px');
    });

    if (current_user > 0) {
        addPostCode(function() {
            pref_input_check('subs_default_header');
        });
    } else {
        $('#subs_default_header').on('click', function() {
            window.location = base_url + 'login';
        });
    }
});
