// 👇 Функция для сериализации вложенных объектов/массивов в query string
function buildQuery(obj: any, prefix = ''): string {
    const pairs: string[] = [];

    for (const key in obj) {
        if (!Object.prototype.hasOwnProperty.call(obj, key)) continue;

        const value = obj[key];
        const prefixedKey = prefix ? `${prefix}[${key}]` : key;

        if (typeof value === 'object' && value !== null && !Array.isArray(value)) {
            pairs.push(buildQuery(value, prefixedKey)); // рекурсивно
        } else if (Array.isArray(value)) {
            value?.forEach((item) => {
                pairs.push(`${encodeURIComponent(prefixedKey)}[]=${encodeURIComponent(item)}`);
            });
        } else {
            pairs.push(`${encodeURIComponent(prefixedKey)}=${encodeURIComponent(value)}`);
        }
    }

    return pairs.join('&');
}

// 👇 Основная функция HTTP-запроса
export async function httpRequest<T = any>(
    url: string,
    method: string,
    data?: any,
    headers: Record<string, string> = {}
): Promise<T> {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    const combinedHeaders: Record<string, string> = {
        Accept: 'application/json',
        ...headers
    };

    if (csrfToken) {
        combinedHeaders['X-CSRF-TOKEN'] = csrfToken;
    }

    let body: BodyInit | undefined;

    if (method.toUpperCase() === 'GET' && data && typeof data === 'object') {
        const queryString = buildQuery(data);
        if (queryString) {
            url += (url.includes('?') ? '&' : '?') + queryString;
        }
    } else if (data instanceof FormData) {
        body = data;
        // Не указываем Content-Type — браузер сам установит
    } else if (data) {
        combinedHeaders['Content-Type'] = 'application/json';
        body = JSON.stringify(data);
    }

    const response = await fetch(url, {
        method,
        headers: combinedHeaders,
        body: method.toUpperCase() === 'GET' ? undefined : body
    });

    const contentType = response.headers.get('content-type');

    if (!response.ok) {
        if (contentType?.includes('application/json')) {
            throw await response.json(); // Laravel-style error
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
