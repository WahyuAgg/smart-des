export function emptyForm() {
  return {
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: '',
    is_active: true,
  };
}

export function mapItemToForm(item) {
  return {
    name: item.name ?? '',
    email: item.email ?? '',
    password: '',
    password_confirmation: '',
    role: item.role_name ?? '',
    is_active: item.is_active ?? true,
  };
}

export function buildPayload(form) {
  const payload = {
    name: form.name,
    email: form.email,
    role: form.role,
    is_active: form.is_active,
  };

  if (form.password) {
    payload.password = form.password;
  }

  return payload;
}