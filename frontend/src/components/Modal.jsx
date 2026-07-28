import {useState} from 'react';
import Box from '@mui/material/Box';
import Button from 'react-bootstrap/Button';
import Modal from '@mui/material/Modal';
import Map from './Map.jsx';

const style = {
    position: 'absolute',
    top: '50%',
    left: '50%',
    transform: 'translate(-50%, -50%)',
    width: 600,
    bgcolor: 'background.paper',
    boxShadow: 24,
};

function BasicModal({position, popup, zoom}) {
    const [open, setOpen] = useState(false);
    const handleOpen = () => setOpen(true);
    const handleClose = () => setOpen(false);

    return (
        <div>
            <Button onClick={handleOpen} variant="success">
                <i class="fa-regular fa-map me-2"></i>Voir sur la carte
            </Button>
            <Modal
                open={open}
                onClose={handleClose}
                aria-labelledby="modal-modal-title"
                aria-describedby="modal-modal-description"
            >
                <Box sx={style}>
                    <Map position={position} popup={popup} zoom={zoom}/>
                </Box>
            </Modal>
        </div>
    );
}

export default BasicModal;
