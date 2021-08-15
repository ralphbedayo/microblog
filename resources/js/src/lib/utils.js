

export function getToken() {
    return document.querySelector('meta[name="token"]')?.getAttribute('content');
}
