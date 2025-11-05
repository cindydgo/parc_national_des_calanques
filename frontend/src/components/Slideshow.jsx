import { useState }from "react"
import arrowLeft from '../assets/images/chevron-gauche.png'
import arrowRight from '../assets/images/chevron-droit.png'
import '../assets/css/Slideshow.css'

const Slideshow = ({images}) => {
    const [currentIndex, setCurrentIndex] = useState(0)
    
    const nextSlide = () => {
        setCurrentIndex((prevIndex) =>
        prevIndex + 1 === images.length ? 0 : prevIndex + 1 )
    }
    const prevSlide = () => {
        setCurrentIndex((prevIndex) =>
        prevIndex - 1 < 0 ? images.length - 1 : prevIndex - 1) 
    }

    return (
        <div className="carousel">
            <div className="carousel-container">
                {images.length > 1 && 
                <img 
                    src={arrowLeft} 
                    alt="flèche gauche"
                    className="arrow-left" 
                    onClick={prevSlide} 
                />}
                <div className="slide">
                    <img src={images[currentIndex]} alt={`Slide ${currentIndex}`} />
                </div>
                {images.length > 1 && 
                <img 
                    src={arrowRight} 
                    alt="flèche droite" 
                    className="arrow-right"
                    onClick={nextSlide} 
                />}
                {images.length > 1 && <div className="count">
                    <span> 
                        {currentIndex + 1}/{images.length}
                    </span>
                </div>}
            </div>
        </div>
    )
}

export default Slideshow
