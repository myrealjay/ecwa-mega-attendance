import moment from 'moment';

export function formatDate(date, withoutTime = false) {
    if (!date) {
        return '';
    }

    if (withoutTime) {
        return moment.utc(date).format('YYYY MMM DD');
    }

    return moment.utc(date).format('YYYY MMM DD, HH:MM A');
}