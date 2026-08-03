import { Auth } from './auth';

export const baseUrl = window.API_BASE_URL || '/api';

/**
 * Thrown when the request was unauthorized and Auth.handleUnauthorized()
 * already took care of it (e.g. redirect to login). Callers should catch
 * this and simply stop, without setting an error message.
 */
export class UnauthorizedError extends Error {
  constructor() {
    super('Unauthorized');
    this.name = 'UnauthorizedError';
  }
}

/**
 * Wraps fetch() with the project's conventions:
 * - merges Auth.headers()
 * - auto-sets Content-Type: application/json for POST/PUT with plain body
 * - detects and short-circuits on 401 via Auth.handleUnauthorized()
 * - parses JSON safely
 * - throws a normal Error with the API's message on failure
 * - unwraps the common `{ success, data, message }` envelope
 */
export async function apiFetch(url, options = {}) {
  const method = (options.method || 'GET').toUpperCase();

  // Auto-set Content-Type: application/json for POST/PUT with plain object body
  let { headers, body } = options;
  if ((method === 'POST' || method === 'PUT') && body && typeof body === 'string' && !(body instanceof FormData)) {
    headers = { 'Content-Type': 'application/json', ...headers };
  }

  const response = await fetch(url, {
    ...options,
    headers: Auth.headers(headers),
  });

  if (Auth.handleUnauthorized(response)) {
    throw new UnauthorizedError();
  }

  const json = await response.json().catch(() => ({}));

  if (!response.ok || (json.success !== undefined && !json.success)) {
    throw new Error(json.message || 'Terjadi kesalahan pada server.');
  }

  return json.data ?? json;
}

export async function apiFetchJson(url, options = {}) {
  const response = await fetch(url, {
    ...options,
    headers: Auth.headers(options.headers),
  });

  if (Auth.handleUnauthorized(response)) {
    throw new UnauthorizedError();
  }

  const json = await response.json().catch(() => ({}));

  if (!response.ok || (json.success !== undefined && !json.success)) {
    throw new Error(json.message || 'Terjadi kesalahan pada server.');
  }

  return json;
}
