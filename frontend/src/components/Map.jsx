import '../utils/leafletIconFix'
import { MapContainer, TileLayer, Marker, Popup } from 'react-leaflet'

export default function Map({position, popup, zoom}) {
    return (
        <MapContainer center={position} zoom={zoom} style={{ height: "400px", width: "100%" }}>
        <TileLayer
            url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
        />

        <Marker position={position}>
            <Popup>{popup}</Popup>
        </Marker>
        </MapContainer>
    )
}
