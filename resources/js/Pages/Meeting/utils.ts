import moment from "moment/moment";
import { type Meeting } from "./Index.vue";

export const isSameDay = (date1: Date, date2: Date) => {
    return date1.getFullYear() === date2.getFullYear() &&
        date1.getMonth() === date2.getMonth() &&
        date1.getDate() === date2.getDate()
}

export const allPeriods = [
    { from: '8:00', to: '8:20' },
    { from: '8:21', to: '8:40' },
    { from: '8:41', to: '9:00' },
    { from: '9:01', to: '9:20' },
    { from: '9:21', to: '9:40' },
    { from: '9:41', to: '10:00' },
    { from: '10:01', to: '10:20' },
    { from: '10:21', to: '10:40' },
    { from: '10:41', to: '11:00' },
    { from: '11:01', to: '11:20' },
    { from: '11:21', to: '11:40' },
    { from: '11:41', to: '12:00' },
    { from: '12:01', to: '12:20' },
    { from: '12:21', to: '12:40' },
    { from: '12:41', to: '13:00' },
    { from: '13:01', to: '13:20' },
    { from: '13:21', to: '13:40' },
    { from: '13:41', to: '14:00' },
    { from: '14:01', to: '14:20' },
    { from: '14:21', to: '14:40' },
    { from: '14:41', to: '15:00' },
    { from: '15:01', to: '15:20' },
    { from: '15:21', to: '15:40' },
    { from: '15:41', to: '16:00' },
];

export const mapMeetingsToEvents = (meeting: Meeting) => ({
    id: meeting.id,
    title: meeting.title,
    with: meeting.user.name,
    time: {
        start: moment(meeting.start_date).format('YYYY-MM-DD HH:mm'),
        end: moment(meeting.end_date).format('YYYY-MM-DD HH:mm'),
    },
    color: "yellow",
    isEditable: true,
    description: meeting.description,
});

type Period = {
    from: string,
    to: string;
}

export const isPeriodStale = (period: Period) => {
    const now = new Date();

    const [startHour, startMinute] = period.from.split(':', 2);

    if (now.getHours() > Number(startHour)) {
        return true;
    }

    return now.getHours() === Number(startHour) && now.getMinutes() >= Number(startMinute);
}
