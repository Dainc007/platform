import moment from "moment/moment";
import { type Meeting } from "./Index.vue";

export const isSameDay = (date1: Date, date2: Date) => {
    return date1.getFullYear() === date2.getFullYear() &&
        date1.getMonth() === date2.getMonth() &&
        date1.getDate() === date2.getDate()
}

export const allPeriods = [];
const startTime = 480; // 8:00 in minutes
const endTime = 960; // 16:00 in minutes
const interval = 20; // 20 minutes interval

for (let time = startTime; time < endTime; time += interval) {
    const fromHours = Math.floor(time / 60).toString().padStart(2, '0');
    const fromMinutes = (time % 60).toString().padStart(2, '0');
    const toHours = Math.floor((time + interval) / 60).toString().padStart(2, '0');
    const toMinutes = ((time + interval) % 60).toString().padStart(2, '0');
    allPeriods.push({ from: `${fromHours}:${fromMinutes}`, to: `${toHours}:${toMinutes}` });
}

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
