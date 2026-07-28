import { API_PATH } from "../../config/bootstrap.js";
import HttpClient from "./HttpClient.js";

export default function Router(route) {
    const basePath = API_PATH;

    // Construit l'URL avec ID et filtres
    const buildUrl = (id = null, filters = {}, strict = true) => {
        const validId = sanitizeId(id);
        if (strict && id && !validId) {
            console.warn(`[Router] buildUrl: L'id ${id} n'est pas un entier positif.`);
            return false;
        }

        let finalPath = basePath;

        // Prépare les filtres + id
        const params = { resource: route, ...filters };
        if (validId) params.id = validId;

        const queryString = getParsedFilters(params);
        if (queryString) finalPath += `?${queryString}`;

        console.log("buildUrl:", finalPath);

        return finalPath;
    };

    async function getOne(id) {
        const url = buildUrl(id);
        return url ? await HttpClient.get(url) : getGenericError();
    }

    async function getAll(filters = {}) {
        const url = buildUrl(null, filters, false);
        return url ? await HttpClient.get(url) : getGenericError();
    }

    async function post(data) {
        return await HttpClient.post(basePath, data);
    }

    async function put(id, data) {
        const url = buildUrl(id);
        return url ? await HttpClient.put(url, data) : getGenericError();
    }

    async function patch(id, data) {
        const url = buildUrl(id);
        return url ? await HttpClient.patch(url, data) : getGenericError();
    }

    async function remove(id) {
        const url = buildUrl(id);
        return url ? await HttpClient.remove(url, id) : getGenericError();
    }

    return { getOne, getAll, post, put, patch, remove };
}

// Transforme un objet filtre en query string
function getParsedFilters(filters) {
    if (!filters || Object.keys(filters).length === 0) return "";
    return Object.entries(filters)
        .map(([k, v]) => `${k}=${encodeURIComponent(v)}`)
        .join("&");
}

function sanitizeId(id) {
    id = Number.parseInt(id);
    return (!Number.isInteger(id) || id <= 0) ? null : id;
}

function getGenericError() {
    return {
        success: false,
        message: "Une erreur inattendue est survenue."
    };
}


