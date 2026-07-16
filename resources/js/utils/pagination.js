/**
 * Unwraps a Laravel-style paginated API response into { items, meta }.
 * Works for any resource whose payload shape is:
 *   { current_page, last_page, total, data: [...] }
 */
export function mapPaginatedResponse(payload) {
  const items = payload.data ?? payload;

  return {
    items,
    meta: {
      current_page: payload.current_page ?? 1,
      last_page: payload.last_page ?? 1,
      total: payload.total ?? items.length,
    },
  };
}
