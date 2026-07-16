export function emptyForm() {
  return {
    nama: '',
    label: '',
    tipe: 'text',
    placeholder: '',
    keterangan: '',
    input_mode: 'manual',
    source: '',
    source_field: '',
  };
}

export function mapItemToForm(item) {
  return {
    nama: item.nama ?? '',
    label: item.label ?? '',
    tipe: item.tipe ?? 'text',
    placeholder: item.placeholder ?? '',
    keterangan: item.keterangan ?? '',
    input_mode: item.input_mode ?? 'manual',
    source: item.source ?? '',
    source_field: item.source_field ?? '',
  };
}

export function buildPayload(form) {
  return {
    ...form,
    source: form.source || null,
    source_field: form.source_field || null,
  };
}
