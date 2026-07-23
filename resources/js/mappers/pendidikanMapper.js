export function emptyForm() {
  return {
    tingkat_pendidikan: '',
  };
}

export function mapItemToForm(item) {
  return {
    tingkat_pendidikan: item.tingkat_pendidikan ?? '',
  };
}

export function buildPayload(form) {
  return {
    tingkat_pendidikan: String(form.tingkat_pendidikan || '').trim(),
  };
}