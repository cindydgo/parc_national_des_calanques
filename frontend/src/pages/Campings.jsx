import Router from "../api/Router.js";
import { useState, useEffect } from "react";
import { useParams } from "react-router-dom";

const Campings = () => {
    const { campingId } = useParams();

    const [campings, setCampings] = useState([]);
    const [success, setSuccess] = useState(false);
    const [loaded, setLoaded] = useState(false);

    useEffect(() => {
        const HttpCampings = Router("campings");
        const locationsData = async() => {
            setLoaded(false);
            setSuccess(false);

            try {
                const fetchResult = campingId
                    ? await HttpCampings.getOne(campingId)
                    : await HttpCampings.getAll({ limit: 6 });

                if (fetchResult.success) {
                    const data = fetchResult.data;
                    setCampings(Array.isArray(data) ? data : [data]);
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

        locationsData();
    }, [campingId]);

    if (!loaded) {
        return <p>Chargement en cours...</p>;
    }

    if (!success) {
        return (
            <div>
                <p>Une erreur est survenue...</p>
                <p>{ campings?.message }</p>
            </div>
        )
    }

    return (
        <div>
            <h2>Les Campings</h2>
            {campings.length > 0 ? (
                campings.map((camping, index) => (
                    <pre key={index}>
                        {JSON.stringify(camping, null, 2)}
                    </pre>
                ))
                ) : (
                    <p>Aucun Camping à afficher.</p>
            )}
        </div>
    )
}

export default Campings;
