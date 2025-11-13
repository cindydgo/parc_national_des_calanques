import Router from "../api/Router.js";
import { useState, useEffect } from "react";
import { useParams } from "react-router-dom";

const Sentiers = () => {
    const {sentierId } = useParams();

    const [sentiers, setSentiers] = useState([]);
    const [success, setSuccess] = useState(false);
    const [loaded, setLoaded] = useState(false);

    useEffect(() => {
        const HttpSentiers = Router("sentiers");
        const sentiersData = async() => {
            setLoaded(false);
            setSuccess(false);

            try {
                const fetchResult = sentierId
                    ? await HttpSentiers.getOne(sentierId)
                    : await HttpSentiers.getAll({ limit: 6 });

                if (fetchResult.success) {
                    const data = fetchResult.data;
                    setSentiers(Array.isArray(data) ? data : [data]);
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

        sentiersData();
    }, [sentierId]);

    if (!loaded) {
        return <p>Chargement en cours...</p>;
    }

    if (!success) {
        return (
            <div>
                <p>Une erreur est survenue...</p>
                <p>{ sentiers?.message }</p>
            </div>
        )
    }

    return (
        <div>
            <h2>Les Sentiers</h2>
            {sentiers.length > 0 ? (
                sentiers.map((sentier, index) => (
                    <pre key={index}>
                        {JSON.stringify(sentier, null, 2)}
                    </pre>
                ))
                ) : (
                    <p>Aucun Sentier à afficher.</p>
            )}
        </div>
    )
}

export default Sentiers;
