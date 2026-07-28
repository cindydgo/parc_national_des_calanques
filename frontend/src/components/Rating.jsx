const Rating = ({ rating }) => {
    const stars = [];   
    for (let i = 1; i <= 5; i++) {
        if (i <= rating) {
            stars.push(<i key={i} className="fa-solid fa-star text-warning fs-6"></i>);
        } else {
            stars.push(<i key={i} className="fa-regular fa-star text-warning fs-6"></i>);
        }
    }

    return (
        <div className="rating-stars">      
            {stars}
        </div>
    );
}

export default Rating;