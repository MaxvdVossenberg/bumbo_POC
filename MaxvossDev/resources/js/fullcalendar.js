console.log('Loading fullcalendar.js...');

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import allLocals from '@fullcalendar/core/locales-all';
import interactionPlugin, {Draggable} from '@fullcalendar/interaction';
import flatpickr from "flatpickr";
import { Dutch } from "flatpickr/dist/l10n/nl"

let calendar, editEvent;

//=========================================
// Handles Ajax put request
//=========================================
$(document).ready( function (){
    editEvent = (info) => {
        console.log(info.event.id);
        let token = $("input[name='_token']").val();
        let id = info.event.id;
        let start = info.event.start;
        let end = info.event.end;
        let title = info.event.title;

        $.ajax({
            url: "http://maxvossdev.localhost/events/" + id,
            type:"PUT",
            data: {
                _token: token,
                id: id,
                start: start.toISOString(),
                end: end.toISOString(),
                title: title,
            },
            success:function(data){
                calendar.refetchEvents();
            },
            error: function (data) {
                console.log(data);
                info.revert();
            }
        });
    }
})

//=========================================
// Initializes FullCalendar
//=========================================
document.addEventListener('DOMContentLoaded', function() {
    let calendarEl = document.getElementById('calendar');

    calendar = new Calendar(calendarEl, {
        locales: allLocals,
        locale: 'nl',
        height: 650,
        plugins: [ dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin ],
        editable: true,
        timeZone: 'UTC',
        navLinks: true,
        droppable: true,
        headerToolbar: {
            left: 'today',
            center: 'prev title next',
            right: ''
        },
        titleFormat: { year: 'numeric', month: 'long', day: '2-digit', weekday: 'short'},
        initialView: 'timeGridDay',
        lazyFetching: true,
        eventDrop (info) {
            editEvent(info);
        },
        eventResize(info) {
            console.log(info);
            editEvent(info);
        },
        eventReceive(info) {
            makePostRequest(info.event.groupId, info.event.start.toISOString(), info.event.end.toISOString(), info.event.title, info.event.url, 0);
            calendar.refetchEvents();
        }
    });

    calendar.render();

    $(".draggable-item").each(function () {
        new Draggable(this, {

            itemSelector: '.draggable-item',
            eventData: {
                title: $(this).find('td:eq(0)').text(),
                duration: '01:00',
                groupId: this.id,
                color: $(this).find('td:eq(2)').css('color'),
            },
        });
    });
});

//=========================================
// Initialization of buttons and inputs
//=========================================
$(document).ready(function () {
    let startInput = $("#startInput");
    let endInput = $("#endInput");

    flatpickr(startInput, {
        enableTime: true,
        dateFormat: 'Y-m-d H:i',
        locale: Dutch,
        static: true
    });

    flatpickr(endInput, {
        enableTime: true,
        dateFormat: 'Y-m-d H:i',
        locale: Dutch,
        static: true
    });

    $("#localeButton").click(function () {
        if($(this).text() === "Deutsch") {
            $(this).html('Nederlands');
            calendar.setOption('locale', 'de');
        } else {
            $(this).html('Deutsch');
            calendar.setOption('locale', 'nl');
        }
    });

    $(":checkbox").change(function () {
        handleEventSource(this);
    })
});

//=========================================
// Handles Event Source Changes
//=========================================
const handleEventSource = (option) => {
    let id = option.value;
    let color = $('label[for=inlineCheckbox' + id +']').css('color');
    let fontColor = 'white';

    if(option.checked) {
        let c = color.substring(1);
        let rgb = parseInt(c, 16);
        let r = (rgb >> 16) & 0xff;
        let g = (rgb >>  8) & 0xff;
        let b = (rgb >>  0) & 0xff;

        let luma = 0.2126 * r + 0.7152 * g + 0.0722 * b;

        if (luma > 128) {
            fontColor = 'black'
        }
        calendar.addEventSource({
            url: 'http://maxvossdev.localhost/events/department/' + id,
            color: color,
            id: id,
            textColor: fontColor,
        });
    } else {
        let source = calendar.getEventSourceById(id);
        if(source != null)
            source.remove();
    }
}

//=========================================
// Initialization of the event sources
//=========================================
$(document).ready(function () {
    $(".form-check-input").each(function () {
        handleEventSource(this);
    })
});

//=========================================
// Handles form submission
//=========================================
$(document).ready(function () {
    $("#createEventButton").click(function(event){
        event.preventDefault();
        let start = $("#startInput").val();
        let end = $("#endInput").val();
        let title = $("#title").val();
        let url = $("#url").val();
        let department = $("#department option:selected").val();
        let allDay = $("#allDay").prop("checked") ? 1 : 0;
        makePostRequest(department, start, end, title, url, allDay);
    });
})

//=========================================
// Handles Ajax post request
//=========================================
const makePostRequest = (department_id, start, end, title, url, allDay) => {
    const removeError = () => {
        $('.alert').removeClass('show');
        $('#errorBag').html('');
    }

    let token = $("input[name='_token']").val();
    console.log(department_id);
    $.ajax({
        url: "http://maxvossdev.localhost/events",
        type:"POST",
        data: {
            _token: token,
            department_id: department_id,
            start: start,
            end: end,
            title: title,
            url: url ?? "http://maxvossdev.localhost/dashboard#",
            allDay: allDay
        },
        success:function(data){
            $('#newEventForm')[0].reset();
            return true;
        },
        error: function (data) {
            console.log(data.responseJSON);
        }
    });
}
