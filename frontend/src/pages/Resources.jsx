import Router from "../api/Router.js";
import { useState, useEffect } from "react";
import { useParams } from "react-router-dom";

const Resources = () => {
    const { resourceId } = useParams();

    const [resources, setResources] = useState([]);
    const [success, setSuccess] = useState(false);
    const [loaded, setLoaded] = useState(false);

    useEffect(() => {
        const HttpResources = Router("resources");
        const resourcesData = async() => {
            setLoaded(false);
            setSuccess(false);

            try {
                const fetchResult = resourceId
                    ? await HttpResources.getOne(resourceId)
                    : await HttpResources.getAll({ limit: 6 });

                if (fetchResult.success) {
                    const data = fetchResult.data;
                    setResources(Array.isArray(data) ? data : [data]);
                    setSuccess(true);
                } else {
                    console.error(fetchResult.errors);
                }
            } catch (err) {
                console.error(err);
            } finally {
                setLoaded(true);
            }
        };

        resourcesData();
    }, [resourceId]);

    if (!loaded) {
        return <p>Chargement en cours...</p>;
    }

    if (!success) {
        return (
            <div>
                <p>Une erreur est survenue...</p>
                <p>{ resources?.message }</p>
            </div>
        )
    }

    return (
        <div>
        {resources.length > 0 ? (
            resources.map((resource, index) => (
                <pre key={index}>
                    {JSON.stringify(resource, null, 2)}
                </pre>
            ))
            ) : (
                <p>Aucune Ressource à afficher.</p>
        )}
        </div>
    )
}

export default Resources;
