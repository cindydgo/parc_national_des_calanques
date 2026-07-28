import { useState }from "react"
import arrowLeft from '/images/slideshow/chevron_left.png'
import arrowRight from '/images/slideshow/chevron_right.png'
import '../assets/css/Slideshow.css'

const Slideshow = ({repertory, images, slug}) => {
    const [currentIndex, setCurrentIndex] = useState(0)
    
    const nextSlide = () => {
        setCurrentIndex((prevIndex) =>
        prevIndex + 1 === images.length ? 0 : prevIndex + 1 )
    }
    const prevSlide = () => {
        setCurrentIndex((prevIndex) =>
        prevIndex - 1 < 0 ? images.length - 1 : prevIndex - 1) 
    }

    const imageSrc = slug
        ? `/images/${repertory}/${slug}/${images[currentIndex]}`
        : images[currentIndex];

    return (
        <div className="carousel">
            <div className="position-relative">
                {images.length > 1 && 
                <img 
                    src={arrowLeft} 
                    alt="flèche gauche"
                    className="arrow start-0" 
                    onClick={prevSlide} 
                />}
                <div className="slide d-flex justify-content-center align-items-center overflow-hidden w-100">
                    <img 
                        src={imageSrc} 
                        className="slideshow-image w-100 h-100"
                        style={{
                            borderTopLeftRadius: slug ? "0.375rem" : "0",
                            borderTopRightRadius: slug ? "0.375rem" : "0",
                        }}
                        alt={`Slide ${currentIndex}`} 
                    />
                </div>
                {images.length > 1 && 
                <img 
                    src={arrowRight} 
                    alt="flèche droite" 
                    className="arrow end-0"
                    onClick={nextSlide} 
                />}
                {images.length > 1 && <div className="position-absolute bottom-0 start-50 translate-middle-x mb-3 badge badge-custom">
                    <span> 
                        {currentIndex + 1}/{images.length}
                    </span>
                </div>}
            </div>
        </div>
    )
}

export default Slideshow
