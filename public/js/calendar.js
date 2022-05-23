window.onload = () => {
    let calendarElt = document.querySelector('#calendrier');

    let calendar = new FullCalendar.Calendar(calendarElt, {
        initialView: 'dayGridMonth',
        locale: 'fr',
        timeZone: 'Europe/Paris',
        selectable: true,
        headerToolbar : {
            start : 'prev',
            center :'title',
            end : 'next'
        },
        contentHeight: 600,
    });
    calendar.render();
}