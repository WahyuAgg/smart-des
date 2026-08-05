import { apiFetch, apiFetchJson, baseUrl } from "./httpClient";
import { normalizePaginatedResponse } from "../utils/pagination";

export const perangkatDesaApi = {
    async list({ page = 1, search = "", perPage = 10 } = {}) {
        const params = new URLSearchParams({
            page,
            per_page: perPage,
            search: search || "",
        });
        return apiFetchJson(
            `${baseUrl}/ref-perangkat-desa?${params.toString()}`,
        );
    },
    /** @deprecated Use list() instead */
    paginate(opts) {
        return this.list(opts);
    },

    /**
     * Fetch all perangkat desa items (for dropdowns, etc).
     */
    async listAll() {
        const payload = await apiFetchJson(
            `${baseUrl}/ref-perangkat-desa?per_page=100`,
        );
        return normalizePaginatedResponse(payload).items;
    },

    async getById(id) {
        if (!id) return null;
        try {
            return await apiFetch(`${baseUrl}/ref-perangkat-desa/${id}`);
        } catch {
            return null;
        }
    },

    async create(payload) {
        return apiFetch(`${baseUrl}/ref-perangkat-desa`, {
            method: "POST",
            body: JSON.stringify(payload),
        });
    },

    async update(id, payload) {
        return apiFetch(`${baseUrl}/ref-perangkat-desa/${id}`, {
            method: "PUT",
            body: JSON.stringify(payload),
        });
    },

    async remove(id) {
        return apiFetch(`${baseUrl}/ref-perangkat-desa/${id}`, {
            method: "DELETE",
        });
    },
};
