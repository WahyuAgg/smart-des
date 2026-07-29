# TODO

## 🔴 High Priority

- fix FE alamat penduduk
- API galery
- API UI User

- FE jenis surat
- FE galery
- FE revisi UI remove unwanted placeholder // pending
- Insert data penduduk
- Implementasi Sqlite 
- Deployment

---

## 🟡 Medium Priority

- Docker Docker
- API UI backup  // pending


---

## 🟢 Low Priority

- 

___________________

## Dashboard

- Jumlah KK
- Jumlah Penduduk
- jimlah laki laki
- jumlah perempuan


## improvement


1. **Auto-register Alpine components** — Scan `pages/` directory instead of manually importing each in `app.js`.
2. **Standardise CRUD template** — Create a Blade `@include` or component that auto-generates index/table/form for simple master data entities.
3. **Unify API response format** — Ensure all endpoints return consistent JSON shape (`{ data, meta }`) so `normalizePaginatedResponse` works universally.
4. **Add TypeScript** — Gradually migrate `.js` files to `.ts` for better type safety across services, mappers, and composables.
5. **Error boundary component** — Wrap API calls in a reusable error handler instead of repeating try-catch in every page.
6. **Search/filter composable** — Extract common search/filter/pagination logic into a single `useCrudList` composable to reduce boilerplate in page components.
7. **Test coverage** — Add Vitest (Alpine) + PHPUnit (Laravel) tests for critical flows (penduduk, surat wizard, peminjaman).
8. **Component documentation** — Add JSDoc blocks to all services, mappers, and composables for better IDE intellisense.
9. **Lazy-loading** — For large pages (surat wizard, penduduk form), split Alpine components to reduce initial bundle size.
10. **Dark mode support** — Add CSS variables and a toggle for dark/light theme via Alpine.
