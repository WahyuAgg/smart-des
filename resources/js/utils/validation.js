/**
 * Reusable input validation helpers.
 */

export function isEmail(email) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

export function isNik(nik) {
  return /^\d{16}$/.test(nik);
}

export function isRequired(value) {
  return value !== null && value !== undefined && String(value).trim() !== '';
}
