export async function httpRequest<T = any>(
    url: string,
    method: string,
    data?: any,
    headers: HeadersInit = {}
): Promise<T> {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const combinedHeaders: HeadersInit = {
        'Content-Type': 'application/json',
        ...headers,
    };

    if (csrfToken) {
        (combinedHeaders as Record<string, string>)['X-CSRF-TOKEN'] = csrfToken;
    }

    const body = data ? JSON.stringify(data) : undefined;

    const response = await fetch(url, {
        method,
        headers: combinedHeaders,
        body,
    });

    const responseText = await response.text();
    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}, response: ${responseText}`);
    }

    try {
        return JSON.parse(responseText);
    } catch (e) {
        throw e;
    }
}
