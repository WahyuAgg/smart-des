export function genderLabel(value) {
  return value || '—';
}

export function statusBadge(status) {
  return status === 'MENINGGAL'
    ? 'bg-rose-100 text-rose-700'
    : 'bg-emerald-100 text-emerald-700';
}

export function statusLabel(status) {
  return status === 'MENINGGAL' ? 'Meninggal' : 'Hidup';
}
