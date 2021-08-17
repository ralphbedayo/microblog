export function getToken() {
    return document.querySelector('meta[name="token"]')?.getAttribute('content');
}


export function sortCaseInsensitive(value, key = null, type = 'asc') {
    return value.sort((first, second) => {
        let ordering = 0;

        if (key !== null) {
            first = _.isFunction(key) ? key(first) : first[key];
            second = _.isFunction(key) ? key(second) : second[key];
        }

        if (_.isNil(first)) {
            ordering = -1;
        } else if (_.isNil(second)) {
            ordering = 1;
        } else if (_.isNumber(first) && _.isNumber(second)) {
            ordering = first - second;
        } else if (_.isString(first) && _.isString(second)) {
            first = first.toLowerCase();
            second = second.toLowerCase();

            if (first < second) ordering = -1;
            else if (first > second) ordering = 1;
        }

        return ordering * (type === 'asc' ? 1 : -1);
    });
}
