export function toNullableNumber(value) {
  if (value === '' || value === null || value === undefined) return null;

  const number = Number(value);
  return Number.isNaN(number) ? null : number;
}
