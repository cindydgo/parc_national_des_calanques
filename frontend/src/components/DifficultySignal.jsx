const DifficultySignal = ({ level, max = 5 }) => {
    return (
        <div className="d-flex justify-content-center align-items-end gap-1">
            {Array.from({ length: max }).map((_, i) => (
                <div
                key={i}
                style={{
                    width: '6px',
                    height: `${(i + 1) * 6}px`,
                    backgroundColor: i < level ? '#535bf2' : '#2ea6ecd3',
                    borderRadius: '2px'
                }}
                ></div>
            ))}
        </div>
    );
};

export default DifficultySignal;