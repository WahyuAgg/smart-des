/**
 * Unwraps a Laravel-style paginated API response into { items, meta }.
 * Works for any resource whose payload shape is:
 *   { current_page, last_page, total, data: [...] }
 */
function unwrapResponseData(payload) {
  return payload?.data ?? payload ?? {};
}

export function normalizeCollectionResponse(payload) {
  const body = unwrapResponseData(payload);

  if (Array.isArray(body)) {
    return body;
  }

  if (body && Array.isArray(body.data)) {
    return body.data;
  }

  return [];
}

export function normalizePaginatedResponse(payload) {
  const body = unwrapResponseData(payload);
  const items = Array.isArray(body?.data) ? body.data : [];

  return {
    items,
    meta: {
      current_page: body.current_page ?? 1,
      last_page: body.last_page ?? 1,
      total: body.total ?? items.length,
    },
  };
}

export function mapPaginatedResponse(payload) {
  return normalizePaginatedResponse(payload);
}
