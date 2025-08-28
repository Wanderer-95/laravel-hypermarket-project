export async function httpRequest<T = any>(
    url: string,
    method: string,
    data?: any,
    headers: Record<string, string> = {}
): Promise<T> {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const combinedHeaders: Record<string, string> = { ...headers };

    if (csrfToken) {
        combinedHeaders['X-CSRF-TOKEN'] = csrfToken;
    }

    let body: BodyInit | undefined;

    if (data instanceof FormData) {
        body = data;
        // Не ставим Content-Type, fetch сам выставит multipart/form-data
    } else if (data) {
        combinedHeaders['Content-Type'] = 'application/json';
        body = JSON.stringify(data);
    }

    const response = await fetch(url, {
        method,
        headers: combinedHeaders,
        body
    });

    if (!response.ok) {
        const errorText = await response.text();
        throw new Error(`HTTP error! status: ${response.status}, response: ${errorText}`);
    }

    // Пытаемся распарсить как JSON, иначе возвращаем текст
    const contentType = response.headers.get('content-type');
    if (contentType?.includes('application/json')) {
        return await response.json();
    } else {
        return (await response.text()) as unknown as T;
    }
}
