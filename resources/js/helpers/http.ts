export async function httpRequest<T = any>(
    url: string,
    method: string,
    data?: any,
    headers: Record<string, string> = {}
): Promise<T> {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const combinedHeaders: Record<string, string> = {
        Accept: 'application/json', // 👈 всегда просим JSON
        ...headers
    };

    if (csrfToken) {
        combinedHeaders['X-CSRF-TOKEN'] = csrfToken;
    }

    let body: BodyInit | undefined;

    if (data instanceof FormData) {
        body = data;
        // Content-Type не указываем — browser сам выставит
    } else if (data) {
        combinedHeaders['Content-Type'] = 'application/json';
        body = JSON.stringify(data);
    }

    const response = await fetch(url, {
        method,
        headers: combinedHeaders,
        body
    });

    const contentType = response.headers.get('content-type');

    if (!response.ok) {
        if (contentType?.includes('application/json')) {
            throw await response.json(); // Laravel вернёт { errors: {field: ["msg"]}, message: "..."}
        } else {
            const errorText = await response.text();
            throw new Error(`HTTP error! status: ${response.status}, response: ${errorText}`);
        }
    }

    if (contentType?.includes('application/json')) {
        return await response.json();
    } else {
        return (await response.text()) as unknown as T;
    }
}
