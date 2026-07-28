import Slideshow from "./Slideshow";
import { useEffect, useState } from "react";
import { Link, useParams } from "react-router-dom";
import { getImagesForCamping } from "../data/CampingsData";
import SearchFilters from "./SearchFilters";
import Rating from "./Rating";
import BasicDatePicker from "./DatePicker";
import Card from 'react-bootstrap/Card';
import Button from 'react-bootstrap/Button';
import Router from "../api/Router";
import "../assets/css/Campings.css";

function CampingsComponent() {
    const { campingId } = useParams();
    const [campings, setCampings] = useState([]);
    const [success, setSuccess] = useState(false);
    const [loaded, setLoaded] = useState(false);

    const [campingAmenities, setCampingAmenities] = useState([]);
    const [selectedAmenities, setSelectedAmenities] = useState([]); 
    const [maxPrice, setMaxPrice] = useState(500);

    useEffect(() => {
        const HttpCampings = Router("campings");
        const locationsData = async () => {
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

    useEffect(() => {
        const HttpCampingAmenities = Router("campingamenities");

        const fetchCampingAmenities = async () => {
            try {
                const result = await HttpCampingAmenities.getAll();

                if (result.success) {
                    setCampingAmenities(result.data);
                }
            } catch (err) {
                console.error(err);
            }
        };

        fetchCampingAmenities();
    }, []);

    if (!loaded) {
        return <p>Chargement en cours...</p>;
    }

    if (!success) {
        return (
            <div>
                <p>Une erreur est survenue...</p>
                <p>{ campings?.message }</p>
            </div>
        );
    }

    const campingAmenitiesMap = {};

    campingAmenities.forEach(c => {
        if (!campingAmenitiesMap[c.camping_id]) {
            campingAmenitiesMap[c.camping_id] = [];
        }
        campingAmenitiesMap[c.camping_id].push(c.amenity_id);
    });

    return (
        <div className={`campings-container ${campingId ? "p-4" : "p-3"}`}>
            {campingId && (
                <div className="d-flex align-items-center justify-content-center gap-2 mb-4">
                    <h1 className="campings-header fw-semibold m-0">{campings[0]?.name}</h1>
                    <span className="badge text-bg-primary">{(campings[0]?.rating * 2).toFixed(1)}</span>
                </div>
            )}
            <div className={campingId ? "" : "d-flex gap-3"}>
                {!campingId && (
                    <SearchFilters 
                        value={maxPrice}    
                        setValue={setMaxPrice}
                        selectedAmenities={selectedAmenities} 
                        setSelectedAmenities={setSelectedAmenities}
                    />
                )}
                <div className={campingId ? "" : "d-flex flex-column gap-3 w-100 pt-3 pb-3"}>
                    {!campingId && (
                        <h1 className="campings-header fw-semibold text-start">Les établissements : {campings.length} campings trouvés</h1>
                    )}
                    {campings.length > 0 ? (
                        campings.map((camping, index) => {
                            const images = getImagesForCamping(camping.slug);
                            const amenitiesOfCamping = campingAmenitiesMap[camping.id] || [];

                            const hasAmenities = selectedAmenities.length === 0
                                ? true
                                : selectedAmenities.every(id => amenitiesOfCamping.includes(id));

                            const isVisible = camping.price <= maxPrice && hasAmenities;

                            return (
                                <div 
                                    key={index} 
                                    className={campingId ? "d-flex flex-column gap-3" : ""}
                                    style={{ display: isVisible ? 'flex' : 'none' }}
                                >
                                    {campingId ? (
                                        <>
                                            <Card className="campings-box-shadow">
                                                <Slideshow
                                                    repertory="campings"
                                                    images={images}
                                                    slug={camping.slug}
                                                />
                                                <Card.Body>
                                                    <Card.Text className="d-flex justify-content-center align-items-center gap-2">
                                                        <i class="fa-solid fa-location-dot text-danger"></i>
                                                        <span>{camping.location}</span>
                                                    </Card.Text>
                                                    <Card.Text><b>Description:</b> <br/>{camping.description}</Card.Text>
                                                </Card.Body>
                                            </Card>
                                            <div className="d-flex w-100 gap-3">
                                                <Card className="w-50 campings-box-shadow">
                                                    <Card.Header className="fw-semibold">Caractéristiques</Card.Header>
                                                    <Card.Body className="d-flex flex-column align-items-start">
                                                        <Card.Text className="d-flex"> <b>Piscine :</b>&nbsp;
                                                            {camping.pool && camping.pool > 0 ? (
                                                                <div className="d-flex justify-content-center align-items-center gap-2">
                                                                    <span>Oui</span>
                                                                    <i className="fa-solid fa-square-check text-success"></i>
                                                                </div>
                                                            ) : (
                                                                <div className="d-flex justify-content-center align-items-center gap-2">
                                                                    <span>Non</span>
                                                                    <i className="fa-solid fa-square-xmark text-danger"></i>
                                                                </div>
                                                            )}
                                                        </Card.Text>
                                                        <Card.Text>
                                                            <b>Capacité :</b> {camping.capacity} personnes
                                                        </Card.Text>
                                                        <Card.Text>
                                                            <b>Environnement :</b> {camping.environment}
                                                        </Card.Text>
                                                        <Card.Text>
                                                            <b>Type :</b> {camping.type}
                                                        </Card.Text>
                                                        <Card.Text className="d-flex">
                                                            {camping.activities && camping.activities.length > 0 && (
                                                                <>
                                                                    <b>Activités :</b>&nbsp;
                                                                    <ul className="list-unstyled mb-0">
                                                                        {camping.activities.split(',').map((activity, index) => (
                                                                            <li key={index} className="badge bg-primary ms-1 me-2">
                                                                                {activity.trim()}
                                                                            </li>
                                                                        ))}
                                                                    </ul>
                                                                </>
                                                            )}
                                                        </Card.Text>
                                                        
                                                    </Card.Body>  
                                                </Card>
                                                <Card className="w-50 campings-box-shadow">
                                                    <Card.Header className="fw-semibold">Réservez votre séjour</Card.Header>
                                                    <Card.Body className="d-flex flex-column justify-content-between">
                                                        <BasicDatePicker label="Date d'arrivée" />
                                                        <BasicDatePicker label="Date de départ" />
                                                        <Button variant="primary fw-semibold">Réserver</Button>
                                                    </Card.Body>
                                                </Card>
                                            </div>
                                        </>
                                    ) : (
                                        <div class="card camping-card">
                                            <div class="row" style={{maxHeight: '150px'}}>
                                                <div class="col-md-4 h-100">
                                                    <img
                                                        src={`/images/campings/${camping.slug}/${images[0]}`}
                                                        style={{width: '100%', height: '100%'}}
                                                        class="img-fluid object-fit-cover rounded-start"
                                                        alt={camping.name}
                                                    />
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="card-body d-flex justify-content-between h-100">
                                                        <div class="card-text d-flex flex-column align-items-start">
                                                            <h5 class="card-title fw-semibold">{camping.name}</h5>
                                                            <p class="card-text d-flex justify-content-center align-items-center gap-2">
                                                                <i class="fa-solid fa-location-dot text-danger"></i>
                                                                {camping.location}
                                                            </p>
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-between">
                                                            <div class="d-flex flex-column align-items-end">
                                                                <Rating rating={camping.rating} />
                                                                <span class="card-text fw-semibold">€{camping.price}</span>
                                                                <span>Taxes et frais compris</span>
                                                            </div>
                                                            <Button variant="primary" to={`/campings/${camping.id}`} as={Link}>
                                                                Voir le camping
                                                            </Button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        )
                                    }
                                </div>
                            );
                        })
                    ) : (
                        <p>Aucun Camping à afficher.</p>
                    )}
                </div>
            </div>
        </div>
    );
}

export default CampingsComponent;