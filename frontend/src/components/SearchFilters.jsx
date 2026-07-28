import { useState, useEffect } from 'react';
import Router from '../api/Router';
import 'react-range-slider-input/dist/style.css';
import '../assets/css/SearchFilters.css';

const SearchFilters = ({ value, setValue, selectedAmenities, setSelectedAmenities }) => {
    const ratings = [1, 2, 3, 4, 5];
    const [amenities, setAmenities] = useState([]);
    const [success, setSuccess] = useState(false);

    useEffect(() => {
        const HttpAmenities = Router("amenities");

        const amenitiesData = async () => {
            try {
                const fetchResult = await HttpAmenities.getAll();

                if (fetchResult.success) {
                    setAmenities(fetchResult.data);
                    setSuccess(true);
                } else {
                    console.error(fetchResult.errors);
                }
            } catch (err) {
                console.error(err);
            }
        };

        amenitiesData();
    }, []);

    if (!success) {
        return <p>Chargement des filtres…</p>;
    }

    return (
        <div className="search-filters-item d-flex flex-column gap-3">
            <div className="d-flex gap-2 align-items-center fw-semibold me-3">
                <i className="fa-solid fa-sliders"></i>
                Filtres
            </div>
            <div className="d-flex flex-column align-items-start gap-2">
                <span className="fw-semibold">Équipements</span>

                {amenities.map((amenity) => (
                <div key={amenity.id} className="d-flex gap-2">
                    <input
                        id={`amenity-${amenity.id}`}
                        type="checkbox"
                        className="search-checkbox"
                        checked={selectedAmenities.includes(amenity.id)}
                        onChange={(e) => {
                            if (e.target.checked) {
                                setSelectedAmenities([...selectedAmenities, amenity.id]);
                            } else {
                                setSelectedAmenities(
                                    selectedAmenities.filter(id => id !== amenity.id)
                                );
                            }
                        }}
                    />
                    <label for={`amenity-${amenity.id}`}>
                        {amenity.name}
                    </label>
                </div>
                ))}
            </div>
            <div className="d-flex flex-column align-items-start gap-2">
                <span className="fw-semibold">Notes</span>

                {ratings.map((rating) => (
                <div key={rating} className="d-flex align-items-center gap-2">
                    <input
                        id={`rating-${rating}`}
                        type="checkbox"
                        className="search-checkbox"
                    />
                    <label for={`rating-${rating}`}>
                        {rating} étoiles
                    </label>
                </div>
                ))}
            </div>
            <div className="d-flex flex-column gap-2">
                <span className="fw-semibold">Prix</span>
                <input
                    type="range"
                    min={0}
                    max={500}
                    value={value}
                    onChange={(e) => setValue(e.target.value)}
                />
                <label>
                    Prix max : <strong>{value}€</strong>
                </label>
            </div>
        </div>
    );
};

export default SearchFilters;
