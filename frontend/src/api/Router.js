import { API_PATH } from "../../config/bootstrap.js";
import HttpClient from "./HttpClient.js";

export default function Router(route) {
    const basePath = `${API_PATH}/${route}`;

    const buildUrl = (method, id, filters = {}, strict = true) => {
        id = sanitizeId(id, basePath, method);
        if (strict && !id) {
            console.warn(`[Router] ~ ${method} ~ ${basePath} : L'id ${id} n'est pas un entier positif.`);
            return false;
        }

        let finalPath = basePath;
        finalPath += id ? `/${id}` : "";
        finalPath += getParsedFilters(filters);
        return finalPath;
    }

    async function getOne(id) {
        const url = buildUrl("GET", id);
        return url ? await HttpClient.get(url) : getGenericError();
    }

    async function getAll(filters = {}) {
        return await HttpClient.get(buildUrl("GET", null, filters, false));
    }

    async function post(data) {
        return await HttpClient.post(basePath, data);
    }

    async function put(id, data) {
        const url = buildUrl("PUT", id)
        return url ? await HttpClient.put(url, data) : getGenericError();
    }

    async function patch(id, data) {
        const url = buildUrl("PATCH", id)
        return url ? await HttpClient.patch(url, data) : getGenericError();
    }

    async function remove(id) {
        const url = buildUrl("DELETE", id);
        return url ? await HttpClient.remove(url, id) : getGenericError();
    }

    return { getOne, getAll, post, put, patch, remove };
}

function getParsedFilters(filters) {
    if (!filters || Object.keys(filters).length === 0) return "";
    return "?" + Object.entries(filters).map(([k, v]) => `${k}=${encodeURIComponent(v)}`).join("&");
}

function sanitizeId(id) {
    id = Number.parseInt(id);
    return (!Number.isInteger(id) || id <= 0) ? null : id;
}

function getGenericError() {
    return {
        success: false,
        message: "Une erreur inattendue est survenue."
    }
}
