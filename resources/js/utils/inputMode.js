const LABELS = {
  auto: 'Otomatis',
  manual: 'Manual',
  auto_editable: 'Otomatis (edit)',
};

const BADGES = {
  auto: 'bg-slate-100 text-slate-600',
  manual: 'bg-amber-100 text-amber-700',
  auto_editable: 'bg-accent-light text-accent-hover',
};

export function inputModeLabel(mode) {
  return LABELS[mode] || mode;
}

export function inputModeBadge(mode) {
  return BADGES[mode] || 'bg-slate-100 text-slate-600';
}
