import { FETCH_USE_CREDENTIALS } from "../../config/bootstrap.js";

async function fetchRequest(url, options, resultType = "json") {
    let errors = [];
    let response;

    try {
        options.credentials = 'include';
        response = await fetch(url, options);
    } catch (err) {
        errors.push(`[HttpRequest] ~ ${options.method ?? "GET"} ~ ${url} : ${err}`);
        console.error(errors[0]);
    }

    if (!response) {
        ErrorHandler("Impossible de joindre le serveur.", 0, errors);
        return;
    }

    let data = null;
    try {
        switch (resultType) {
            case "text":
                data = await response.text();
                break;

            case "json":
                data = await response.json();
                break;

            case "blob":
                data = await response.blob();
                break;

            case "arrayBuffer":
                data = await response.arrayBuffer();
                break;
        }
    } catch (err) {
        errors.push(`[HttpRequest] ~ Type ${resultType ?? "Unknown"} non pris en charge ~ ${url} : ${err}`);
        console.error(errors[1]);
    }

    return data ?? ErrorHandler("Une erreur est survenue lors du traitement des données.", response.status, errors);
}

async function get(url, options = {}, resultType = "json") {
    return await fetchRequest(url, options, resultType);
}

async function post(url, data, options = {}, resultType = "json") {
    options = {
        ...options,
        body: JSON.stringify(data)
    }
    return await fetchRequest(url, options, resultType);
}

function ErrorHandler(message, status, errors = []) {
    return {
        success: false,
        message,
        errors,
        status
    };
}

const HttpRequest = { get, post };
export default HttpRequest;